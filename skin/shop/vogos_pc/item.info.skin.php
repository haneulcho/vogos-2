<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 정보 시작 { -->
<section id="sit_ov_inf">

    <ul id="sit_ov_tab">
        <li class="product_inf active">
            <h3><a href="#product_inf_v">Product Info</a></h3>
        </li>
        <li class="delivery_inf">
            <h3><a href="#delivery_inf_v">Delivery Info</a></h3>
        </li>
        <li class="returns_inf">
            <h3><a href="#returns_inf_v">Returns Info</a></h3>
        </li>
    </ul>
    <div id="product_inf_v" class="tab_div active">
        <a href="<?php echo G5_SHOP_URL; ?>/sizeguide.php" target="_blank" onclick="return popitup('<?php echo G5_SHOP_URL; ?>/sizeguide.php', 'VOGOS SIZE GUIDE', '685', '670')">VIEW SIZE GUIDE</a>
        <p><?php echo conv_content($it['it_explan'], 1); ?></p>
    </div>
    <div id="delivery_inf_v" class="tab_div">
    <?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
        <?php echo conv_content($default['de_baesong_content'], 1); ?>
    <?php } ?>
    </div>
    <div id="returns_inf_v" class="tab_div">
    <?php if ($default['de_change_content']) { // 교환/반품 내용이 있다면 ?>
        <?php echo conv_content($default['de_change_content'], 1); ?>
    <?php } ?>
    </div>

</section>
<!-- } sit_ov_inf END -->

<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});

function popitup(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
    return false;
}

$(function() {
    var $tabList = $('#sit_ov_tab > li');
    $tabList.each(function() {
        var tabName = null;
        $(this).click(function(e) {
            e.preventDefault();
            if(!$(this).hasClass('active')) {
                tabName = $(this).attr('class');
                $tabList.removeClass('active');
                $(this).addClass('active');
                showTabNav(tabName);
            }
        });
    });

    function showTabNav(tabName) {
        if($('.tab_div').hasClass('active')) {
            $('.tab_div').removeClass('active');
        }
        $('#' + tabName + '_v').addClass('active');
    }
});
</script>