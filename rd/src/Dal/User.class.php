<?php
/**
 * dal数据访问层
 *
 * 用户数据操作类(示例)
 * @package		User
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
*/

class Dal_User
{
	protected $db = null;

	public function __construct()
	{
		Dapper_Model_DB::getInstance(Dapper::$config['dbConfig']['zjd'][RUNTIME]);
		$this->db = Dapper_Model_DB::$instances['zjd'];
	}
	
	/**
	 * 提取用户信息
	 * @param int $userID
	 * @return array
	 */
	public function test($userID)
	{
        $sql = "SELECT * FROM ting_user_base_info WHERE ting_uid='$userID' LIMIT 1";
        $row = $this->db->queryFirstRow($sql);
        return $row;
	}
}

?>