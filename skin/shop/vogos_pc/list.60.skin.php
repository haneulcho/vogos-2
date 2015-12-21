<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
 
<!-- 상품진열 60 (서브 카테고리 우측 상품 리스트) 시작 { -->
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
            echo "<ul class=\"sct_60\">\n";
        }
    }

    echo "<li class=\"sct_li{$sct_last}\" style=\"width:{$this->img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image2($row['it_id'], 2, $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."</a></div>\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_des\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
        echo "</a>\n";
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
    }

    if ($this->href) {
        echo "</div>\n"; //sct_des END
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
<!-- } 상품진열 60 서브 카테고리 우측 상품 리스트 끝 -->