<?php
    function ip() {
        if (isset($_SERVER)) {
            if(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_FORWARDED_FOR'];
            } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP' );
            } elseif (getenv('HTTP_FORWARDED_FOR')) {
                $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        return $ip;
    }

    function ua() {
        if(stristr($_SERVER['HTTP_USER_AGENT'], 'Opera Mini')) {
            if(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
                $browser = addslashes(strip_tags($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']));
            } else {
                $browser = addslashes(strip_tags($_SERVER['HTTP_USER_AGENT']));
            }
        } else {
            $browser = addslashes(strip_tags($_SERVER['HTTP_USER_AGENT']));
        }
        return $browser;
    }
?>