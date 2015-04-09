<?php
/**
 * Action基类
 */

abstract class baseAction
{
	protected $loginInfo = array();
	protected $ownerInfo = array();
	protected $loginUid = 0;
	protected $lookUid = 0;
	protected $tplData  = array();
	protected $template = NULL;
	protected $module = 'ui';

    /* {{{ public function checkLogin($with_vip=false) */
    public function checkLogin($with_vip=false) {
        $this->loginInfo = $this->loginInfo();
        $this->loginUid = intval($this->loginInfo['user_id']);


        if($this->loginUid)
            return true;
        else

            return false;
//
//        $Obj = LibFactory::getInstance('LibMuCenter');
//        $ret = $Obj->checkLogin();
//        $passinfo=$ret['pass_info'] ? $ret['pass_info']:false;
//
//        $userinfo=$this->_userinfo($passinfo);
//        $artist_status = 0;
//
//        if($userinfo['xrank'] & 1 ==1)
//        {
//            $artist_status = 1;
//            $userinfo['pre_artist_id'] = $userinfo['artist_id'];
//            $userinfo['artist_id'] = 0;
//        }
//        $userinfo['artist_id'] = ( $_COOKIE['thankgodfddfr'] && $_SERVER['HTTP_HOST']=='mis.y.baidu.com') ? $_COOKIE['thankgodfddfr']:$userinfo['artist_id'];
//        $userinfo['sponsor_id'] = isset( $_COOKIE['thankgodfddfrsponsor'] ) ? $_COOKIE['thankgodfddfrsponsor']:$userinfo['sponsor_id'];
//        if($userinfo['artist_id'] > 0 )
//        {
//            $artist_status = 2;
//            $artistObj = LibFactory::getInstance('LibArtist');
//            $artist_info=$artistObj->getInfoById($userinfo['artist_id']);
//            $userinfo['artist_info']=$artist_info;
//        }
//
//        if($userinfo['sponsor_id'] > 0)
//        {
//            $spObj = LibFactory::getInstance('LibSponsor');
//            $sponsor_info = $spObj->getSponsorById($userinfo['sponsor_id'], 1);
//
//            $userinfo['sponsor_info'] = $sponsor_info;
//        }
//
//        $this->loginUid=intval($passinfo['uid']);
//        $this->loginName=$passinfo['un'];
//
//        if($userinfo['artist_id'] && !isset($_COOKIE['login_artist'])){	//每日登陆艺人统计
//            setcookie('login_artist', $userinfo['artist_id'], time()+3600, '/','');
//        }



//        if($userinfo && $this->loginUid){
//            $this->loginInfo =!$passinfo? false:array(
//                'user_id'=>$userinfo["user_id"],
//                'user_bdid'=>$this->loginUid,
//                'artist_id'=>( $_COOKIE['thankgodfddfr'] && $_SERVER['HTTP_HOST']=='mis.y.baidu.com') ? $_COOKIE['thankgodfddfr']:$userinfo['artist_id'],
//                'del_status'=>$userinfo['del_status'],
//                //'follow_num'=>intval($followCount['count']),
//                'xrank' => $userinfo['xrank'],
//                'artist_status'=>$artist_status ,
//                'pre_artist_id' => intval($userinfo['pre_artist_id']),
//                //'artist_info'=>$passinfo,						//如果是艺人，此为艺人资料数组，是否是艺人取决于artist_id是否不为0
//                'pass_info'=>$passinfo,							//百度passport返回数组
//                'bindinfo'=>$this->_bindinfo($passinfo),
//                'artist_info'=>$userinfo['artist_info']?$userinfo['artist_info']:false,		//百度passport返回数组
//                'unread_count'=>$count,
//                'msg_unread_count'=>$arrMsgCount ? $arrMsgCount["unread"] + $count : $count,
//                'prize' => $prize,
//                'sponsor_id' => $userinfo['sponsor_id'],
//                'sponsor_info'=>$userinfo['sponsor_info']?$userinfo['sponsor_info']:false,
//                'token' => md5($this->loginUid),
//            );
//        }else $this->loginInfo=false;
    }

    public function init()
    {
    	//初始化全局信息
		//可做统一登录状态等
		//... ...

    	return true;
    }

