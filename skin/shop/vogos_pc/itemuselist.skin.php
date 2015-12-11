<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="rtap" class="pp">

    <div id="sod_title" class="review">
        <header class="fullWidth">
            <h2>REVIEWS</h2>
        </header>
    </div>

    <div class="fullWidth">

    <section class="reviews_ov">
        <div class="reviews_contents">

    <!-- 전체 상품 사용후기 목록 시작 { -->
    <form method="get" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
    <div id="sps_sch">
        <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">전체보기</a>
        <label for="sfl" class="sound_only">검색항목<strong class="sound_only"> 필수</strong></label>
        <select name="sfl" id="sfl" required>
            <option value="">선택</option>
            <option value="b.it_name"   <?php echo get_selected($sfl, "b.it_name"); ?>>상품명</option>
            <option value="a.it_id"     <?php echo get_selected($sfl, "a.it_id"); ?>>상품코드</option>
            <option value="a.is_subject"<?php echo get_selected($sfl, "a.is_subject"); ?>>후기제목</option>
            <option value="a.is_content"<?php echo get_selected($sfl, "a.is_content"); ?>>후기내용</option>
            <option value="a.is_name"   <?php echo get_selected($sfl, "a.is_name"); ?>>작성자명</option>
            <option value="a.mb_id"     <?php echo get_selected($sfl, "a.mb_id"); ?>>작성자아이디</option>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input class="review_input" type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="required frm_input">
        <input class="review_submit" type="submit" value="검색" class="btn_submit">
    </div>
    </form>

    <div id="sps">

        <!-- <p><?php echo $config['cf_title']; ?> 전체 사용후기 목록입니다.</p> -->

        <?php
        $thumbnail_width = 500;

        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $num = $total_count - ($page - 1) * $rows - $i;
            $star = get_star($row['is_score']);

            $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);

            $row2 = sql_fetch(" select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ");
            $it_href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";

            if ($i == 0) echo '<ol>';

            if ($i == 0) {
                echo '<li class="sps_con_btn sps_con_'.$i.' selected">';
            } else {
                echo '<li class="sps_con_btn sps_con_'.$i.'">';
            }
        ?>
            <div class="sps_img">
                <a href="<?php echo $it_href; ?>">
                    <?php echo get_itemuselist_thumbnail($row['it_id'], $row['is_content'], 70, 105); ?>
                    <span><?php echo $row2['it_name']; ?></span>
                </a>
            </div>

            <section class="sps_section">
                <h2><?php echo get_text($row['is_subject']); ?></h2>

                <dl class="sps_dl">
                    <dt><i class="ion-android-person"></i>작성자</dt>
                    <dd><?php echo $row['is_name']; ?></dd>
                    <dt><i class="ion-ios-calendar-outline"></i>작성일</dt>
                    <dd><?php echo substr($row['is_time'],0,10); ?></dd>
                    <dt><i class="ion-ios-star-half"></i>상품별점</dt>
                    <dd><img src="<?php echo G5_URL; ?>/shop/img/s_star<?php echo $star; ?>.png" alt="별<?php echo $star; ?>개"></dd>
                </dl>
                <a href="">관련상품 보러가기</a>
                <?php if ($i == 0) { ?>
                <div id="sps_con_<?php echo $i; ?>" class="sps_con">
                <?php } else { ?>
                <div id="sps_con_<?php echo $i; ?>" style="display:none;" class="sps_con">
                <?php } ?>
                    <?php echo $is_content; // 사용후기 내용 ?>
                </div>

            </section>

        </li>
        <?php }
        if ($i > 0) echo '</ol>';
        if ($i == 0) echo '<p id="sps_empty">자료가 없습니다.</p>';
        ?>
    </div>

    <?php echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

        </div>
    </section>

    </div>

</div>
<script>
$(function(){
    // 사용후기 더보기
    var $originalHeight = $('#sps ol').height() + 55;
    var $rcon = $('.reviews_contents');
    $rcon.css('height', $('#sps li:eq(0)').children('.sps_section').children('.sps_con').outerHeight() + 'px');
    $(".sps_con_btn").click(function(){
        var $con = $(this).children('.sps_section').children('.sps_con');
        var $li = $(this);
        $('#sps li').removeClass('selected');
        if($con.is(":visible")) {
            $con.slideUp(function() {
                $rcon.css('height', $originalHeight + 'px');
            });
        } else {
            $("div[id^=sps_con]:visible").hide();
            $conHeight = $con.outerHeight();
            if($originalHeight < $conHeight) {
                $rcon.css('height', $conHeight + 'px');
            } else {
                $rcon.css('height', $originalHeight + 'px'); 
            }
            $li.addClass('selected');
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });
});
</script>
<!-- } 전체 상품 사용후기 목록 끝 -->