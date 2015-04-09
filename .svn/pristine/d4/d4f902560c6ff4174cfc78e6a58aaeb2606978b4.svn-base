<?php
/**
 * 全局变量配置文件
 *
 * 配置读取示例：
 * $website = Dapper_Global::$config['website'][RUNTIME];
 * 或
 * $website = Dapper_Global::getConfig('website');
 */
 
$config = array();

//网站首页网址
$config['website'] = array(
				'test' => 'http://'.$_SERVER['HTTP_HOST'],
				 'tc' => 'http://ting.baidu.com',
				 'jx' => 'http://ting.baidu.com',
				);

//图片主机配置
$config['image']['uploadhost'] = array(
					'test' => array('bb-space-test05.vm:20610'),
					'tc' => array('10.1.0.1:20610','10.1.0.2:20610'),
					'jx' => array('10.2.0.1:20610','10.2.0.2:20610'),
					);

//图片显示地址
$config['image']['website'] = array(
	'test' => array(
		'big' => 'bb-space-tests00.vm:8090/ting/pic/item/', 
		'small' => 'bb-space-tests00.vm:8090/ting/abpic/item/'
		),
	'tc' => array(
		'big' => 'hiphotos.baidu.com/ting/pic/item/',
		'small' => 'hiphotos.baidu.com/ting/abpic/item/',
		),
	'jx' => array(
		'big' => 'hiphotos.baidu.com/ting/pic/item/',
		'small' => 'hiphotos.baidu.com/ting/abpic/item/',
		),
	);

//站务UID
$config['web_site_manager'] = array(
	'test'	=> 1000,
	'jx'	=> 1,
	'tc'	=> 1,
);

?>