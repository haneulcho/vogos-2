<?php
include_once('../../../../common.php');

//it_1 동영상 주소 sql 받아오기
$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '{$it_id}' ";
$row = sql_fetch($sql);

$video_src = 'https://player.vimeo.com/video/'.$row['it_1'].'?autoplay=1&loop=1&color=333333&title=0&byline=0&portrait=0';
?>

<div class="modal_contents">
    <div class="modal_back"></div>
    <div class="modal_wrap">
        <div class="modal_video">
            <div class="modal_close"></div>
            <iframe src="<?=$video_src ?>" width="300" height="533" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
    </div>
</div>