<?php 
/**
 * Log类库，文件方式记录日志
 * @package Log
 * @author zhaoshunyao <zhaoshunyao@baidu.com>
 * @since 2011-06-10
 */

class Dapper_Log_File implements Dapper_Log_Interface
{
	protected $_strNormalFile = '';
	
	protected $_strWarningFile = '';
	
	protected $_intOutputLevel = 0xFF;
	
	protected $_strSep = ' ';
	
	protected $_strSepOfLine = "\n";
	
	protected $_arrLogData = array(
		'normal'	=> '',
		'warning'	=> '',
	);
	
	public function __construct($strFilePath, $intOutputLevel=0xFF)
	{
		$this->_setFilePath($strFilePath);
		$this->_intOutputLevel = intval($intOutputLevel);
	}	
	
	public function setOptions($arrConfig)
	{
		if (isset($arrConfig['sep'])) {
			$this->_strSep = $arrConfig['sep'];
		}
		if (isset($arrConfig['sepOfLine'])) {
			$this->_strSepOfLine = $arrConfig['sepOfLine'];
		}
		return $this;
	}
	
	public function check($intLogLevel)
	{
		return (bool)($intLogLevel & $this->_intOutputLevel);
	}
	
	public function log($intLogLevel, $strLog, $strFile, $intLine, $intLogId)
	{
		if (! ($intLogLevel & $this->_intOutputLevel) ) {
			//不需要记录
			return $this;
		}
		$strLogType = 'NOTICE';
		if (isset(Dapper_Log::$arrLogNames[$intLogLevel])) {
			$strLogType = Dapper_Log::$arrLogNames[$intLogLevel];
		}
		$str = $strLogType . $this->_strSep . $intLogId . $this->_strSep . 
				date('Ymd H:i:s') . $this->_strSep . $strFile . ':' . $intLine . $this->_strSep .
				$strLog . $this->_strSepOfLine;
		if ( ($intLogLevel & Dapper_Log::LOG_WARNING) || ($intLogLevel & Dapper_Log::LOG_FATAL)) {
			$this->_arrLogData['warning'] .= $str;
		} else {
			$this->_arrLogData['normal'] .= $str;
		}
		return $this;
	}
	/**
	 * 把数据写入文件
	 */
	public function flush()
	{
		if (! empty($this->_arrLogData['warning'])) {
			file_put_contents($this->_strWarningFile, $this->_arrLogData['warning'], FILE_APPEND);
		}
		if (! empty($this->_arrLogData['normal'])) {
			file_put_contents($this->_strNormalFile, $this->_arrLogData['normal'], FILE_APPEND);
		}
		$this->clean();
		return $this;
	}
	
	public function clean()
	{
		$this->_arrLogData['warning'] = '';
		$this->_arrLogData['normal'] = '';
		return $this;
	}
	
	public function __destruct()
	{
		$this->flush();
	}
	
	protected function _setFilePath($strFilePath)
	{
		$strDir = dirname($strFilePath);
		if (! is_dir($strDir)) {
			@mkdir($strDir, 0755, true);
		}
		$this->_strNormalFile = $strFilePath;
		$this->_strWarningFile = $strFilePath . '.wf';
	}
}