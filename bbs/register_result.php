<?php
include_once('./_common.php');

if (isset($_SESSION['ss_mb_reg']))
    $mb = get_member($_SESSION['ss_mb_reg']);

// 회원정보가 없다면 초기 페이지로 이동
if (!$mb['mb_id'])
    goto_url(G5_URL);

$g5['title'] = '회원가입이 완료되었습니다.';
include_once('./_head.php');
// 로그분석기 시작
$http_SO="REGO";	//가입완료페이지
// 로그분석기 끝
include_once($member_skin_path.'/register_result.skin.php');
?>
<!-- 네이버 프리미엄로그분석 전환페이지 설정_ 회원가입완료 -->
 <script type="text/javascript" src="http://wcs.naver.net/wcslog.js"> </script> 
 <script type="text/javascript">
var _nasa={};
 _nasa["cnv"] = wcs.cnv("2",100000);
</script>
<?php
include_once('./_tail.php');
?>