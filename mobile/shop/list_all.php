<?php
include_once('./_common.php');
include_once(G5_MSHOP_PATH.'/_head.php');

// 스킨경로
if($it['it_mobile_skin']) {
    $skin_dir = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$it['it_mobile_skin'];

    if(is_dir($skin_dir)) {
        $form_skin_file = $skin_dir.'/list.10.skin.php';
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>
<script>
var g5_shop_url = "<?php echo G5_SHOP_URL; ?>";
</script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.list.js"></script>
<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
<?php include_once(G5_MSHOP_SKIN_PATH.'/main.event.skin.php'); // 이벤트 ?>
<?php echo display_banner('메인', 'mainbanner.10.skin_m.php'); ?>

<div id="sidx">
    <div class="item vogos_clip">
        <header>
            <h2>VOGOS CLIP</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $form_skin_file = G5_MSHOP_SKIN_PATH.'/list.10.skin.php';
        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc ";
        $list_mod = 1;     // 가로 이미지수 = 모바일 1행이미지수
        $list_row = 12;     // 이미지줄 수, Query를 직접 지정하기 때문에 이미지줄 수는 적용되지 않음
        $img_width = 300;  // 이미지 폭
        $img_height = 420; // 이미지 높이
        $list = new item_list($form_skin_file, $list_mod, $list_row, $img_width, $img_height);
        $list->set_mobile(true);
        $list->set_query($sql);
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>
</div>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>