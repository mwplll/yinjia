<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-16
 * Time: 下午10:46
 */
class adminDesignManualListApiAction extends baseAction{
    public function execute(){
        $manualObj = new LibManual();
        $manualList = $manualObj->getManualList();  //人工加辅料单价表
        /*echo '$manualList = ';
        print_r($manualList);
        echo "\n";*/

        $mapArr = array(
            'id' => 'manual_id',
            'name' => 'manual_name',
            'price' => 'manual_price',
            'styleId' => 'design_style_id',
            'styleName' => 'design_style_name'
        );

        if($manualList){
            $manualRes = $this->mapArrays($mapArr,$manualList);
        }
        else{
            $manualRes = array();
        }

        //print_r($manualList);
        if($manualList == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($manualRes);
        }

    }
}