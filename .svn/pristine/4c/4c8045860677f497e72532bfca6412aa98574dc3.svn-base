<?php
/**
 * db测试页
 */
 
class testdbAction extends baseAction
{
	public function execute()
	{
		$userID = (int)Dapper_Http_Request::getParam('userid',3805);
		echo "userID=$userID\n";
		
		$db = new Dal_User();
		$ret = $db->test($userID);
		print_r($ret);
	}
}
?>