    abstract public function execute();

	//smarty接口
	public function assign($key, $value)
    {
        Dapper_View_Smarty::assign($key, $value);
    }

    public function display($template)
    {
		$outputType = strip_tags(Dapper_Http_Request::getParam('tn', 'html'));
		$safeType = array('html','json','xml','ajax');
		if(in_array($outputType, $safeType))
		{
			if($outputType == 'json' || $outputType == 'ajax')
			{
				header("Content-type: text/javascript");
			}
			elseif($outputType == 'xml')
			{
				header("Content-Type: text/xml");
			}
			Dapper_View_Smarty::display($template . '.' . $outputType . '.tpl');
		}
		else
		{
			exit('template type is error');
		}
    }


    function echo_json($arr)
    {
        header("Content-type: text/javascript;charset=UTF-8");

        // ****** 跨域相关 ******
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;

        if($referer){
            $urls = parse_url($referer);
            $url = $urls['scheme'] .'://' . $urls['host'];
            isset($urls['port']) ? $url .= ':' .$urls['port'] : '';
        }else{
            $url = '*';
        }

        header("Access-Control-Allow-Origin: " . $url);//跨域访问
        header("Access-Control-Allow-Credentials: true");
//        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        // ****** 跨域相关 *****

        $josnp=Dapper_Http_Request::getParam('callback', null);
        if($josnp && !preg_match("/^[0-9a-zA-Z_.]+$/",$josnp)) { //不让过 防Xss
            exit('callback参数错误！');
        }
//        $josnp=preg_replace('/\W\./i', '', Dapper_Http_Request::getParam('callback', null)); //强过 防Xss

        if($josnp)
            echo $josnp.'('.json_encode($arr).')';
        else
            echo json_encode ($arr);

//        return ;
        return true;
    }

	public function header404()
    {
    	header("HTTP/1.1 404 Not Found");
		$this->display('http_state/404');
		exit;
    }
//    public function header404()
//    {
//        /*
//             header("HTTP/1.1 404 Not Found");
//             $this->display('http_state/404', '404');
//             exit;*/
//        $querystr = '';
//        if(isset($_GET['__session__']))
//        {
//            $ss = $_GET['__session__'] + 1;
//            $str = '__ipipe__&__session__=' . $ss;
//            $search = '__ipipe__&__session__=' . $_GET['__session__'];
//            $querystr = $_SERVER['QUERY_STRING'];
//            $querystr = str_replace($search, $str, $querystr);
//        }
//
//        header('Location:http://'.$_SERVER['HTTP_HOST'].(strlen($querystr) ? '?' . $querystr : ''));
//        //header('Location:http://'.$_SERVER['HTTP_HOST']);
//        exit();
//    }


    /**
     * 用户行为相关
     */
    public function loginInfo()
    {
        $userObj = new LibUser();
        return $userObj->loginInfo();
    }


    public function api_error($code, $msg="unknown error")
    {
        return $this->echo_json(array(
            "errorCode" => $code,
            "msg" => $msg
        ));
    }

    public function api_success($data){
        return $this->echo_json(array(
            'errorCode' => SUCCESS,
            'data' => $data
        ));
    }

    /**
     * 数据库字段映射到json接口的字段，字段为二维数组
     * @param array $mapArr 映射关系数组
     * @param array $mapList 被映射的多维数组
     * @return array|bool
     */
    protected function mapArrays($mapArr = array(),$mapList = array()){
        if(!$mapArr || !$mapList){
            return FALSE;
        }

        $data = array();
        $i = 0;
        foreach($mapList as $list){
            foreach($mapArr as $k=>$v){
                $data[$i][$k] = $list[$v];
            }
            $i++;
        }
        return $data;
    }

    /**
     * 字段输出映射，字段为一位数组
     * @param array $mapArr
     * @param array $mapList
     * @return array|bool
     */
    protected function mapArray($mapArr = array(),$mapList = array()){
        if(!$mapArr || !$mapList){
            return FALSE;
        }

        $data = array();
        foreach($mapArr as $k=>$v){
            $data[$k] = $mapList[$v];
        }
        return $data;
    }

}
