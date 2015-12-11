<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 정보 시작 { -->
<section id="sit_ov_inf">

    <ul id="sit_ov_tab">
        <li class="product_inf active">
            <h3><a href="#product_inf_v">Product Info</a></h3>
            <div id="product_inf_v" class="tab_div active">
                <p><?php echo conv_content($it['it_explan'], 1); ?></p>
            </div>
        </li>
    </ul>

    <div id="alert_shipping">
        <p>
            <i class="ion-android-plane"></i>VOGOS 전상품 70,000원 이상 구매시 무료배송
        </p>
        <div class="go_to_links">
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=shippinginfo"><i class="ion-android-arrow-dropright-circle"></i> View shipping information</a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=returnpolicy"><i class="ion-android-arrow-dropright-circle"></i> View returns and policies</a>
        </div>
    </div>

</section>
<!-- } sit_ov_inf END -->

<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});
</script>