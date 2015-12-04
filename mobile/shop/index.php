<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_MSHOP_PATH.'/_head.php');
?>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>
<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>

<style type="text/css">
.embed-container {position: relative;margin-bottom:10px;padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>
<div id="sidx">
    <div class="inv_wrap">
        <div class="inv_new"><a href="#">NEW ARRIVALS</a></div>
        <div class="inv_run"><a href="#">RUNWAY</a></div>
    </div>
<?php echo display_banner('메인', 'mainbanner.10.skin_m.php'); ?>
<!-- Black Friday 시작 { -->
<div id="inv_ev_view" style="text-align:center">
    <div class="item event">
        <header>
            <h2>PARTY DRESSES</h2>
        </header>
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=30"><img src="<?php echo G5_MSHOP_SKIN_URL ?>/img/party_dresses.jpg" border="0" width="100%" alt="Amazing metallics, cool cut-outs and sexy necklines mean you'll be going all out across the eras this season!" title="SHOP PARTY DRESSES" style="max-width:860px"></a>
    </div>
</div>
<!-- } Black Friday 끝 -->
<!-- Shipping Banner 시작 { -->
<div id="inv_ship_view" style="text-align:center;padding:10px 0">
    <img src="<?php echo G5_MSHOP_SKIN_URL ?>/img/shipping_info.jpg" border="0" width="100%" alt="We offer FREE express shipping worldwide on orders of $80 +" title="We offer FREE express shipping worldwide on orders of $80 +" style="max-width:860px">
</div>
<!-- } Shipping Banner 끝 -->
<!-- Editor's Choice 시작 { -->
<div id="inv_ec_view" style="text-align:center">
    <?php if($default['de_mobile_type1_list_use']) { ?>
    <div class="item echoice">
        <header>
            <h2>EDITOR's CHOICE</h2>
        </header>
        <a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1"><img src="<?php echo G5_MSHOP_SKIN_URL ?>/img/editors_choice.jpg" border="0" width="100%" alt="From faux fur stoles and coats, to winter dresses, velvet coords and cosy knitwear we at VOGOS are here to make sure we cover all you style needs this season!" title="SHOP EDITOR's CHOICE" style="max-width:860px"></a>
    </div>
    <?php } ?>
</div>
<!-- } Editor's Choice 끝 -->

<div id="inv_new_view">
    <?php if($default['de_mobile_type3_list_use']) { ?>
    <div class="item new_arrivals">
        <header>
            <h2>NEW ARRIVALS</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $skin_file = G5_MSHOP_SKIN_PATH .'/main.20.skin.php';
        $item_mod = 1; //한줄당 갯수
        $item_rows = 13; //줄 수 
        $item_width= 300; //이미지 가로 
        $item_height = 450; //이미지 세로 
        $order_by = "it_update_time desc"; // 최신등록순


        $list = new item_list($skin_file, $item_mod , $item_rows , $item_width, $item_height); 
        $list->set_order_by($order_by); 
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_basic', true);
        $list->set_view('it_cust_price', false);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>

    <?php } ?>
</div>

<div id="inv_run_view">
    <?php if($default['de_mobile_type4_list_use']) { ?>
    <div class="item new_arrivals">
        <header>
            <h2>SPOT ITEMS</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(4);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>

    <?php } ?>
</div>

<!-- VOGOS BESTSELLER 베스트 출력 -->
    <div id="sct_best" class="item best_item">
        <header>
            <h2>VOGOS BESTSELLER</h2>
        </header>
    <?php
        // 분류 Best Item 출력
        $list_mod = 3;
        $list_row = 4;
        $limit = $list_mod * $list_row;
        $best_skin = G5_MSHOP_SKIN_PATH.'/list.best.10.skin_m.php';

        $sql = " select *
                    from {$g5['g5_shop_item_table']}
                    where it_use = '1'
                    order by it_order, it_hit desc
                    limit 0, $limit ";

        $list = new item_list($best_skin, $list_mod, $list_row, 300, 420);
        $list->set_query($sql);
        $list->set_mobile(true);
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_price', true);
        echo $list->run();
    ?>
    </div>
<!-- VOGOS BESTSELLER 베스트 출력 끝 -->
</div> <!-- END sidx -->

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>