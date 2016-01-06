<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
<?php
    $owlcateWidth = ($this->list_mod * $this->img_width) + ($this->list_mod - 1) * 20;
    echo '<div class="owlcate_btns fullWidth"><div class="owlcate_btn nextBtn"><i class="ion-ios-arrow-right"></i></div>'.PHP_EOL;
    echo '<div class="owlcate_btn prevBtn"><i class="ion-ios-arrow-left"></i></div></div>'.PHP_EOL;
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($i % $this->list_mod == 0) { // 1줄 이미지 : 2개 이상
        $sct_last = ' sct_clear'; // 줄 첫번째
    } else { // 1줄 이미지 : 1개
        $sct_last = '';
    }

    if ($i == 1) {
        echo "<div class=\"owlcate\" style=\"width:".$owlcateWidth."px\">\n";
    }

    echo "<div class=\"item{$sct_last}\">\n";

    if ($this->href) {
        echo "<div class=\"slider_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image_best($row['it_id'], $this->img_width, $this->img_height, 8, '', '', 'original', stripslashes($row['it_name']))."\n";
        if(!empty($row['it_img2'])) {
            echo get_it_image_best($row['it_id'], $this->img_width, $this->img_height, 2, '', '', 'sub', stripslashes($row['it_name']))."\n";
        } else {
            echo get_it_image_best($row['it_id'], $this->img_width, $this->img_height, 1, '', '', 'sub', stripslashes($row['it_name']))."\n";
        }
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->href) {
        echo "<div class=\"slider_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo cut_str(stripslashes($row['it_name']), 9)."\n";
    }

    if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\">".cut_str(stripslashes($row['it_basic']), 28)."</div>\n";
    }

    echo "<div class=\"sct_cost\">\n";

    if ($this->view_it_cust_price && $row['it_cust_price']) {
        echo "<strike>".display_price($row['it_cust_price'])."</strike>\n";
    }

    if ($this->view_it_price) {
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

<script type="text/javascript">
$(function(){
    $('.owlcate .slider_img a').mouseenter(function() {
        $(this).filter(':not(:animated)').children('.sub').fadeIn(400);
        $(this).filter(':not(:animated)').children('.original').fadeOut(400);
    }).mouseleave(function(e) {
        $(this).filter(':not(:animated)').children('.sub').fadeOut(400);
        $(this).filter(':not(:animated)').children('.original').fadeIn(400);
    });

    var sync2 = $(".owlcate");
    sync2.owlCarousel({
    items: 5,
    loop: true,
    dot: false,
    nav: true,
    autoplay: true,
    smartSpeed: 300,
    margin: 0
    });

    $('.nextBtn').click(function() {
        sync2.trigger('next.owl.carousel');
    })
    // Go to the previous item
    $('.prevBtn').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        sync2.trigger('prev.owl.carousel', [500]);
    })
});
</script>