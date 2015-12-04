<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_SHOP_SKIN_URL.'/js/unslider.min.js"></script>', 10);
?>

<?php
for ($i=0; $row=sql_fetch_array($result); $i++)
{

    if ($i==0) echo '<aside id="sbn_side" class="sbn"><h2>쇼핑몰 배너</h2><ul>'.PHP_EOL;
    //print_r2($row);
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    if (file_exists($bimg))
    {
        $banner = '';
        $size = getimagesize($bimg);
        echo '<li>'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'&amp;url='.urlencode($row['bn_url']).'"'.$bn_new_win.'>';
        }
        echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" alt="'.$row['bn_alt'].'" width="'.$size[0].'" height="'.$size[1].'"'.$bn_border.'>';
        if($banner)
            echo '</a>'.PHP_EOL;
        echo '</li>'.PHP_EOL;
    }        
}
if ($i>0) {
    echo '</ul>'.PHP_EOL;
    echo '<div class="bn_btn">'.PHP_EOL;
    echo '<button class="unslider-arrow prev">이전 </button>'.PHP_EOL;
    echo '<button class="unslider-arrow next">다음 </button>'.PHP_EOL;
    echo '</div>';
    echo '</aside>'.PHP_EOL;
}
?>

<script>
$(function() {
    var unslider = $("#sbn_side").unslider({
        speed: 700,               //  The speed to animate each slide (in milliseconds)
        delay: 5000,              //  The delay between slide animations (in milliseconds)
        keys: true,               //  Enable keyboard (left, right) arrow shortcuts
        dots: true,               //  Display dot navigation
        fluid: false              //  Support responsive design. May break non-responsive designs
    });

    $('.unslider-arrow').click(function() {
        var fn = this.className.split(' ')[1];

        //  Either do unslider.data('unslider').next() or .prev() depending on the className
        unslider.data('unslider')[fn]();
        });
    });
</script>