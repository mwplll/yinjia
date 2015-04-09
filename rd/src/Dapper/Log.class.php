<?php
/**
 * DapperPHP (php轻量级框架)
 * 日志类
 * @package		Dapper_Log
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 * @since		2011-10-12
 */
class Dapper_Log
{
    /**
     * none
     * @var int
     */
    const LOG_NONE  	= 0x00;

    /**
     * Fatal
     * @var int
     */
    const LOG_FATAL 	= 0x01;

    /**
     * Warning
     * @var int
     */
    const LOG_WARNING	= 0x02;

    /**
     * notice
     * @var int
     */
    const LOG_NOTICE	= 0x04;

    /**
     * debug
     * @var int
     */
    const LOG_DEBUG		= 0x08;

    /**
     * mark
     * @var int
     */
    const LOG_MARK		= 0x10;

    /**
     * all
     * @var int
     */
    const LOG_ALL		= 0xFF;
    /**
     * level to text
     * @var array
     */
    public static $arrLogNames = array(
        self::LOG_FATAL 	=> 'FATAL',
        self::LOG_WARNING	=> 'WARNING',
        self::LOG_NOTICE	=> 'NOTICE',
        self::LOG_DEBUG		=> 'DEBUG',
        self::LOG_MARK		=> 'MARK',
    );
    /**
     * module => obj log
     * @var array
     */
    protected static $_arrLogs = array();
    protected static $_timeStart = array();
    protected static $_strDefaultModule = '';

    protected static $_intLogId = 0;
    /**
     * 初始化
     * @param array $arrConfig
     * {
     * 		module => array(
     * 			'file' => '',
     * 			'level' => 0xFF,
     * 		)
     * }
     * @param string $strDefaultModule
     */
    public static function init($arrConfig = array(), $strDefaultModule = '')
    {
        if(!empty($arrConfig))
        {
            foreach($arrConfig as $_strModule => $_arrConf)
            {
                if(isset($_arrConf['file']))
                {
                    $_intLevel = 0xFF;
                    if (isset($_arrConf['level'])) $_intLevel = intval($_arrConf['level']);
                    self::addModule($_strModule, new Dapper_Log_File($_arrConf['file'], $_intLevel));
                }
            }
        }
        self::$_strDefaultModule = $strDefaultModule;
    }

    public static function getLogId()
    {
        return self::_getLogId();
    }

    public static function addModule($strModule, $objLog)
    {
        self::$_arrLogs[$strModule] = $objLog;
    }

    public static function getModule($strModule = '')
    {
        if ($strModule === false)
        {
            //说明完全是关闭log的，方便在其他的库类使用。
            return false;
        }
        if (empty($strModule)) $strModule = self::$_strDefaultModule;
        if (isset(self::$_arrLogs[$strModule]))
        {
            return self::$_arrLogs[$strModule];
        }
        return self::$_arrLogs[self::$_strDefaultModule];
    }

    public static function fatal($strLog, $strModule='',$opt=null, $strFile='', $intLine=0, $intTraceLevel=0, $costkey=null)
    {
        return self::_log(self::LOG_FATAL, $strLog, $strModule, $strFile, $intLine, $intTraceLevel,$opt, $costkey);
    }

    public static function warning($strLog, $strModule='',$opt=null, $strFile='', $intLine=0, $intTraceLevel=0, $costkey=null)
    {
        return self::_log(self::LOG_WARNING, $strLog, $strModule, $strFile, $intLine, $intTraceLevel,$opt, $costkey);
    }

    public static function notice($strLog, $strModule='',$opt=null, $strFile='', $intLine=0, $intTraceLevel=0, $costkey=null)
    {
        return self::_log(self::LOG_NOTICE, $strLog, $strModule, $strFile, $intLine, $intTraceLevel,$opt, $costkey);
    }

    public static function debug($strLog, $strModule='', $opt=null, $strFile='', $intLine=0, $intTraceLevel=0, $costkey=null)
    {
        if( DEBUG )
        {
            return self::_log(self::LOG_DEBUG, $strLog, $strModule, $strFile, $intLine, $intTraceLevel,$opt, $costkey);
        }
    }

    public static function mark($strLog, $strModule='', $opt=null, $strFile='', $intLine=0, $intTraceLevel=0,$costkey=null)
    {
        return self::_log(self::LOG_MARK, $strLog, $strModule, $strFile, $intLine, $intTraceLevel,$opt, $costkey);
    }

