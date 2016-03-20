package phone.peng.com;

public class WeiboTest {
	/**
	 * 发布微博内容
	 * 查看关注人 取消关注
	 * 查看我的粉丝
	 * 查看我关注人的微博列表
	 * 我发布的微博列表
	 * 
	 * 
	 * 表一 微博表
	 * rowkey : UID_WID
	 * cf1    : 微博基本信息
	 * 
	 * 表二 用户表关注表
	 * rowkey : UID
	 * cf1    : 
	 * 
	 * 表三 粉丝表
	 * rowkey : UID_U1
	 * cf1    :
	 * 
	 * 表四 微博收件箱
	 * rowkey : UID
	 * cf1    : 微博表的 rowkey (UID_WID) 保存的最小版本为 1000
	 * 
	 * 发布策博功能 取消关注的功能
	 */

}
