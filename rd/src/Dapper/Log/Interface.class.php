<?php
/**
 * 日志接口类
 * @author zhaoshunyao <zhaoshunyao@baidu.com>
 * @since 2011-06-10
 *
 */
interface Dapper_Log_Interface
{
	public function check($intLevel);
	
	public function log($intLogLevel, $strLog, $strFile, $intLine, $intLogId);
	
	public function flush();
}