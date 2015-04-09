<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-8
 * Time: 下午2:00
 */

class userRegisterApiAction extends baseAction
{
    public function execute()
    {
        $userObj =  new LibUser(); //LibFactory::getInstance('LibUser');

        $act = Dapper_Http_Request::getParam('act', 'add');
        $tel = Dapper_Http_Request::getParam('tel','');
        $code = Dapper_Http_Request::getParam('code','');
        $userName = Dapper_Http_Request::getParam('userName','');
        $passwd = Dapper_Http_Request::getParam('pwd');

        //echo '$code = '.$code."\n";
        //echo '$tel = '.$tel."\n";

        if('add' == $act){
            // 创建用户
            if($tel && $userName && $passwd && $code){
                session_start();

                $captcha = isset($_SESSION['reg_captcha']) ? $_SESSION['reg_captcha'] : "";
                $sessionTel = isset($_SESSION['user_tel']) ? $_SESSION['user_tel'] : "";
                //echo '$captcha = '.$captcha."\n";
                //echo '$sessionTel = '.$sessionTel."\n";
                if(($captcha != $code) || ($tel != $sessionTel)){
                    return $this->fail('code error输入的验证码不正确，请确认后重新输入！');
                }

                // 验证用户名
                $msg = $this->_validateName($userName);
                if ($msg !== true){
                    return $this->fail($msg);
                }
                // 验证手机号码
                $msg = $this->_validateTel($tel);
                if($msg !== true){
                    return $this->fail($msg);
                }

                $ret = $userObj->addUser(array(
                    'user_tel' => $tel,
                    'user_name' => $userName,
                    'user_passwd' => $passwd,
                    'create_time' => time()
                ));

                if($ret){
                    $tplData['errorCode'] = SUCCESS;
                    $userObj->login($userName, $passwd);
                }else{
                    $tplData['errorCode'] = FAILED;
                    $tplData['msg'] = '用户名或者手机号已存在，无法完成注册!';
                }

                return $this->echo_json($tplData);
            }else{
                return $this->fail("请输入userName, tel, passwd 完成注册");
            }
        }else if('check' == $act){
            // 检查是否可用
            if($tel){
                $ret = $userObj->getUserByTel($tel);
                if($ret){
                    return $this->fail("该手机帐号已存在");
                }
            }
            if($userName){
                $ret = $userObj->getUserByName($userName);
                if($ret){
                    return $this->fail("该用户名已存在");
                }
            }
            $tplData['errorCode'] = SUCCESS;
            return $this->echo_json($tplData);
        }
    }

    private function _validateName($str){
        $nameLen = strlen($str);
        if( $nameLen < 6 || $nameLen > 24 ){
            return "用户名的长度必须要在6~24个字符之间";
        }
        return true;
    }

    private function _validateTel($str){
        // 手机号长度必须为1
        // TODO 校验数字是否为手机号
        if(!preg_match("/^1[34578][0-9]{9}$/", $str)){
            return "手机号码必须为11位数字";
        }
        return true;
    }

    private function fail($msg){
        return $this->echo_json(array(
            "errorCode" => FAILED,
            "msg" => $msg
        ));
    }
}

/**
 * 音乐人注册信息保存
 *
define('SUCCESS', 22000);//操作成功
define('FAILED', 22001);//操作失败
define('PARAM_ERROR', 22005);//参数错误
 */
