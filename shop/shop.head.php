<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 상단 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_head'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_head'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_head']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

?>
<div id="hd_wrap">
<?php if(defined('_INDEX_')) { // index에서만 실행
    include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
 } ?>
<header id="hd" class="fullWidth">
    <h1><a href="<?php echo G5_SHOP_URL; ?>"><img src="<?php echo G5_SHOP_SKIN_URL ?>/img/logo2.png" alt="<?php echo $config['cf_title']; ?>"></a></h1>
    <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 Navigation ?>
    <div class="fr">
        <div id="hd_sch">
            <span>보고스 상품 검색</span>
            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">

            <label for="sch_str" class="sound_only">검색어<strong class="sound_only"> required</strong></label>
            <?php if ($is_admin) {  ?>
                <input type="text" name="q" style="width:70px" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>
            <?php } else { ?>
                <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>
            <?php } ?>
            <input type="submit" value="검색" id="sch_submit">

            </form>
            <script>
            function search_submit(f) {
                if (f.q.value.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.q.select();
                    f.q.focus();
                    return false;
                }

                return true;
            }
            </script>
        </div>
        <ul id="tnb">
            <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li class="tnb_adm"><a href="<?php echo G5_ADMIN_URL ?>"><i class="ion-android-settings" style="margin:0"></i></a></li>
            <?php }  ?>
            <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php"><i class="ion-android-person"></i>MY PAGE</a></li>
            <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="ion-android-cart"></i>CART</a></li>
            <li class="tnb_log"><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop"><i class="ion-android-unlock" style="margin-right:0"></i></a></li>
            <?php } else {  ?>
            <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="ion-android-cart"></i>장바구니</a></li>
            <!-- <li class="tnb_log"><a href="<?php //echo G5_BBS_URL; ?>/register.php"><i class="ion-android-person-add"></i>SIGN UP</a></li> -->
            <li class="tnb_log"><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><i class="ion-android-lock"></i><b>로그인/가입</b></a></li>
            <?php }  ?>
        </ul>
    </div> <!-- class fr -->
</header>
</div> <!-- hd_wrap END -->


<!-- idx_wrap 시작 { -->
<?php if(defined('_INDEX_') && _INDEX_) { ?>
<section id="idx_wrap">
    <h2 class="sound_only">Main Banner_Index</h2>
        <!-- 메인 배너 이미지 시작 { -->
        <?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
        <!-- } 메인 배너 이미지 끝 -->
<?php } ?>
</section>


<!-- } idx_wrap 끝 -->

<!-- wrapper 시작 { -->
<?php if(defined('_INDEX_')) { ?>
<div id="wrapper">
<?php } else { ?>
<div id="wrapper" class="p60">
<?php } ?>
    <!-- 콘텐츠 시작 { -->
    <div id="container">