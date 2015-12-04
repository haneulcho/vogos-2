<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>
<div class="item">
<script src="<?php echo G5_JS_URL ?>/jquery.fancylist.js"></script>
<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<!-- 상품진열 20 시작 { -->
<?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i == 6) {
        $sct_big = true;
        $sct_last = ' sct_big';
        $sct_img_width = '540';
        $sct_img_height = '720';
    } else {
        $sct_big = false;
        $sct_last = '';
    }
    if ($i == 0) {
        if ($this->css) {
            echo "<ul class=\"sct_wrap {$this->css}\">\n";
        } else {
            echo "<ul class=\"sct_wrap sct sct_main_20\">\n";
        }
    }
    echo "<li class=\"sct_li{$sct_last}\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        if($sct_big) {
            echo get_it_image2($row['it_id'], 8, $sct_img_width, $sct_img_height, '', '', stripslashes($row['it_name']))."\n";
        } else {
            echo get_it_image2($row['it_id'], 8, $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
        }
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_icon) {
        echo "<div class=\"sct_icon\">".item_icon($row)."</div>\n";
    }

    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_des\"><div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\">".stripslashes($row['it_basic'])."</div>\n";
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

        echo"<div class=\"sct_cart_m\">
                <button type=\"button\" class=\"btn_cart_m\" onclick=\"location.href='{$this->href}{$row['it_id']}'\"><i class=\"ion-android-cart\"></i>CART</button>
        </div>\n";

        echo "</div>\n";

    }

    echo "</li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">No more items.</p>\n";
?>
<!-- } 상품진열 10 끝 -->

<script>
(function($) {
    var li = $('.sct_main_20 .sct_li');
    var win_width = $(window).width();
    li.each(function() {
        if (!$(this).hasClass('sct_big')) {
            if(win_width>1023) { var lic = 1024 }
                else if(win_width>767) { var lic = 768 }
                else if(win_width>639) { var lic = 640 }
                else if(win_width>479) { var lic = 480 }
                else if(win_width>359) { var lic = 360 }
                else { var lic = 340 }
            var lic = 'lic'+lic;
            $(this).addClass(lic);            
        }        
    });
}(jQuery));
$(document).ready(function () {
    $('.sct_main_20').hide(0).fadeIn(1000);
 });
</script>