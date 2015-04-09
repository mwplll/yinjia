<?php
/**
 * 测试页 hello world!
 */
 
class helloWorldAction extends baseAction
{
	public function execute()
	{
		echo 'hello world!';
		//$par = Dapper_Http_Request::getAllParams();
		//print_r($par);

	}
}
?>