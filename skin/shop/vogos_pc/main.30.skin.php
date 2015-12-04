<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품진열 30 시작 { -->
<?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i % $this->list_mod == 0)
        $sct_last = ' sct_clear'; // 줄 첫번째
    else {
        $sct_last = '';
    }

    if ($i == 0) {
        $video_src = 'https://player.vimeo.com/video/'.$row['it_1'].'?autoplay=0&loop=1&color=333333&title=0&byline=0&portrait=0';
        echo "<div id=\"sct_30_video\">";
        echo "<iframe src=\"".$video_src."\" width=\"350\" height=\"621\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
        echo "</div>";
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_30\">\n";
        }
    }

    echo "<li class=\"sct_li{$sct_last}\" style=\"width:{$this->img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\">\n";
        echo "<div class=\"sct_play_m\"><button type=\"button\" class=\"btn_play_m\" onclick=\"javascript:play_runway(this, '".$row['it_1']."');\"><img src=\"".G5_SHOP_SKIN_URL."/img/play_btn.png\" alt=\"PLAY RUNWAY\"></button></div>";
    }

    if ($this->view_it_img) {
        echo get_it_image2($row['it_id'], 9, $this->img_width, $this->img_height, '', '', stripslashes($row['it_name_kr']))."\n";
    }

    if ($this->href) {
        echo "</div>\n";
    }


    if ($this->href) {
        echo "<div class=\"sct_des\"><div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name_kr) {
        echo stripslashes($row['it_name_kr'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_cust_price_kr || $this->view_it_price_kr) {

        echo "<div class=\"sct_cost\">\n";

        if ($this->view_it_cust_price_kr && $row['it_cust_price_kr']) {
            echo "<strike>".display_price($row['it_cust_price_kr'])."</strike>\n";
        }

        if ($this->view_it_price_kr) {
            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
        }

        echo "</div>";

        echo"<div class=\"sct_cart_m2\">
                <button type=\"button\" class=\"btn_cart_m2\" onclick=\"location.href='{$this->href}{$row['it_id']}'\"><i class=\"ion-checkmark-round\"></i>BUY NOW</button>
        </div>\n";

        echo "</div>\n";


}
    echo "</li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>

<script type="text/javascript">
    function play_runway(e, videoNum) {
        var $video_src = "https://player.vimeo.com/video/"+videoNum+"?autoplay=1&loop=1&color=333333&title=0&byline=0&portrait=0";
        var $video = $('#sct_30_video iframe');

        $('.sct_play_m').fadeIn(300);
        $(e).parent('.sct_play_m').fadeOut(300);
        $video.attr('src', $video_src);
    }

    (function($) {
        var element = $('#sct_30_video'),
            originalY = element.offset().top;
        
        // Space between element and top of screen (when scrolling)
        var topMargin = 80;
        
        // Should probably be set in CSS; but here just for emphasis
        element.css('position', 'relative');
        
        $(window).on('scroll', function(event) {
            var scrollTop = $(window).scrollTop();
            
            if(scrollTop < originalY) {
                topHeight = 0;
            } else if(scrollTop > 860) {
                topHeight = 0;
            } else {
                topHeight = scrollTop - originalY + topMargin;
            }

            element.stop(false, false).animate({
                top: topHeight
            }, 300);
        });
    })(jQuery);

</script>
<!-- } 상품진열 30 끝 -->