    protected static function _log($intLogLevel, $strLog, $strModule, $strFile='', $intLine=0, $intTraceLevel=0, $opt=array(), $costkey=null)
    {

        if(RUNTIME=='test'){
            echo $strLog;
        }

        $objLog = self::getModule($strModule);
        if($objLog)
        {
            //检查是否需要记录
            if ($objLog->check($intLogLevel))
            {
                if (empty($strFile))
                {
                    $arrRet = self::_getFileAndLine($intTraceLevel);
                    if (isset($arrRet['file'])) $strFile = $arrRet['file'];
                    if (isset($arrRet['line'])) $intLine = $arrRet['line'];
                }
                $intLogId = self::_getLogId();

//                $optstr = "";
//                if($opt!=null && count($opt) > 0 )
//                {
//                    foreach($opt as $k=>$v)
//                    {
//                        if( is_array($v) )
//                        {
//                            $v = join(",",$v);
//                        }
//                        $optstr .= $k . '[' . urlencode($v) .']';
//                    }
//                }

//                $timeUsed = self::getCostMsec($costkey);
                $_strLog = sprintf('url[%s] ref[%s] ip[%s] msg[%s]',
                    isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
                    isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                    self::getClientIP(),
                    $strLog//,
//                    $baiduid,
//                    $GLOBALS['websource'],
//                    $timeUsed
                );

                if(count($opt) > 0)
                {
                    $_strLog .= ' ' . json_encode($opt);
                }
                return $objLog->log($intLogLevel, $_strLog, $strFile, $intLine, $intLogId);
            }
        }
        return false;
    }

    protected static function _getFileAndLine($intLevel = 0)
    {
        $arrTrace = debug_backtrace();
        $intDepth = 2 + $intLevel;
        $intTraceDepth = count($arrTrace);
        if($intDepth > $intTraceDepth)
        {
            $intDepth = $intTraceDepth;
        }
        $arrRet = $arrTrace[$intDepth];
        if(isset($arrRet['file']))
        {
            $arrRet['file'] = basename($arrRet['file']);
        }
        return $arrRet;
    }

    protected static function _getLogId()
    {
        if(empty(self::$_intLogId))
        {
            if(defined('REQUEST_ID'))
            {
                self::$_intLogId = REQUEST_ID;
            }
            else
            {
                $requestTime = gettimeofday();
                self::$_intLogId = intval($requestTime['sec'] * 100000 + $requestTime['usec'] / 10) & 0x7FFFFFFF;
            }
        }
        return self::$_intLogId;
    }

    public static function getClientIP($hasTransmit = false)
    {
        $strIp = '';
        if(isset($_SERVER['HTTP_CLIENTIP']))
        {
            $strIp = strip_tags($_SERVER['HTTP_CLIENTIP']);
        }
        elseif(!$hasTransmit && isset($_SERVER['REMOTE_ADDR']))
        {
            $strIp = strip_tags($_SERVER['REMOTE_ADDR']);
        }
        elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $strIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            //获取最后一个
            $strIp = strip_tags(trim($strIp));
            $intPos = strrpos($strIp, ',');
            if($intPos > 0)
            {
                $strIp = substr($strIp, $intPos + 1);
            }
        }
        elseif(isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $strIp = strip_tags($_SERVER['HTTP_CLIENT_IP']);
        }
        elseif(isset($_SERVER['REMOTE_ADDR']))
        {
            $strIp = strip_tags($_SERVER['REMOTE_ADDR']);
        }
        $strIp = trim($strIp);
        if(!ip2long($strIp))
        {
            $strIp = '127.0.0.1';
        }

        return $strIp;
    }
    public static function seedMsec($key=null)
    {
        if ($key != null)
        {
            self::$_timeStart['custom'][$key] = microtime ( true );
        }else{
            self::$_timeStart['random'][] = microtime ( true );
        }
    }
    public static function getCostMsec($key=null)
    {
        if ($key != null)
        {
            if (is_array(self::$_timeStart['custom']) && self::$_timeStart['custom'][$key] > 0)
            {
                $timeStart = self::$_timeStart['custom'][$key];
                $timeEnd = microtime ( true );
                $timeUsed = intval ( ($timeEnd - $timeStart) * 1000 );
                return $timeUsed;
            }else{
                return 0;
            }
        }
        else
        {
            if (is_array(self::$_timeStart['random']) && count(self::$_timeStart['random']) > 0)
            {
                $timeStart = array_pop (self::$_timeStart['random']);
                $timeEnd = microtime ( true );
                $timeUsed = intval ( ($timeEnd - $timeStart) * 1000 );
                return $timeUsed;
            }else{
                return 0;
            }
        }
        return 0;
    }
}
