<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


    $secretKey = $default['de_eximbay_secret_key'];//가맹점 secretkey
    $mid = $default['de_eximbay_mid'];//가맹점 아이디
    $reqURL = "https://secureapi.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST 서버 요청 URL입니다.

?>