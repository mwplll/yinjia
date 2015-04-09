<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-8
 * Time: 下午1:03
 */
class LibManual{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 人工加辅料标准单价表
     * @param array $wh
     * @return mixed
     */
    public function getManualList($wh=array()){
        $dal = new DBManual();
        return $dal->getManualList($wh);
    }

    public function addDesignStyle($value=array()){
        if(!$value){
            return FALSE;
        }
        $dal = new DBManual();
        return $dal->addDesignStyle($value);
    }

    public function updateDesignStyle($id,$value=array()){
        if(!$this->isId($id)){
            return FALSE;
        }
        if(!$value){
            return FALSE;
        }
        $dal = new DBManual();
        return $dal->updateDesignStyle($id,$value);
    }

    public function addManuals($manuals=array()){
        if(!$manuals){
            return FALSE;
        }
        $dal = new DBManual();
        return $dal->addManuals($manuals);
    }

    public function updateManuals($manuals=array()){
        if(!$manuals){
            return FALSE;
        }
        $dal = new DBManual();
        return $dal->updateManuals($manuals);
    }

    public function updateManual($id,$value=array()){
        if(!$this->isId($id)){
            return FALSE;
        }
        if(!$value){
            return FALSE;
        }
        $dal = new DBManual();
        return $dal->updateManual($id,$value);
    }

}