<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 전자결제를 사용할 때만 실행
if($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use']) {
?>


<div id="display_pay_button" style="padding:5px 0 30px;" class="btn_confirm" style="display:none">
    <input type="button" value="CHECKOUT NOW" class="btn_submit" onclick="javascript:forderform_check();">
    <a href="javascript:history.go(-1);" class="btn01">Quit</a>
</div>
<div id="display_pay_process" style="display:none">
    <img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="">
    <span>주문완료 중입니다. 잠시만 기다려 주십시오.</span>
</div>
<?php } ?>

<script>
document.getElementById("display_pay_button").style.display = "" ;
</script>