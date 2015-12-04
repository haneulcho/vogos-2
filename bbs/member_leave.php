<?php
include_once('./_common.php');

if (!$member['mb_id'])
    alert('Member Only, Please Sign In');

if ($is_admin == 'super')
    alert('최고 관리자는 탈퇴할 수 없습니다');

if (!($_POST['mb_password'] && check_password($_POST['mb_password'], $member['mb_password'])))
    alert('Your password is incorrect.');

// 회원탈퇴일을 저장
$date = date("Ymd");
$sql = " update {$g5['member_table']} set mb_leave_date = '{$date}' where mb_id = '{$member['mb_id']}' ";
sql_query($sql);

// 3.09 수정 (로그아웃)
unset($_SESSION['ss_mb_id']);

if (!$url)
    $url = G5_URL;

alert('Invalid ID', $url);
?>
