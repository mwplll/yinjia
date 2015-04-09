<?php
/**
 * dal数据访问层
 *
 * 用户数据操作类(示例)
 * @package		User
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 */

class DBUser
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    public function addUser($userInfo)
    {
        $sql = $this->db->makeInsertSql('wm_user', $userInfo);
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }

    /**
     * 更新用户信息
     * @param $userId
     * @param $updateInfo
     * @return mixed
     */
    public function updateUser($userId,$updateInfo)
    {
        $wh = array('user_id' => $userId);
        $sql = $this->db->makeUpdateSQL('wm_user', $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }

    public function delUserById($userId)
    {
        $tb_name = 'wm_user';
        $sql = "DELETE FROM $tb_name WHERE user_id = $userId";
        return $this->db->doQuery($sql);
    }

    /**
     * 按分页查询满足一定条件的普通用户列表
     * @param $start
     * @param $num
     * @param array $wh
     * @return mixed
     */
    public function getUserList($start,$num,$wh=array()){
        $isSpecial = isset($wh['is_special']) ? " AND wm_user.is_special = " . $wh['is_special'] . " " : " ";
        $isChecked = isset($wh['is_checked']) ? " AND wm_user.is_checked in " . $wh['is_checked'] . " " : " ";
        $sql = "SELECT * FROM wm_user WHERE wm_user.user_del = 0 $isSpecial $isChecked
                ORDER BY wm_user.create_time DESC
                LIMIT $start,$num";
        //echo '$sql = '.$sql."\n";
        return $this->db->queryAllRows($sql);
    }

    public function getSuperUserList(){
        $sql = "SELECT * FROM wm_user WHERE wm_user.user_del = 0 AND wm_user.is_special >= 10
                ORDER BY wm_user.create_time DESC
               ";
        //echo '$sql = '.$sql."\n";
        return $this->db->queryAllRows($sql);
    }



    /**
     * 查询满足一定条件的普通用户数量
     * @param array $wh
     * @return mixed
     */
    public function getUserCount($wh=array()){
        $isSpecial = isset($wh['is_special']) ? " AND wm_user.is_special = " . $wh['is_special'] . " " : " ";
        $isChecked = isset($wh['is_checked']) ? " AND wm_user.is_checked in " . $wh['is_checked'] . " " : " ";
        $sql = "SELECT count(*) as num FROM wm_user WHERE wm_user.user_del = 0 $isSpecial $isChecked";
        $result = $this->db->queryFirstRow($sql);
        //print_r($result);
        return $result['num'];
    }

    /**
     * 查找满足一种条件的
     * @param $uTel
     */
    public function searchByUserTel($uTel){
        $sql = "SELECT * FROM wm_user WHERE wm_user.user_tel = $uTel AND wm_user.user_del = 0";
        return $this->db->queryFirstRow($sql);
    }

    public function searchByUserName($uName){
        $sql = "SELECT * FROM wm_user WHERE wm_user.user_name = '$uName' AND wm_user.user_del = 0";
        $result = $this->db->queryFirstRow($sql);
        return $result;
    }

    public function searchByUserId($id){
        $sql = "SELECT * FROM wm_user WHERE wm_user.user_id = '$id' AND wm_user.user_del = 0";  //edit by mwp pre:SELECT user_id, user_name FROM wm_user WHERE wm_user.user_id = '$id'
        $result = $this->db->queryFirstRow($sql);
        return $result;
    }

    /**
     * 获取当前最大的设计师编号
     * @return mixed
     */
    public function getMaxDesignerSn(){
        $sql = "SELECT max(designer_sn) AS maxDesignerSn FROM wm_user";
        $result = $this->db->queryFirstRow($sql);
        return $result['maxDesignerSn'];
    }
}
