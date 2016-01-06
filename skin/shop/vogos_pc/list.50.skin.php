<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_SHOP_SKIN_URL.'/js/jquery.shop.list.js"></script>', 10);
?>
 
<!-- 상품진열 50 (검색 분류 기본 리스트) 시작 { -->
<?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i % $this->list_mod == 0) { // 1줄 이미지 : 2개 이상
        $sct_last = ' sct_clear'; // 줄 첫번째
    } else { // 1줄 이미지 : 1개
        $sct_last = '';
    }

    if ($i == 0) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sch_list\">\n";
        }
    }

    echo "<li class=\"sct_li{$sct_last}\" style=\"width:{$this->img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image_best($row['it_id'], $this->img_width, $this->img_height, 8, '', '', 'original', stripslashes($row['it_name']))."</a>\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_des\"><div class=\"sct_txt_big\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">".stripslashes($row['it_basic'])."</a></div>\n";
    }

    if ($this->href) {
        echo "<a class=\"sct_buynow\" href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">BUY NOW</a>\n";
    }

    if ($this->href) {
        echo "</div>\n"; //sct_des END
    }

    if ($this->href) {
        echo "</div>\n";
    }


    if ($this->href) {
        echo "<div class=\"sct_des_bottom\"><div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_cust_price || $this->view_it_price) {

        echo "<div class=\"sct_cost\">\n";

        if ($this->view_it_cust_price && $row['it_cust_price']) {
            echo "<strike>".display_price($row['it_cust_price'])."</strike>\n";
        }

        if ($this->view_it_price) {
            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
        }

        echo "</div>\n";

        echo"<div class=\"sct_cart_m\">
            <div class=\"sct_cart_btn\" style=\"width:70px;height:40px\">
                <button type=\"button\" class=\"btn_cart_m\" data-it_id=\"{$row['it_id']}\"><i class=\"ion-android-cart\"></i>CART</button>
            </div>
            <div class=\"sct_cart_op\"></div>
        </div>\n";

        echo "</div>\n";

    }

    echo "</li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">Your search returns no results.</p>\n";
?>
<script>
  jQuery(function($){ 
    $(".sct li:nth-child(odd)").addClass("odd_margin");
  }); 
</script>

<script type="text/javascript">
$(function() {
    var $li50 = $('.sch_list li .sct_img');
    $li50.each(function() {
        var $des = $(this).children('.sct_des');
        $des.hide();
        $(this).mouseenter(function(e) {
            $des.filter(':not(:animated)').fadeIn(400);
        })
        .mouseleave(function() {
            $('.sch_list li .sct_des').hide();
            $des.filter(':not(:animated)').fadeOut(400);
        });
    });
});
</script>
<!-- } 상품진열 50 끝 -->