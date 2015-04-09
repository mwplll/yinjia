<?php
/**
 * Log��⣨net��ʽ��¼��־��
 * @package Log
 * @author zhaoshunyao <zhaoshunyao@baidu.com>
 * @since 2011-06-10
 */

class Dapper_Log_Net implements Dapper_Log_Interface
{
    /**
    'path' => 'stat-log',
    'filename' => 'ui',
    'ip' => '10.81.47.216',
    'port' => 9898,
    'level' => 16, 
    'compress' => 0,
    'auth' => 'tieba',
    'connectlife' => -1, 
    'read_timeout' => 500,
    'connect_timeout' => 10, 
     * @var unknown_type
     */
    
    protected $_arrConfig  = array();
    
    protected $_intWriteMs = 500;//д��ʱʱ��
    
    protected $_resConn    = NULL;
    
    public function __construct($arrConfig=array())
    {
        if (! get_loaded_extensions('netcomlog')) {
			trigger_error('The netcomlog extension must be loaded for using Dapper_Log_Net!', E_USER_WARNING);
        }
        if (! empty($arrConfig)) {
            $this->setOptions($arrConfig);
        }
    }
    
    public function setOptions($arrConfig)
    {
        $this->_arrConfig = (array) $arrConfig;
        if (isset($arrConfig['write_timeout'])) {
            $this->_intWriteMs = intval($arrConfig['write_timeout']);
        }
    }
    
    public function connect()
    {
        if (is_null($this->_resConn)) {
            $this->_resConn = netcomlog_open($this->_arrConfig, $this->_intWriteMs);
            if (! $this->_resConn) {
                trigger_error('netcomlog_open error!', E_USER_WARNING);
		$this->_resConn = NULL;
                return false;
            }
        }
        return true;
    }
    
    public function check($intLevel)
    {
        return true;
    }
	
	public function log($intLogLevel, $strLog, $strFile='', $intLine='', $intLogId='')
	{
	    return netcomlog_write($intLogLevel, "%s", $strLog);
	}
	
    public function getErrno()
	{
		return netcomlog_errno();
	}
	
	public function getErrmsg()
	{
		if (netcomlog_errno() != 0) {
			return netcomlog_error_message();
		}
		return '';
	}
	
	public function flush()
	{
	    netcomlog_flush();
	}
	
	public function __destruct()
	{
	    if (! is_null($this->_resConn)) {
	        netcomlog_close($this->_arrConfig['ip'], $this->_arrConfig['port'], $this->_arrConfig['path'],
				$this->_arrConfig['filename'], $this->_arrConfig['auth']);
	    }
	}
}
