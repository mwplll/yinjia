<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-10
 * Time: 下午9:01
 */

class LibSendVerify {

    /**
     * @param $data
     * @param $target
     * @return string
     */
    public function post($data, $target) {
        $url_info = parse_url($target);
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        //$httpheader .= "Connection:Keep-Alive\r\n\r\n";
        $httpheader .= $data;

        $fd = fsockopen($url_info['host'], 80);
        fwrite($fd, $httpheader);
        $gets = "";
        while(!feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);
        return $gets;
    }

} 