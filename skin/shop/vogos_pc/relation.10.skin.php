<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<!-- 상품진열 10 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($this->list_mod >= 2) { // 1줄 이미지 : 2개 이상
        if ($i%$this->list_mod == 0) $sct_last = ' sct_last'; // 줄 마지막
        else if ($i%$this->list_mod == 1) $sct_last = ' sct_clear'; // 줄 첫번째
        else $sct_last = '';
    } else { // 1줄 이미지 : 1개
        $sct_last = ' sct_clear';
    }

    if ($i == 1) {
        echo '<section id="sit_rel"><div class="sct_wrap fullWidth"><h2>Related Items</h2>';
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_rel_20\">\n";
        }
    }

    echo "<li class=\"sct_li{$sct_last}\" style=\"width:{$this->img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image_best($row['it_id'], $this->img_width, $this->img_height, 8, '', '', 'original', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_des\"><div class=\"sct_txt_big\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
        echo "</a>\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\">".stripslashes($row['it_basic'])."</div>\n";
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
                <button type=\"button\" class=\"btn_cart_m\" onclick=\"location.href='{$this->href}{$row['it_id']}'\"><i class=\"ion-android-cart\"></i>CART</button>
            </div>
        </div>\n";

        echo "</div>\n";

    }

    echo "</li>\n";
}

if ($i > 0) echo "</ul></div></section>\n";
?>

<script type="text/javascript">
$(function() {
    var $li20 = $('.sct_rel_20 li .sct_img');
    $li20.each(function() {
        var $des = $(this).children('.sct_des');
        $des.hide();
        $(this).mouseenter(function(e) {
            $des.filter(':not(:animated)').fadeIn(400);
        })
        .mouseleave(function() {
            $('.sct_list_20 li .sct_des').hide();
            $des.filter(':not(:animated)').fadeOut(400);
        });
    });
});
</script>
<!-- } 상품진열 20 끝 -->
<!-- } 상품진열 10 끝 -->