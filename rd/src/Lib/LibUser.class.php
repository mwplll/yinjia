<?php
class LibUser
{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    private function _checkUserExist($userInfo)
    {
        if($this->getUserByTel($userInfo['user_tel']) || $this->getUserByName($userInfo['user_name'])){
            return true;
        }
        return false;
    }

    public function addUser($userInfo)
    {
//        if(!$this->_validateUserInfo($userInfo)){
//            return false;
//        }

        if($this->_checkUserExist($userInfo)){
            return false;
        }
        // Add user;
        $db = new DBUser();
        $userInfo['user_passwd'] = md5($userInfo['user_passwd']);
        return $db->addUser($userInfo);
    }

    /**
     * 添加管理员用户
     * @param $userInfo
     * @return bool
     */
    public function addSuperUser($userInfo){
        if($this->getUserByName($userInfo['user_name'])){
            return FALSE;
        }

        $db = new DBUser();
        $userInfo['user_passwd'] = md5($userInfo['user_passwd']);
        return $db->addUser($userInfo);
    }

    public function getUserByTel($tel){
        $db = DBFactory::getInstance('DBUser');
        return $db->searchByUserTel($tel);
    }

    public function getUserByName($name){
        $db = DBFactory::getInstance('DBUser');
        return $db->searchByUserName($name);
    }

    public function getUserById($id){
        if(!$this->isId($id)){
            return false;
        }
        $db = new DBUser();
        return $db->searchByUserId($id);
    }

    public function delUserById($id){
        if(!$this->isId($id)){
            return false;
        }
        $db = DBFactory::getInstance('DBUser');
        return $db->delUserById($id);
    }

    /**
     * 查找满足wh条件的所有用户
     * @param $num
     * @param $start
     * @param array $wh
     * @return mixed
     */
    public function getUserList($num,$start,$wh=array()){
        $db = new DBUser();
        return $db->getUserList($num,$start,$wh);
    }

    /**
     * 满足wh条件的用户总数
     * @param array $wh
     * @return mixed
     */
    public function getUserCount($wh=array()){
        $db = new DBUser();;
        return $db->getUserCount($wh);
    }

    public function getSuperUserList(){
        $db = new DBUser();
        return $db->getSuperUserList();
    }

    /**************************************
     * 以下为用户登录相关
     ***************************************/
    /**
     * 可逆的加密算法
     * @see http://www.helloweba.com/view-blog-255.html
     * @param $string
     * @param $operation
     * @param string $key
     * @return mixed|string
     * @example
     *  $str = 'abc';
     *  $key = 'www.helloweba.com';
     *  $token = encrypt($str, 'E', $key);
     *  echo '加密:'.encrypt($str, 'E', $key);
     *  echo '解密：'.encrypt($str, 'D', $key);
     */
    private function _encrypt($string,$operation,$key=''){
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            return str_replace('=','',base64_encode($result));
        }
    }

    /**
     * 登录 用户名或者手机号
     * @param $user
     * @param $passwd
     * @return bool
     */
    public function login($user, $passwd)
    {
        $db = new DBUser();
        $userByName = $this->getUserByName($user);
        $userByTel = $this->getUserByTel($user);

        if(($userByName && $userByName['user_passwd'] == md5($passwd))||(($userByTel && $userByTel['user_passwd'] == md5($passwd)))){
            // 设置用户 id相关的 为 token, 存取到用户 cookie 中
            if($userByName){
                $uidHash = $this->_encrypt($userByName['user_id'], 'E', 'WM_USER_ID');
            }
            if($userByTel){
                $uidHash = $this->_encrypt($userByTel['user_id'], 'E', 'WM_USER_ID');
            }
            setcookie('wmuid', $uidHash, time() + 30 * 24 * 3600, "/");
            return true;
        }else{
            return false;
        }
    }

    public function adminLogin($name, $passwd)
    {
        $db = DBFactory::getInstance('DBUser');
        $user = $this->getUserByName($name);

        if($user && $user['user_passwd'] == md5($passwd) && $user['is_special'] >= 10){  //检查是否是管理员用户
            // 设置用户 id相关的 为 token, 存取到用户 cookie 中
            $uidHash = $this->_encrypt($user['user_id'], 'E', 'WM_USER_ID');
            setcookie('wmuid', $uidHash, time() + 30 * 24 * 3600, "/");
            return true;
        }else{
            return false;
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        setcookie('wmuid', '', time() - 3600, "/");
    }

    /**
     * 检查当前用户是否登录
     */
    public function checkLogin($userType=0)
    {
        $userInfo = $this->loginInfo();
        if($userType == $userInfo['is_special']){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function loginInfo()
    {
        $uidHash = isset($_COOKIE['wmuid']) ? $_COOKIE['wmuid'] : false;
        if(!$uidHash){
            return false;
        }else{
            $uid = $this->_encrypt($uidHash, 'D', 'WM_USER_ID');
            if(!$uid){
                return false;
            }
            return $this->getUserById($uid);
        }
    }

    /**更新用户信息
     * @param $updateInfo
     * @param $userId
     * @return mixed
     */
    public function updateUser($userId,$updateInfo=array()){
        if(!$updateInfo){
            return false;
        }

        if(!$this->isId($userId)){
            return false;
        }

        //print_r($value);
        $db = new DBUser();
        return $db->updateUser($userId,$updateInfo);
    }

    /**
     * 申请成为设计师
     * @param $userId
     * @param array $updateInfo
     * @return mixed
     */
    public function toBeDesigner($userId,$updateInfo=array()){
        $dal = new DBUser();
        $maxDesignerSn = intval($dal->getMaxDesignerSn());

        //echo '$maxDesignerSn = '.$maxDesignerSn."\n";
        $newDesignerSn = str_pad(($maxDesignerSn+1),5,"0",STR_PAD_LEFT);

        $updateInfo['designer_sn'] = $newDesignerSn;

        return $this->updateUser($userId,$updateInfo);

    }

}
