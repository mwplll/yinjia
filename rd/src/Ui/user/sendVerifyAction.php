<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-10
 * Time: 下午8:49
 */
class sendVerifyAction extends baseAction
{
    public function execute()
    {
        $verifyObj = LibFactory::getInstance('LibSendVerify');

        // 手机号
        $phone = isset($_GET["tel"]) ? $_GET["tel"] : NULL;

        //四位验证码随机数
        $randnum = rand(1000,9999);
        //第三方短信接口
        $target = "http://sms.106jiekou.com/utf8/sms.aspx";
        $smsaccount = 'qzhz';  //短信平台账号
        $smspwd = 'zjuqzhzfw2014';    //短信平台密码
        $post_data = "account=".$smsaccount."&password=".$smspwd."&mobile=".$phone."&content=".rawurlencode("您的验证码是：".$randnum."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
        //100 表示成功,其它的参考文档
        $gets = $verifyObj->post($post_data, $target);
        //$return = ($gets == 100) ? TRUE : FALSE;

        $tplData = array(
            'errorCode' => $gets ? SUCCESS : FAILED,
            'verifyCode'=> $randnum,
        );
        //echo json_encode($tplData);
        $this->echo_json($tplData);
        //return;
    }
}

?>