<?php
    function getUserIpAddr() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // return $ip;
        return $ip;
    }

    
    $ipsCache = [];
    function geolocateIP($ip) {
        // Use simple cache
        if (isset($ipsCache[$ip])) {
            return $ipsCache[$ip];
        }
        return $ipsCache[$ip] = json_decode(file_get_contents("http://ip-api.com/json/$ip"));
    }
    

    function guidv4() {
        return bin2hex(random_bytes(16));
    }
    ?>