<?php
/**
 * 日志配置文件
 */

$config['logConfig'] = array(
			'test' => array('ui' => array('file' => LOG_PATH . 'ui.log', 'level' => 0xFF),
							'dal' => array('file' => LOG_PATH . 'dal.log', 'level' => 0xFF),
							'lib' => array('file' => LOG_PATH . 'lib.log', 'level' => 0xFF),
							),
			'tc' => array('ui' => array('file' => LOG_PATH . 'ui.log', 'level' => 0xFF),
							'dal' => array('file' => LOG_PATH . 'dal.log', 'level' => 0xFF),
							'lib' => array('file' => LOG_PATH . 'lib.log', 'level' => 0xFF),
						),
			'jx' => array('ui' => array('file' => LOG_PATH . 'ui.log', 'level' => 0xFF),
							'dal' => array('file' => LOG_PATH . 'dal.log', 'level' => 0xFF),
							'lib' => array('file' => LOG_PATH . 'lib.log', 'level' => 0xFF),
						),
			);

?>