/*
class registerArtistApiAction extends baseAction
{
    public function execute()
    {
        $this->ajaxLoginOption();

        $artist_id=$this->loginInfo['artist_id'];
        $artistObj = LibFactory::getInstance('LibArtist');

        //判断是否是二次审核用户
        if($artist_id > 0 ){
            $artist_info=$artistObj->getInfoById($artist_id);
            if(!$artist_info || $artist_info['verify_status'] != 1 || $artist_info['del_status'] != 1)
            {
                $tplData ['errorCode'] =FAILED;
                $this->echo_json($tplData);
                return ;
            }
        }

        $baseObj = LibFactory::getInstance('LibBase');

        $isBand=Dapper_Http_Request::getParam('isBand','false');
        $name=Dapper_Http_Request::getParam('name','');
        $genre=Dapper_Http_Request::getParam('genre','');
        $style=Dapper_Http_Request::getParam('style','');
        $style_ids=trim(Dapper_Http_Request::getParam('style_ids',','));
        $gender=intval(Dapper_Http_Request::getParam('gender',0));
        $birth=Dapper_Http_Request::getParam('birth','');

        $city_id_0=intval(Dapper_Http_Request::getParam('province',0));
        $city_id_1=intval(Dapper_Http_Request::getParam('city',0));
        $email = Dapper_Http_Request::getParam('email','');

        $phone = Dapper_Http_Request::getParam('phone','');
        $company=Dapper_Http_Request::getParam('company','');
        $domain=strtolower($this->fkStr(Dapper_Http_Request::getParam('domain','')));

        $realname=Dapper_Http_Request::getParam('realName','');
        $idcard=Dapper_Http_Request::getParam('idCard','');

        $relate_artist_name = Dapper_Http_Request::getParam('relateArtistName','');

        $avatar=Dapper_Http_Request::getParam('avatar','');

        $demoSongId = intval(Dapper_Http_Request::getParam('demo_song_id',0));


        if(!$realname || !$idcard || !$name || !$genre || !$city_id_0 || !$city_id_1 || !$email || !$phone || !$demoSongId || !$avatar){
            $tplData ['errorCode'] =PARAM_ERROR;
            $this->echo_json($tplData);
            return ;
        }

        $genre_list=$baseObj->getGenreId();
        if(!isset($genre_list[$genre]))
        {
            $tplData ['errorCode'] =PARAM_ERROR;
            $this->echo_json($tplData);
            return ;
        }

        $genreId = $genre_list[$genre];

        $songObj = LibFactory::getInstance('LibSong');
        $tmpSong = $songObj->getTmpSong($demoSongId);
        if(!$tmpSong)
        {
            $tplData ['errorCode'] =PARAM_ERROR;
            $this->echo_json($tplData);
            return ;
        }
        $tmpSongInfo = $tmpSong[0];


        $value=array();

        if($isBand==='true'){

            if(!$style_ids || !$relate_artist_name)
            {
                $tplData ['errorCode'] =PARAM_ERROR;
                $this->echo_json($tplData);
                return ;
            }

            $value['gender']=3;
            $value['relate_artist_name']=$relate_artist_name;
        }
        else{

            if(!$gender || !$birth)
            {
                $tplData ['errorCode'] =PARAM_ERROR;
                $this->echo_json($tplData);
                return ;
            }

            $value['gender']=$gender;
            $value['birth']=$birth;
        }

        $ting_uid = Dapper_Http_Request::getParam('tingUid',0);
        $quku_artist_id = 0;
        if($ting_uid > 0)
        {//从mfd取曲库id
            $mfd = new LibMfd();
            $mret = $mfd->artist($ting_uid, 1);
            $quku_artist_id = $mret[$ting_uid]['artist_id'];
        }
        $value['quku_artist_id'] = $quku_artist_id ? $quku_artist_id : 0;
        $value['ting_uid'] = $ting_uid;
        $value['quku_artist_id'] = $quku_artist_id;

        $tmp=array('name','style','style_ids','company','genre','city_id_0','city_id_1');
        //if($artistObj->isDomainOK($domain)===SUCCESS) $tmp=array_merge($tmp,array('domain'));
        $domainObj = LibFactory::getInstance('LibDomain');
        $ret = $domainObj->checkDomain($domain);
        if($ret === SUCCESS)
        {
            //domain表里先占位，add by yanyugang
            $domainRet = $domainObj->updateDomain(ARTIST_DOMAIN_TYPE, 0, $domain);
            if(true === $domainRet)
            {
                $tmp = array_merge($tmp, array('domain'));
            }else{
                Dapper_Log::fatal("register_artist_but_update_domain_fail", 'ui',array('artist_id'=>$artist_id,'domain'=>$domain));
            }
        }

        foreach ($tmp as $v){
            if($$v) $value[$v]=$$v;
        }
        //替换style
        if(strlen($value['style_ids']) > 0)
        {
            $baseObj = LibFactory::getInstance('LibBase');
            $data = $baseObj->getMusicanStyleByIds($value['style_ids']);
            if(is_array($data) && !empty($data))
            {
                $value['style'] = implode(',', $data);
            }
        }
        $value['genre_id'] = $genreId;


        $avatarPid = $baseObj->getPidByImgUrl($avatar);
        if($avatarPid > 0)
        {
            $avatar = $avatarPid;
        }

        $value['avatar'] = $avatar;

        $value['info'] = json_encode(array('phone'=>$phone,'email'=>$email,'regTime'=>time()));

        $cityObj = LibFactory::getInstance('LibCity');
        $ret1 = $cityObj->getCityInfo($city_id_0);
        $ret2 = $cityObj->getCityInfo($city_id_1);

        if($ret1 && $ret2)
            $value['area']=$ret1[0]['name'].','.$ret2[0]['name'];

        $value['verify_status']=0;//待审核
        $value['del_status']=1;//待审核隐藏
        $value['user_id'] = $this->loginInfo['user_bdid'];

        $value['realname'] = $realname;
        $value['idcard'] = $idcard;
        //$value['firstchar'] = LibArtist::getFirstCharter(trim($name));

        if($artist_info)
        {
            $ret = $artistObj->editArtist($artist_info['artist_id'],$value);
            $artist_id = $artist_info['artist_id'];
        }
        else
        {

            $ret=$artistObj->addArtist($value);
            if($ret)
            {
                $artist_id = $ret;

                $userObj = LibFactory::getInstance('LibUser');
                $xrank = $this->loginInfo['xrank'] | 1;
                $userInfo = array(
                    'artist_id' =>$artist_id,
                    'xrank'=>$xrank,
                );
                $ret = $userObj->upUser($this->loginInfo['user_bdid'],$userInfo);
                if(!$ret)
                {
                    Dapper_Log::fatal("register_upUser_fail", 'ui',array('user_bdid'=>$this->loginInfo['user_bdid'],'artist_id'=>$artist_id));
                }
            }
            else
            {
                Dapper_Log::fatal("register_addartist_fail", 'ui',array('user_bdid'=>$this->loginInfo['user_bdid']));
            }
        }
        //更新到domain_info,add by yanyugang
        if($ret && isset($value['domain']))
        {
            $domainUpdateStatus = $domainObj->updateDomain(ARTIST_DOMAIN_TYPE, $artist_id, $value['domain']);
            if(true !== $domainUpdateStatus)
            {
                Dapper_Log::fatal("register_artist_update_domain_fail", 'ui',array('artist_id'=>$artist_id,'domain'=>$value['domain']));
            }
        }
        if($ret && $tmpSongInfo['tmp_status'] == 0 )
        {
            $tmpSongInfo['artist_id'] = $artist_id;
            if(!trim($tmpSongInfo['song_name'])) $tmpSongInfo['song_name']=$name;
            $sid = $songObj->mvTmpSong($tmpSongInfo,true);
            if($sid)
            {
                //推送选链
                $songLinkCMObj = new DBSongLinkCM();
                $songLinkCMObj->callUpdateSongLink($sid);

                $albumObj = LibFactory::getInstance('LibAlbumSong');
                $albumObj->addAlbumSong(0,$artist_id,'播放列表',serialize(array($sid)));
            }
        }
        if($ret)
        {
            Dapper_Log::notice("register_artist", 'analyze',array('artist_id'=>$artist_id,'user_bdid'=>$this->loginInfo['user_bdid']));
        }

        $tplData ['errorCode'] =$ret ? SUCCESS:FAILED;
        $this->echo_json($tplData);
    }

}
*/
