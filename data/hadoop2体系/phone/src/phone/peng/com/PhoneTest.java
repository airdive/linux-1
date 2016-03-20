package phone.peng.com;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.hbase.Cell;
import org.apache.hadoop.hbase.HBaseConfiguration;
import org.apache.hadoop.hbase.HColumnDescriptor;
import org.apache.hadoop.hbase.HTableDescriptor;
import org.apache.hadoop.hbase.client.Get;
import org.apache.hadoop.hbase.client.HBaseAdmin;
import org.apache.hadoop.hbase.client.HTable;
import org.apache.hadoop.hbase.client.Put;
import org.apache.hadoop.hbase.client.Result;
import org.apache.hadoop.hbase.client.ResultScanner;
import org.apache.hadoop.hbase.client.Scan;
import org.junit.Test;

public class PhoneTest {
	
	@Test
	public void createtest() throws Exception {
		Configuration conf = HBaseConfiguration.create();
		conf.set("hbase.zookeeper.quorum", "peng1,peng2,peng3");
		HBaseAdmin admin = new HBaseAdmin(conf);
		String table = "t_cdr";
		if (admin.isTableAvailable(table)) {
			admin.disableTable(table);
			admin.deleteTable(table);
		} else {
			HTableDescriptor htd = new HTableDescriptor(table.getBytes());
			HColumnDescriptor cf1 = new HColumnDescriptor("cf1".getBytes());
			// cf1.setMaxVersions(10);
			htd.addFamily(cf1);
			admin.createTable(htd);
		}
		admin.close();
	}
	
	@Test
	public void inserttest() throws Exception {
		Configuration conf = HBaseConfiguration.create();
		conf.set("hbase.zookeeper.quorum", "peng1,peng2,peng3");
		
		HTable table = new HTable(conf, "t_cdr");
		String rowkey = "13585593461_" + System.currentTimeMillis();
		Put put = new Put(rowkey.getBytes());
		put.add("cf1".getBytes(), "dest".getBytes(), "15888886666".getBytes());
		put.add("cf1".getBytes(), "type".getBytes(), "1".getBytes());
		put.add("cf1".getBytes(), "time".getBytes(), "2015-09-09 17:00:00".getBytes());
		table.put(put);
		table.close();
	}
	
	@Test
	public void selecttest() throws Exception {
		Configuration conf = HBaseConfiguration.create();
		conf.set("hbase.zookeeper.quorum", "peng1,peng2,peng3");
		
		HTable table = new HTable(conf, "t_cdr");
		Get get = new Get("13585593461_1458460058321".getBytes());
		Result res = table.get(get);
		Cell c1 = res.getColumnLatestCell("cf1".getBytes(), "type".getBytes());
		System.out.println(new String (c1.getValue()));
		Cell c2 = res.getColumnLatestCell("cf1".getBytes(), "dest".getBytes());
		System.out.println(new String (c2.getValue()));
		Cell c3 = res.getColumnLatestCell("cf1".getBytes(), "time".getBytes());
		System.out.println(new String (c3.getValue()));
		
		// rowkey 按照字典排序
		Scan scan = new Scan();
		scan.setStartRow("13585593461_1458460058321".getBytes()); // 开始行
		scan.setStopRow("13585593461_1458460058321".getBytes()); // 结束行
		ResultScanner rs = table.getScanner(scan);
		for (Result r : rs) {
			Cell cell = r.getColumnLatestCell("cf1".getBytes(), "time".getBytes());
			System.out.println(new String (cell.getValue()));
		}
		table.close();
	}
}
