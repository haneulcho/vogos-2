<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 전자결제를 사용할 때만 실행
if($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use']) {
?>
<script type="text/javascript">
<!--
	//Eximbay 팝업
	function payForm(){
		var frm = document.forderform;

		//필수 값 파라미터 체크
		
		window.open("", "payment2", "scrollbars=yes,status=no,toolbar=no,resizable=yes,location=no,menu=no,width=800,height=470");
		frm.target = "payment2";
		frm.submit();
	}
//-->
</script>
<?php } ?>