<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 下午9:22
 */
class DBDesignComment
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    public function __destruct()
    {
        $this->db = null;
    }

    /**
     * 添加设计方案评论
     * @param array $value
     * @return mixed
     */
    public function addDesignComment($value = array())
    {
        $tbName = 'wm_design_comment';

        $ret = $this->db->makeInsertSQL($tbName,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 更新设计方案评论
     * @param $id
     * @param array $value
     * @return mixed
     */
    public function updateDesignComment($id,$value = array())
    {
        $tbName = 'wm_design_comment';
        $wh = array('design_comment_id' => $id);

        $sql = $this->db->makeUpdateSQL($tbName, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     *
     * @param int $start
     * @param int $num
     * @param array $wh
     * @return mixed
     */
    public function getDesignCommentList($start=0,$num=15,$wh=array()){
        $designSchema = isset($wh['design_schema_id']) ? " AND wm_design_comment.design_schema_id = " . $wh['design_schema_id'] . " " : " ";

        $sql = "SELECT * FROM wm_user INNER JOIN wm_design_comment WHERE wm_design_comment.user_id = wm_user.user_id
                AND wm_design_comment.design_comment_del = 0 $designSchema
                ORDER BY  wm_design_comment.comment_time DESC
                LIMIT $start,$num";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryAllRows($sql);
        //print_r($res);
        return $res;
    }

    public function getDesignCommentCount($wh=array()){
        $designSchema = isset($wh['design_schema_id']) ? " AND wm_design_comment.design_schema_id = " . $wh['design_schema_id'] . " " : " ";

        $sql = "SELECT count(*) as num FROM wm_design_comment INNER JOIN wm_user WHERE wm_design_comment.user_id = wm_user.user_id
                AND wm_design_comment.design_comment_del = 0 $designSchema";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryFirstRow($sql);
        //print_r($res);
        return $res['num'];
    }
}