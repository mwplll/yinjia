<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午5:01
 */
class sendIdentifyingCodeApiAction extends baseAction
{
    public function execute()
    {
        $indentifyCodeObj = new LibSendVerify();

        // 手机号
        $phone = Dapper_Http_Request::getParam('tel',NULL);
        if(!$phone){
            return $this->api_error(PARAM_ERROR,'Please provide phone number!');
        }

        if(!$this->is_mobile($phone)){
            return $this->api_error(PARAM_ERROR,'Please provide right phone number!');
        }

        //四位验证码随机数
        $code = rand(1000,9999);
        session_start();
        $_SESSION['reg_captcha'] = $code;
        $_SESSION['user_tel'] = $phone;
        //echo '$code = '.$code."\n";
        //echo '$_SESSION = '.$_SESSION['reg_captcha']."\n";

        //第三方短信接口
        $target = "http://sms.106jiekou.com/utf8/sms.aspx";
        $smsaccount = 'qzhz';  //短信平台账号
        $smspwd = 'zjuqzhzfw2014';    //短信平台密码
        $post_data = "account=".$smsaccount."&password=".$smspwd."&mobile=".$phone."&content=".rawurlencode("您的验证码是：".$code."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
        //100 表示成功,其它的参考文档
        $gets = $indentifyCodeObj->post($post_data, $target);

        //json接口返回
        if(!$gets){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success(TRUE);
        }

    }

    public function is_mobile($mobilePhone) {
        if (preg_match("/^1[34578][0-9]{9}$/", $mobilePhone)) {
            return true;
        } else {
            return false;
        }
    }
}