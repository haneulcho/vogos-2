<?php
include_once('./_common.php');
include_once('./_head.php');

if ($is_guest)
    alert('Member Only, Please Sign In', G5_BBS_URL.'/login.php');

/*
if ($url)
    $urlencode = urlencode($url);
else
    $urlencode = urlencode($_SERVER[REQUEST_URI]);
*/

$g5['title'] = 'Confirm Password';
$url = clean_xss_tags($_GET['url']);

// url 체크
check_url_host($url);

include_once($member_skin_path.'/member_confirm.skin.php');

include_once('./_tail.php');
?>
