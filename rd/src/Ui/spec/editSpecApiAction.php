<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午9:40
 */
class editSpecApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "delete":
                $this->delete();
                break;
            case "save":
                $this->save();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 保存操作
     * @return bool
     */
    public function save(){
        $specObj = new LibSpec();


        $addData = array();
        $updateData = array();

        $specId = Dapper_Http_Request::getParam('id');
        $addData['spec_name'] = Dapper_Http_Request::getParam('name');
        $addData['spec_value'] = Dapper_Http_Request::getParam('value');
        $addData['spec_type'] = Dapper_Http_Request::getParam('type');

        if(!$addData['spec_name']){
            return $this->api_error(PARAM_ERROR,'请提供规格名称name! ');
        }
        if($addData['spec_type'] === NULL){
            return $this->api_error(PARAM_ERROR,'请提供规格类型type! ');
        }

        if(!$specId){
            if($addData['spec_type']){
                $res = TRUE;  //
				$addSpecres = $specObj->addSpec($addData);
                $specPics = $this->_gatherPics();
                if($specPics){
                    $addPicsRes = $specObj->addSpecPics($specPics);  //批量增加规格图片                    
                    $res = $addSpecres && $addPicsRes;
                }
            }
            else{
                $res = $specObj->addSpec($addData);
            }
        }
        else{
            if($addData['spec_type']){
                $res = TRUE;  //
                $updateData = $addData;
                $res = $specObj->updateSpec($updateData,$specId);
                $specPics = $this->_gatherPics();
                if($specPics){
                    $addPicsRes = $specObj->addSpecPics($specPics);  //批量增加规格图片                   
                    $res = $addPicsRes;
                }
            }
            else{
                $updateData = $addData;
                $res = $specObj->updateSpec($updateData,$specId);
            }
        }
        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }


    /**
     * 删除操作
     * @return bool
     */
    public function delete(){
        $specObj = new LibSpec();
        $specIds = Dapper_Http_Request::getParam('ids');

        if(!$specIds){
            return $this->api_error(FAILED,'please provide ids');
        }
        else{
            $specIds = str_replace("[","(",$specIds);
            $specIds = str_replace("]",")",$specIds);  //删除操作为假删除，将is_del置为1表示删除
            $res = $specObj->delSpecsByIds($specIds);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 整理图片数组
     * @return array
     */
    private function _gatherPics(){
        $arrPic = Dapper_Http_Request::getParam('pic');
        $arrPicId = Dapper_Http_Request::getParam('picId');
        $arrPicName = Dapper_Http_Request::getParam('picName');

        $specPics = array();
        $picNum = count($arrPic);
        if($picNum >= 1 && ($picNum == count($arrPicName)) && ($picNum == count($arrPicId))){
        foreach($arrPic as $i => $v){
            if(!$arrPicId[$i]){  //如果为新增的规格图片
                array_push($specPics, array(
                    'spec_pic' => $v,
                    'pic_name' => $arrPicName[$i]
                ));
            }
            else{//如果是更新的规格图片就直接做更新处理
                $updatePicInfo = array(
                    'spec_pic' => $v,
                    'pic_name' => $arrPicName[$i]
                );
                $specObj = new LibSpec();
                $specObj->updateSpecPic($updatePicInfo,$arrPicId[$i]);
            }
        }
        }

        return $specPics;
    }

}