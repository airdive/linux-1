package user.peng.com;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map.Entry;
import java.util.TreeMap;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.NullWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.Reducer.Context;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.input.FileSplit;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.mapreduce.lib.output.TextOutputFormat;
import org.apache.hadoop.util.Tool;

// λ������
// IMSI|IMEI|GDRTYPE|CGI|TIME
// ��������
// IMSI|IMEI|CGI|TIME|URL

/**
 * ���ܻ�վ���ݱ�
 * ����ÿ���û��ڲ�ͬ��ʱ��β�ͬ�Ļ�վͣ����ʱ��
 * ������� <input path> <output path> <date> <timepoint>
 * ����ʾ�� "/base /output 2014-09-12 06-09-17-24"
 * ��ζ���� "/base" Ϊ���� "/output" Ϊ��� ָ������ 2014��09��12�յ����� ����Ϊ 00-07 07-17 17-24 ����ʱ��
 * �����ʽ "IMSI|CGI|TIMFLAG|STAY_TIME" 
 */ 
public class TrackProcessRun extends Configured implements Tool{

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();
		conf.set("fs.default.name", "hdfs://peng1:9000");
		conf.set("mapred.job.tracker", "peng1:9001");
		conf.set("mapred.jar", "F:\\user.jar");
		
		conf.set("date", "2015-04-26");
		conf.set("timepoint", "09-17-24"); // ��������ʱ���
		
		Job job = new Job(conf, "BaseStationDataPreprocess");
		job.setJarByClass(TrackProcessRun.class);
		
		FileInputFormat.addInputPath(job, new Path("/usr/input/user"));
		FileOutputFormat.setOutputPath(job, new Path("/usr/output/user"));
		
		job.setMapperClass(Map.class); // �������� Map ����Ϊ Map �������
		job.setReducerClass(Reduce.class); // �������� Reduce ����Ϊ Reduce �������
		job.setOutputFormatClass(TextOutputFormat.class);
		job.setOutputKeyClass(Text.class);
		job.setOutputValueClass(Text.class);
		return 0;
	}
	
	/**
	 * ������
	 * ���ڼ�������쳣����
	 */
	enum Counter{
		TIMESKIP,      // ʱ���ʽ����
		OUTOFTIMESKIP, // ʱ�䲻�ڲ���ָ����ʱ�����
		LINESKIP,      // Դ�ļ�����
		USERSKIP       // ĳ���û�ĳ��ʱ��α���������
	}
	
	/**
	 * ��ȡһ������
	 * �� "IMSI + ʱ���" ��Ϊ KEY �����ȥ
	 */
	public static class Map extends Mapper<LongWritable, Text, Text, Text> {
		String date; // ����ʱ��
		String [] timepoint; // ����ʱ���
		boolean dataSource; // ����λ�����ݻ�����������
		
		/**
		 * ��ʼ��
		 * һ�� Map ����ִ��һ��
		 */
		public void setup (Context context) throws IOException {
			this.date = context.getConfiguration().get("date"); // ��ȡ����
			this.timepoint = context.getConfiguration().get("timepoint").split("-"); // ��ȡʱ��ָ��
			
			// ��ȡ�ļ���
			FileSplit fs = (FileSplit) context.getInputSplit();
			String fileName = fs.getPath().getName();
			if (fileName.startsWith("pos")) { // λ������
				dataSource = true;
			} else if (fileName.startsWith("net")) { // ��������
				dataSource = false;
			} throw new IOException("File Name should starts with POS or NET");
		}
		
		/**
		 * MAP ����
		 * ��ȡ��վ����
		 * �ҳ���������Ӧʱ���
		 * �� IMSI ��ʱ�����Ϊ KEY
		 * CGI ��ʱ����Ϊ VALUE
		 * һ������ִ��һ��
		 */
		public void map (LongWritable key, Text value, Context context) throws IOException, InterruptedException {
			String line = value.toString();
			LineParser tableLine = new LineParser();
			
			// ��ȡ��
			try {
				tableLine.set(line, this.dataSource, this.date, this.timepoint);
			} catch (LineException e) {
				if (e.getFlag() == -1) {
					context.getCounter(Counter.OUTOFTIMESKIP).increment(1);
				} else {
					context.getCounter(Counter.TIMESKIP).increment(1);
				}
				return;
			} catch (Exception e) {
				context.getCounter(Counter.LINESKIP).increment(1);
			}
			context.write(tableLine.outKey(), tableLine.outValue());
		}
	}
	
	/**
	 * ͳ��ͬһ�� IMSI ��ͬһ��ʱ���
	 * �ڲ�ͬ CGI ͣ����ʱ��
	 */
	public static class Reduce extends Reducer<Text, Text, NullWritable, Text> {
		private String date;
		private SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		
		/**
		 * ��ʼ��
		 */
		public void setup (Context context) {
			this.date = context.getConfiguration().get("date");
		}
		
		public void reduce (Text key, Iterable<Text> values, Context context) throws IOException {
			String imsi = key.toString().split("\\|")[0]; // ��ȡ�û�
			String timeFlag = key.toString().split("\\|")[1]; // ��ȡʱ���
			
			// ��һ�� TreeMap ��¼ʱ��
			TreeMap<Long, String> uploads = new TreeMap<Long, String>();
			String valueString;
			
			for (Text value : values) {
				valueString = value.toString();
				
				try {
					uploads.put(Long.valueOf(valueString.split("\\|")[1]), valueString.split("\\|")[0]);
				} catch (NumberFormatException e) {
					context.getCounter(Counter.TIMESKIP).increment(1);
					continue;
				}
			}
			try {
				// �������� "OFF" λ��
				Date tmp = this.formatter.parse(this.date + " " + timeFlag.split("-")[1] + ":00:00");
				uploads.put((tmp.getTime() / 1000L), "OFF");
				
				// ��������
				HashMap<String, Float> locs = getStayTime(uploads);
				
				// ���
				for (Entry<String, Float> entry : locs.entrySet()) {
					StringBuilder builder = new StringBuilder();
					builder.append(imsi).append("|");
					builder.append(entry.getKey()).append("|");
					builder.append(timeFlag).append("|");
					builder.append(entry.getValue());
					
					context.write(NullWritable.get(), new Text(builder.toString()));
				}
			} catch (Exception e) {
				context.getCounter(Counter.USERSKIP).increment(1);
				return;
			}
		}
		
		/**
		 * ���λ��ͣ����Ϣ
		 */
		private HashMap<String, Float> getStayTime(TreeMap<Long, String> uploads) {
			Entry<Long, String> upload, nextUpload;
			HashMap<String, Float> locs = new HashMap<String, Float>();
			// ��ʼ��
			Iterator<Entry<Long, String>> it = uploads.entrySet().iterator();
			upload = it.next();
			
			// ����
			while( it.hasNext()) {
				nextUpload = it.next();
				// ����һСʱ����
				float diff = (nextUpload.getKey() - upload.getKey()) / 60.0f;
				if (diff <= 60.0) {
					if (locs.containsKey(upload.getValue())) {
						locs.put(upload.getValue(), locs.get(upload.getValue()) + diff);
					} else {
						locs.put(upload.getValue(), diff);
					}
				}
				upload = nextUpload;
			}
			return locs;
		}
	}
	
}