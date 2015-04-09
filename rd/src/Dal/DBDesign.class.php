<?php
/**
 * dal数据访问层
 *
 * 用户数据操作类(示例)
 * @package		User
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 */

class DBDesign
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
        $sample = array(
            'house_type_id',
            'author_id',
            'budget_id',
            'pic',
            'design_price',
            'matl_price',
            'cons_price'
        );
        $this->sample = implode(',', $sample);

        //不允许穿空字段
        $this->notNullFields = $sample;
    }

    /**
     * 防注入
     * @access public
     * @param  string $tbname  表名
     * @param  array $value    键值对
     * @return array
     */
    public function eascape($tbname, $value)
    {
        $eascape = array(
            'show_info' => array(
                'show_name',
                'show_desc',
                'cost_conf',
                'buy_link',
                'addr',
                'location'
            ),
            'album_show' => array(
                'title'
            )
        );
        $list = $eascape[$tbname];
        if(!$list || !is_array($value)) return $value;

        foreach ($value as $k => $v)
        {
            if(in_array($k,$list)) $value[$k] = $this->db->realEscapeString($v);
        }
        return $value;
    }

    /**
     * 检查是否有空值
     * @param array $value 待插入数据
     * @return boolean 若有空值 返回true
     */
    public function hasNullField($value)
    {
        foreach ($value as $k => $v) {
            if(in_array($k, $this->notNullFields)) {
                if(!$v) {
//                    Dapper_log::debug()
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * addDesignInfo
     * @access public
     * @param  array  $value value
     * @return bool
     */
    public function addDesignInfo($value = array())
    {
        $tbname = 'wm_design_schema';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 更新设计方案信息表
     * @param array $value
     * @param $designId
     * @return mixed
     */
    public function updateDesignInfo($value = array(),$designId)
    {
        $tbname = 'wm_design_schema';
        $wh = array('design_schema_id' => $designId);

        $sql = $this->db->makeUpdateSQL($tbname, $value,$wh);
        return $this->db->doQuery($sql);
    }


    /**
     * 获取$wh条件下的设计方案列表
     * @param array $wh
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getDesignList($wh=array(),$start,$num)
    {
        $tbName = 'wm_design_schema';
        $sql = "SELECT * FROM {$tbName} limit $start, $num";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 获得满足wh条件的设计方案总个数
     * @param array $wh
     * @return mixed
     */
    public function getDesignCount($wh=array())
    {
        $tbName = 'wm_design_schema';
        $sql = "SELECT count(*) as num FROM {$tbName}";
        $ret = $this->db->queryFirstRow($sql);
        return $ret['num'];
    }

    public function searchDesignByHouseTypeId($houseTypeId,$start,$num,$en=1)
    {

        $enable = $en ? " AND design_schema_del = 0 " : " AND design_schema_del <> 1 ";
        $tbName = 'wm_design_schema';
        $sql = "SELECT * FROM {$tbName} WHERE house_type_id = {$houseTypeId} $enable
                ORDER BY modify_time DESC
                LIMIT $start, $num";
        $ret = $this->db->queryAllRows($sql);

        return $ret;
    }

    public function searchDesignForDisplay()
    {

        $tbName = 'wm_design_schema';

        $sql = "SELECT * FROM {$tbName} WHERE is_fordisplay = TRUE";
        $ret = $this->db->queryAllRows($sql);

        return $ret;
    }

    public function getDesignInfoByDesignID($designId)
    {

        $tbName = 'wm_design_schema';

//        $sql = "SELECT * FROM wm_house_type INNER JOIN wm_house_addr WHERE
//            wm_house_type.house_addr_id = wm_house_addr.house_addr_id AND wm_house_addr.city = '杭州'
//            limit $start , $num ";

        $sql = "SELECT * FROM {$tbName} WHERE design_schema_id = {$designId}";
        $ret = $this->db->queryFirstRow($sql);


        return $ret;
    }

    /**
     * 根据传入的设计id数组,查询设计信息
     * @param $design_ids
     * @return mixed
     */
    public function getDesignInfoByIds($design_ids)
    {
        $values = implode(',', $design_ids);
        $tbName = 'wm_design_schema';

        $sql = "SELECT * FROM {$tbName} WHERE design_schema_id IN ($values)";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }
}
