<?php
include_once('./_common.php');

//it_1 동영상 주소 sql 받아오기
$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);

$video_src = 'https://player.vimeo.com/video/'.$row['it_1'].'?autoplay=1&loop=1&color=333333&title=0&byline=0&portrait=0';
?>
<div class="modal_contents">
    <div class="modal_back"></div>
    <div class="modal_wrap">
        <div class="modal_video">
            <div class="modal_close"></div>
            <div class="modal_inform">
                <iframe src="<?=$video_src ?>" width="300" height="533" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <div class="vsit_ov_wrap">
                    <!-- 상품 요약정보 및 구매 시작 { -->
                    <section id="v<?php echo $row[it_id] ?>" class="vsit_ov">
                        <h2 class="sit_title"><?php echo stripslashes($row['it_name']); ?></h2>
                        <p class="sit_desc"><?php echo $row['it_basic']; ?></p>

                        <!-- 총 구매액 -->
                        <div class="sit_tot_price">
                        <?php echo display_price($row['it_price']) ?>
                        </div>

                        <div class="sit_ov_btn">
                            <?php
                                echo '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$row['it_id'].'" class="sit_btn_more">SEE MORE…</a>';
                            ?>
                            <a href="javascript:vitem_wish('<?php echo $row['it_id']; ?>');" class="sit_btn_wish">ADD TO WISHLIST ♥</a>
                        </div>
                    </section>
                    <!-- } 상품 요약정보 및 구매 끝 -->
                </div> <!-- vsit_ov_wrap END -->
            </div> <!-- modal_inform END -->
        </div>
    </div>
</div>