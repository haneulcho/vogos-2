<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_SHOP_SKIN_URL.'/js/jquery.shop.list.js"></script>', 10);
?>

<!-- 상품진열 20 시작 { -->
<?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i == 0) {
        $sct_last = ' sct_big'; // 줄 첫번째
        $sct_img_width = 550;
        $sct_img_height = 770;
    } else {
        $sct_last = '';
        $sct_img_width = $this->img_width;
        $sct_img_height = $this->img_height;
    }

    if ($i == 0) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_20\">\n";
        }
    }

    echo "<li class=\"sct_li{$sct_last}\" style=\"width:{$sct_img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image2($row['it_id'], 10, $sct_img_width, $sct_img_height, '', '', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }


    if ($this->href) {
        echo "<div class=\"sct_des\"><div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";

        if ($i == 0) {
            echo "<span class=\"sct_txt_big\">VOGOS F/W COLLECTION</span>";
        }
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

        echo "</div>";

        echo"<div class=\"sct_cart\">
            <div class=\"sct_cart_btn\" style=\"width:{$sct_img_width}px;height:40px\">
                <button type=\"button\" class=\"btn_cart\" data-it_id=\"{$row['it_id']}\"><i class=\"ion-android-cart\"></i>ADD TO CART</button>
            </div>
            <div class=\"sct_cart_op\"></div>
        </div>\n";

        echo "</div><div class=\"sct_des_bg\"></div>\n";


}
    echo "</li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 20 끝 -->

<script type="text/javascript">
$(function() {
    var $li20 = $('.sct_20 li');
    $li20.each(function() {
        var $des = $(this).children('.sct_des');
        var $des_bg = $(this).children('.sct_des_bg');
        $(this).mouseenter(function(e) {
            $('.sct_20 li .sct_des').fadeOut(100);
            $('.sct_20 li .sct_des_bg').fadeOut(100);
            $des.fadeIn(300);
            $des_bg.fadeIn(300);
        })
        .mouseleave(function() {
            $des.fadeOut(300);
            $des_bg.fadeOut(300);
        });
    });
});
</script>