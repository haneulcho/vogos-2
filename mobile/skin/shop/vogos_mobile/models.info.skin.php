<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>
<style type="text/css">
.embed-container {position: relative;margin-bottom:10px;padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>
<!-- info_content START -->
<div id="mds_view">
    <h2 class="mds_subject_v"><?php echo conv_content($mds['mds_subject'], 1); ?></h2>
<!-- 모델스초이스 동영상 시작 { -->
<?php if($mds['mds_video_src']) { ?>
<div id="mds_video" class="embed-container">
    <?php echo '<iframe src="https://player.vimeo.com/video/'.$mds['mds_video_src'].'?autoplay=0&color=fafafa&title=0&portrait=0&byline=0" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';   
    ?>
</div>
<?php } ?>
<!-- } 모델스초이스 동영상 끝 -->

    <?php if ($mds['mds_html']) { // 모델스초이스 내용 ?>
    <div class="mds_sum_v">
        <?php echo conv_content($mds['mds_html'], 1); ?>
    </div>
    <?php } ?>

<!-- 모델스초이스 관련상품 시작 { -->
<section id="sit_rel">
    <div class="sct_wrap sct_rel">
        <?php
        $rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
        if(!is_file($rel_skin_file))
            $rel_skin_file = G5_MSHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

        $sql = " select b.* from {$g5['g5_shop_models_item_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id) where a.mds_id = '{$mds['mds_id']}' and b.it_use='1' ";
        $list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
        $list->set_query($sql);
        echo $list->run();
        ?>
    </div>
</section>
<!-- } 모델스초이스 관련상품 끝 -->

</div> <!-- info_content END -->