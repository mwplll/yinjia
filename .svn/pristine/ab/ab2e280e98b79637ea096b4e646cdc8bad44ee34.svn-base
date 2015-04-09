<?php
/**
 * DapperPHP (php轻量级框架)
 * 数据库操作mysqli类库
 * @package		Mysqli
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 * @since		2011-06-10
 */
class Dapper_Model_DB_Mysqli
{
	/**
	 * mysqli instance
	 * @var mysqli
	 */
	protected $dblink = null;

	protected $config = array();

	protected $lastSql = '';

	protected $queryNum = 0;		//SQL查询次数
	protected $querySql = array();	//一次连接MYSQL查询的所有语句
	protected $queryTime = array();	//一次连接MYSQL查询的所有语句运行时间

	/**
	 * DB Constructor
	 *
	 * @param array $config		Config of the db instance, as the following format:
	 * <code>
	 * array(
	 *		 'hosts' => array(ip1, ip2, ...),	// db server ips
	 *		 'username' => '',		// username to access db server
	 * 		 'password' => '',		// password to access db server
	 *		 'database' => '',		// database to access db server
	 *		 'port' => xx,			// db server port
	 *		 'timeout' => xx,		// connect timeout (ms)
	 *		)
	 * </code>
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
		$this->lastSql = '';
		$this->dblink = $this->createConnection();
	}

	/**
	 * db destructor.
	 * It will close all db connections created by current instance.
	 */
	public function __destruct()
	{
		if($this->dblink)
		{
			mysqli_close($this->dblink);
			$this->dblink = null;
		}
	}

	/**
	 * Whether the db is workable.
	 * @return bool
	 */
	public function isOK()
	{
		return !empty($this->dblink);
	}

	/**
	 * Return the mysqli handle of the db instance
	 * @return mysqli
	 */
	public function getHandle()
	{
		return $this->dblink;
	}

	/**
	 * Create db connection according to the config saved
	 */
	protected function createConnection()
	{
		if($this->dblink)
		{
			return $this->dblink;
		}

		$arrHosts = $this->config['hosts'];
		$intHosts = count($arrHosts);
		if($intHosts <= 0)
		{
			return false;
		}

		$mysqli = mysqli_init();
        $intTimeoutSec = $this->config['timeout'] > 3 ? 3 : $this->config['timeout'];
        $bolRet = mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, $intTimeoutSec);
        if(!$bolRet)
        {
            return false;
        }

