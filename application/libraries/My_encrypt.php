<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Encrypt extends CI_Encrypt {

    function encode($string, $key = "", $url_safe = TRUE) {

        $ret = "";

        $ret = urlencode(base64_encode($string));

        return $ret;
    }

    function decode($string, $key = "") {


        $ret = base64_decode(urldecode($string));

        return $ret;
    }

}

?>