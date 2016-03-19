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

// 位置数据
// IMSI|IMEI|GDRTYPE|CGI|TIME
// 上网数据
// IMSI|IMEI|CGI|TIME|URL

/**
 * 汇总基站数据表
 * 计算每个用户在不同的时间段不同的基站停留的时长
 * 输入参数 <input path> <output path> <date> <timepoint>
 * 参数示例 "/base /output 2014-09-12 06-09-17-24"
 * 意味着以 "/base" 为输入 "/output" 为输出 指定计算 2014年09月12日的数据 并分为 00-07 07-17 17-24 三个时段
 * 输出格式 "IMSI|CGI|TIMFLAG|STAY_TIME" 
 */ 
public class TrackProcessRun extends Configured implements Tool{

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();
		conf.set("fs.default.name", "hdfs://peng1:9000");
		conf.set("mapred.job.tracker", "peng1:9001");
		conf.set("mapred.jar", "F:\\user.jar");
		
		conf.set("date", "2015-04-26");
		conf.set("timepoint", "09-17-24"); // 设置三个时间段
		
		Job job = new Job(conf, "BaseStationDataPreprocess");
		job.setJarByClass(TrackProcessRun.class);
		
		FileInputFormat.addInputPath(job, new Path("/usr/input/user"));
		FileOutputFormat.setOutputPath(job, new Path("/usr/output/user"));
		
		job.setMapperClass(Map.class); // 调用上面 Map 类作为 Map 任务代码
		job.setReducerClass(Reduce.class); // 调用上面 Reduce 类作为 Reduce 任务代码
		job.setOutputFormatClass(TextOutputFormat.class);
		job.setOutputKeyClass(Text.class);
		job.setOutputValueClass(Text.class);
		return 0;
	}
	
	/**
	 * 计算器
	 * 用于计算各种异常数据
	 */
	enum Counter{
		TIMESKIP,      // 时间格式有误
		OUTOFTIMESKIP, // 时间不在参数指定的时间段内
		LINESKIP,      // 源文件有误
		USERSKIP       // 某个用户某个时间段被整个放弃
	}
	
	/**
	 * 读取一行数据
	 * 以 "IMSI + 时间段" 作为 KEY 发射出去
	 */
	public static class Map extends Mapper<LongWritable, Text, Text, Text> {
		String date; // 今天时间
		String [] timepoint; // 三上时间段
		boolean dataSource; // 区分位置数据还是网络数据
		
		/**
		 * 初始化
		 * 一个 Map 任务执行一次
		 */
		public void setup (Context context) throws IOException {
			this.date = context.getConfiguration().get("date"); // 读取日期
			this.timepoint = context.getConfiguration().get("timepoint").split("-"); // 读取时间分割点
			
			// 提取文件名
			FileSplit fs = (FileSplit) context.getInputSplit();
			String fileName = fs.getPath().getName();
			if (fileName.startsWith("pos")) { // 位置数据
				dataSource = true;
			} else if (fileName.startsWith("net")) { // 网络数据
				dataSource = false;
			} throw new IOException("File Name should starts with POS or NET");
		}
		
		/**
		 * MAP 任务
		 * 读取基站数据
		 * 找出数据所对应时间段
		 * 以 IMSI 和时间段作为 KEY
		 * CGI 和时间作为 VALUE
		 * 一行数据执行一次
		 */
		public void map (LongWritable key, Text value, Context context) throws IOException, InterruptedException {
			String line = value.toString();
			LineParser tableLine = new LineParser();
			
			// 读取行
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
	 * 统计同一个 IMSI 在同一个时间段
	 * 在不同 CGI 停留的时长
	 */
	public static class Reduce extends Reducer<Text, Text, NullWritable, Text> {
		private String date;
		private SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		
		/**
		 * 初始化
		 */
		public void setup (Context context) {
			this.date = context.getConfiguration().get("date");
		}
		
		public void reduce (Text key, Iterable<Text> values, Context context) throws IOException {
			String imsi = key.toString().split("\\|")[0]; // 获取用户
			String timeFlag = key.toString().split("\\|")[1]; // 获取时间段
			
			// 用一个 TreeMap 记录时间
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
				// 在最后添加 "OFF" 位置
				Date tmp = this.formatter.parse(this.date + " " + timeFlag.split("-")[1] + ":00:00");
				uploads.put((tmp.getTime() / 1000L), "OFF");
				
				// 汇总数据
				HashMap<String, Float> locs = getStayTime(uploads);
				
				// 输出
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
		 * 获得位置停留信息
		 */
		private HashMap<String, Float> getStayTime(TreeMap<Long, String> uploads) {
			Entry<Long, String> upload, nextUpload;
			HashMap<String, Float> locs = new HashMap<String, Float>();
			// 初始化
			Iterator<Entry<Long, String>> it = uploads.entrySet().iterator();
			upload = it.next();
			
			// 计算
			while( it.hasNext()) {
				nextUpload = it.next();
				// 超过一小时放弃
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