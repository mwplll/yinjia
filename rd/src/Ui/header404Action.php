<?php
/**
 * 404页面
 *
 */

class header404Action extends baseAction
{
    public function execute()
    {
        /*header('Location:http://'.$_SERVER['HTTP_HOST']);//暂无404，to home
        exit;
        header("HTTP/1.1 404 Not Found");
        $this->template = 'http_state/404';
        $this->display($this->template);*/
        $this->header404();
        return;
    }
}
?>