		shuffle($arrHosts);
		for($i = 0; $i < $intHosts; $i++)
		{
			$host = $arrHosts[$i];
			$bolRet = @mysqli_real_connect($mysqli,$host,$this->config['username'],$this->config['password'],$this->config['database'],$this->config['port']);
			if(!$bolRet)
			{
                //echo 'connect db failed'."\n";
				continue;
			}
			else
			{
				mysqli_set_charset($mysqli, 'utf8');
				return $mysqli;
			}
		}
		return false;
	}

	/**
	 * Perform a query on the database
	 * @param string $strSql	The query string
	 * @return bool Returns true on success or false on failure
	 */
	public function doQuery($strSql)
	{
		if(!$this->dblink)
		{
			return false;
		}

		$startTime = microtime(TRUE);
		$this->lastSql = $strSql;
		$ret = mysqli_query($this->dblink, $this->lastSql);
		$endTime = microtime(TRUE);

		$this->queryNum++;
		$this->querySql[] = $this->lastSql;
		$this->queryTime[] = $endTime - $startTime;


        // TODO 加入更加完善的功能
        if($ret === false)
        {
            $logArr = array(
//                'host' => $this->_lastIP,
                'errno' => $this->getErrno(),
                'errmsg' => $this->getErrmsg(),
                'sql' => $strSql
            );
            Dapper_Log::fatal("S_DB_write_fail:" . $this->getErrMsg(), 'dal', $logArr);
        }


		return $ret;
	}

	/**
	 * Perform a select query on the database and retriev all the result rows
	 * @param string $strSql	The query string
	 * @return bool|array	Return result rows on success or false on failure
	 */
	public function queryAllRows($strSql)
	{
		if(!$this->dblink)
		{
			return false;
		}

		$startTime = microtime(TRUE);
		$this->lastSql = $strSql;
		$objRes = mysqli_query($this->dblink, $this->lastSql);
		if(!$objRes)
		{
			return false;
		}
		$arrResult = array();
		while($arrTmp = mysqli_fetch_assoc($objRes))
		{
			$arrResult[] = $arrTmp;
		}
		$endTime = microtime(TRUE);
		$this->queryNum++;
		$this->querySql[] = $this->lastSql;
		$this->queryTime[] = $endTime - $startTime;

		return $arrResult;
	}

	/**
	 * Perform a select query on the database and retriev the first row in results
	 * @param string $strSql	The query string
	 * @return bool|array	Return result row on success or false on failure
	 */
	public function queryFirstRow($strSql)
	{
		if (!$this->dblink)
		{
			return false;
		}

		$startTime = microtime(TRUE);
		$this->lastSql = $strSql;
		$objRes = mysqli_query($this->dblink, $this->lastSql);
		if(!$objRes)
		{
			return false;
		}

		$arrResult = mysqli_fetch_assoc($objRes);
		$endTime = microtime(TRUE);
		$this->queryNum++;
		$this->querySql[] = $this->lastSql;
		$this->queryTime[] = $endTime - $startTime;

		if($arrResult)
		{
			return $arrResult;
		}
		return false;
	}

	/**
	 * Perform a select query on the database and retriev the specified field value in the first row result
	 * @param string $strSql	The query string
	 * @param bool $isInt		Whether the specified field is integer type
	 * @return bool|int|string	Return field value on success or false on failure
	 */
	public function querySpecifiedField($strSql, $isInt = false)
	{
		if (!$this->dblink)
		{
			return false;
		}

		$startTime = microtime(TRUE);
		$this->lastSql = $strSql;
		$objRes = mysqli_query($this->dblink, $this->lastSql);
		if (!$objRes)
		{
			return false;
		}

		$out = null;
		$arrResult = mysqli_fetch_row($objRes);
		if($arrResult)
		{
			if($isInt)
			{
				$out = intval($arrResult[0]);
			}
			$out = $arrResult[0];
		}
		else
		{
			if($isInt)
			{
				$out = 0;
			}
			$out = null;
		}

		$endTime = microtime(TRUE);
		$this->queryNum++;
		$this->querySql[] = $this->lastSql;
		$this->queryTime[] = $endTime - $startTime;

		return $out;
	}

	/**
	 * Do multiple sql queries as a transaction
	 *
	 * @param array $arrSql	Array of sql queries to be executed
	 * @return bool Returns true on success or false on failure
	 */
	public function doTransaction(array $arrSql)
	{
		if(!$this->dblink)
		{
			return false;
		}

		$startTime = microtime(TRUE);
		mysqli_autocommit($this->dblink, false);
		foreach($arrSql as $strSql)
		{
			$ret =  mysqli_query($this->dblink, $strSql);
			if(!$ret)
			{
				$this->lastSql = $strSql;
				mysqli_rollback($this->dblink);
				mysqli_autocommit($this->dblink, true);
				return false;
			}
		}
		mysqli_commit($this->dblink);
		mysqli_autocommit($this->dblink, true);
		$endTime = microtime(TRUE);
		$this->queryNum++;
		$this->querySql[] = $this->lastSql;
		$this->queryTime[] = $endTime - $startTime;

		return true;
	}

	/**
	 * Get the last inserted data's autoincrement id
	 * @return int
	 */
	public function getLastInsertID()
	{
		return mysqli_insert_id($this->dblink);
	}

	/**
	 * Get number of affected rows of the last SQL query
	 * @return int
	 */
	public function getAffectedRows()
	{
		return mysqli_affected_rows($this->dblink);
	}

	/**
	 * Selects the defaut database for database queries
	 * @param string $database	The database name
	 * @return bool Returns true on success or false on failure
	 */
	public function selectDB($dbname)
	{
		if(!$this->dblink)
		{
			return false;
		}
		return mysqli_select_db($this->dblink, $dbname);
	}

	/**
	 * Escapes special characters in a string for use in a SQL query
	 * @param string $str	String to be escaped
	 * @return bool|string	Return escaped string on success or false on failure
	 */
	public function realEscapeString($str)
	{
		if(!$this->dblink)
		{
			return false;
		}
		return mysqli_real_escape_string($this->dblink, $str);

	}

	/**
	 * Get errno of the last sql query
	 */
	public function getErrno()
	{
		if(!$this->dblink)
		{
			return -1;
		}
		else
		{
			return mysqli_errno($this->dblink);
		}
	}

	/**
	 * Get errmsg of the last sql query
	 */
	public function getErrmsg()
	{
		if (!$this->dblink)
		{
			return 'mysql server not available';
		}
		else
		{
			return mysqli_error($this->dblink);
		}
	}

	/**
	 * 得到最后查询的SQL
	 */
	public function getSqlStr()
	{
		return $this->lastSql;
	}

	/**
	 * 得到查询次数
	 */
	public function getQueryNum()
	{
		return $this->queryNum;
	}

	/**
	 * 得到全部查询的SQL
	 */
	public function getQuerySql()
	{
		return $this->querySql;
	}

	/**
	 * 得到查询的SQL执行时间
	 */
	public function getQueryTime()
	{
		return $this->queryTime;
	}

    /**
     * 传入表名,新对象和代替换的原始对象,生成更新mysql的语句
     * @param $tbname
     * @param $value
     * @param $where
     * @return bool|string
     */
    public function makeUpdateSQL($tbname,$value,$where)
    {
        if(!$tbname || !is_array($value) || !is_array($where) )
            return false;

        $set = '';    //added by mwp 20150105
        $wh = '';

        foreach ($value as $k=>$v)
        {
            $set.= $set ?  ",`$k`='{$v}' " : "`$k`='{$v}'";
        }

        foreach ($where as $k=>$v)
        {
            $wh.= $wh ?  "and `$k`='{$v}' " : "`$k`='{$v}' ";
        }

        $sql = "update `{$tbname}` set $set  where  $wh limit 1;";
        return $sql;
    }

    /**
     * 传入表名和数据,生成插入SQL的语句
     * @param $tbname
     * @param $value
     * @return bool|string
     */
    public function makeInsertSQL($tbname,$value)
    {
        if(!$tbname || !is_array($value) )
            return false;

        $key = '';
        $val = '';
        foreach ($value as $k=>$v)
        {
            $key.= $key ?  ",`$k` " : "`$k`";
            $val.= $val ?  ",'$v' " : "'$v'";
        }

        $sql = "INSERT INTO  `{$tbname}` ($key) VALUES ($val)";
        return $sql;
    }

    /**
     * 传入表明和数据列表，生成批量插入 SQL 的语句
     * @param $tbname
     * @param $value
     * @return string
     */
    public function makeMutiInsertSQL($tbname, $value)
    {
        if(!$tbname || !is_array($value))
            return false;

        $key = '';
        $val = '';
        foreach ($value[0] as $k=>$v)
        {
            $key.= $key ?  ",`$k` " : "`$k`";
            $val.= $val ?  ",'$v' " : "'$v'";
        }

        for($i = 1; $i < count($value) ; $i++ )
        {
            $val .= '),(';
            $_val = '';
            foreach ($value[$i] as $k => $v)
            {
                $_val.= $_val ?  ",'$v' " : "'$v'";
            }
            $val .= $_val;
        }
        $sql = "INSERT INTO `{$tbname}` ($key) VALUES ($val)";
        return $sql;
    }
}
