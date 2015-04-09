<?php
/**
 * 数据库配置文件
 */

//主库
$config['db']['zjd'] = array(
		'test' => array(
						'hosts' => array('121.40.102.93'),
						'port' => 3306,
						'database' => 'zjd',
						'username' => 'zjd',
						'password' => 'root',
						'timeout' => 5, //sec
						'adapter' => 'mysqli',

				),

		'tc' => array(
						'hosts' => array('10.0.0.1','10.0.0.2'),
						'port' => 4101,
						'database' => 'ns_ting',
						'username' => 'ns_ting_web_w',
						'password' => '',
						'timeout' => 1,
						'adapter' => 'mysqli',
					),
		'jx' => array(
						'hosts' => array('10.0.0.3','10.0.0.4'),
						'port' => 4101,
						'database' => 'ns_ting',
						'username' => 'ns_ting_web_w',
						'password' => '',
						'timeout' => 1,
						'adapter' => 'mysqli',
					),
);

//统计库
$config['db']['ns_ting_hot'] = array(
		'test' => array(
						'hosts' => array('127.0.0.1'),
						'port' => 3306,
						'database' => 'ns_ting_hot',
						'username' => 'root',
						'password' => '',
						'timeout' => 2,
						'adapter' => 'mysqli',

				),
		'tc' => array(
						'hosts' => array('10.0.0.1','10.0.0.1'),
						'port' => 4101,
						'database' => 'ns_ting_hot',
						'username' => 'ns_ting_hot_w',
						'password' => '',
						'timeout' => 2,
						'adapter' => 'mysqli',
					),
		'jx' => array(
						'hosts' => array('10.0.0.3','10.0.0.4'),
						'port' => 4101,
						'database' => 'ns_ting_hot',
						'username' => 'ns_ting_hot_w',
						'password' => '',
						'timeout' => 2,
						'adapter' => 'mysqli',
					),
);
?>
