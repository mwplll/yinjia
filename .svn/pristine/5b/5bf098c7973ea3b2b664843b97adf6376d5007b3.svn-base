<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 下午9:22
 */
class LibDesignComment{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * @param $start
     * @param $num
     * @param array $wh
     * @return mixed
     */
    public function getDesignCommentList($start,$num,$wh=array()){
        $dal = new DBDesignComment();
        return $dal->getDesignCommentList($start,$num,$wh);
    }

    /**
     * @param array $wh
     * @return mixed
     */
    public function getDesignCommentCount($wh=array()){
        $dal = new DBDesignComment();
        return $dal->getDesignCommentCount($wh);
    }

    /**
     * @param array $value
     * @return bool|mixed
     */
    public function addDeisgnComment($value=array()){
        if(!$value){
            return FALSE;
        }
        $value['comment_time'] = time();
        $dal = new DBDesignComment();
        return $dal->addDesignComment($value);
    }

    /**
     * @param $id
     * @param array $value
     * @return bool|mixed
     */
    public function updateDeisgnComment($id,$value=array()){
        if(!$this->isId($id)){
            return FALSE;
        }
        $dal = new DBDesignComment();
        return $dal->updateDesignComment($id,$value);
    }
}
