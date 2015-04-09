<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-8
 * Time: 下午1:15
 */
class LibCity{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * get city
     * @param $id
     * @return bool
     */
    public function getCityById($id){
        if(!$this->isId($id)){
            return FALSE;
        }

        $dal = new DBCity();
        return $dal->getCityById($id);
    }
}