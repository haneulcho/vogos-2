<?php
include_once('./_common.php');

	//결제 응답 파라미터
	$rescode = $_POST['rescode'];
	$resmsg = $_POST['resmsg'];
	$authcode = $_POST['authcode'];
	$cardco = $_POST['cardco'];
	
	echo "rescode : ". $rescode . "<br/>";
	echo "resmsg : ". $resmsg . "<br/>";
	echo "authcode : ". $authcode . "<br/>";
	echo "cardco : ". $cardco . "<br/>";
?>
<html>
<body>
Done<br/>
<input type=button value="Retry" onclick="javascript:document.location.href='payment.html';">
</body>
</html>