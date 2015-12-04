<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<?php
if($this->total_count > 0) {
    $li_width = intval(100 / $this->list_mod);
    $li_width_style = ' style="width:'.$li_width.'%;"';
    $k = 1;
    $countRow = mysql_num_rows($result);
    $owlbestWidth = $countRow * 222;

for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($i == 1) {
        echo "<div class=\"owl-carousel owlbest\" style=\"width:".$owlbestWidth."px\">\n";
    }

    if ($i < $countRow) {
       echo "<div class=\"item\">\n";
    } else {
       echo "<div class=\"item item_last\">\n";
    }

    if ($this->href) {
        echo "<div class=\"slider_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image_best($row['it_id'], 222, 300, 8, '', '', 'original', stripslashes($row['it_name_kr']))."\n";
        echo get_it_image_best($row['it_id'], 222, 300, 2, '', '', 'sub', stripslashes($row['it_name_kr']))."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->href) {
        echo "<div class=\"slider_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name_kr) {
        echo stripslashes($row['it_name_kr'])."\n";
    }

    echo "<div class=\"sct_cost\">\n";

    if ($this->view_it_cust_price_kr && $row['it_cust_price_kr']) {
        echo "<strike>".display_price($row['it_cust_price_kr'])."</strike>\n";
    }

    if ($this->view_it_price_kr) {
        echo display_price(get_price($row), $row['it_tel_inq'])."\n";
    }

    echo "</div>\n";

    if ($this->href) {
        echo "</a></div>\n";
    }

    echo "</div>\n";
} // for END

if ($i > 1) {
    echo "</div>\n";
}

if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>

<?php
}
?>
<script type="text/javascript">
$(function(){
    $('.owlbest .slider_img a').mouseenter(function() {
        $(this).filter(':not(:animated)').children('.sub').fadeIn(400);
        $(this).filter(':not(:animated)').children('.original').fadeOut(400);
    }).mouseleave(function(e) {
        $(this).filter(':not(:animated)').children('.sub').fadeOut(400);
        $(this).filter(':not(:animated)').children('.original').fadeIn(400);
    });
});

</script>