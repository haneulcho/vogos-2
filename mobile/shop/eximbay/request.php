<?php
include_once('./_common.php');
	//$secretKey = "289F40E6640124B2628640168C3C5464";//가맹점 테스트 secretkey

  $secretKey = $default['de_eximbay_secret_key'];//가맹점 secretkey
  $mid = $default['de_eximbay_mid'];//가맹점 아이디
  $ref = $_POST['ref'];
	// $mid = "1849705C64";//가맹점 테스트 아이디
	// $ref = "abcd1234567890";//가맹점 테스트 주문번호
  
	$reqURL = "https://secureapi.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY 서버 요청 URL입니다.

	$cur = $_POST['cur'];
  $amt = $_POST['amt'];

  $linkBuf = $secretKey. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt;
  $fgkey = hash("sha256", $linkBuf);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" align="center" onload="javascript:document.forderform.submit();">
<form name="forderform" method="post" action="<?php echo $reqURL; ?>">
<input type="hidden" name="mid" value="<?php echo $mid; ?>" /> <!--필수 값-->
<input type="hidden" name="ref" value="<?php echo $ref; ?>" />	<!--필수 값-->
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />	<!--필수 값-->

<?php
foreach($_POST as $Key=>$value) {
?>
<input type="hidden" name="<?php echo $Key;?>" value="<?php echo $value;?>">
<?php } ?>
</form>
</body>
</html>

