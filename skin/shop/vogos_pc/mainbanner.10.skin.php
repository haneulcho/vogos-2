<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>
<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
<?php
$max_width = $max_height = 0;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    if ($i==0) {
        echo '<section class="sbn">'.PHP_EOL.'<h2>쇼핑몰 배너</h2>'.PHP_EOL;
        echo '<div class="owl_btns fullWidth"><div class="owl_btn nextBtn"><i class="ion-ios-arrow-right"></i></div>'.PHP_EOL;
        echo '<div class="owl_btn prevBtn"><i class="ion-ios-arrow-left"></i></div></div>'.PHP_EOL;

        echo '<div id="sync1" class="owl-carousel">'.PHP_EOL;
    }
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    if (file_exists($bimg))
    {
        $banner = '';
        $size = getimagesize($bimg);

        if($size[2] < 1 || $size[2] > 16)
            continue;

        if($max_width < $size[0])
            $max_width = $size[0];

        if($max_height < $size[1])
            $max_height = $size[1];


        echo '<div class="owl_item">'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a style="background:url('.G5_DATA_URL.'/banner/'.$row['bn_id'].') center top no-repeat;display:block;margin:0 auto;min-width:1100px;height:350px;text-indent:-9999px;font-size:0;" href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'&amp;url='.urlencode($row['bn_url']).'"'.$bn_new_win.'>';
        }
        echo $banner.$row['bn_alt'];
        //echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.$row['bn_alt'].'"'.$bn_border.'>';
        if($banner)
            echo '</a>'.PHP_EOL;
        echo '</div>'.PHP_EOL;

        $bn_first_class = '';
    }
}
if ($i>0) echo '</div>'.PHP_EOL.'</section>'.PHP_EOL;
?>

<script>
$(function() {
    var sync1 = $("#sync1");
    sync1.owlCarousel({
    items: 1,
    loop: true,
    nav: false,
    autoplay: true,
    smartSpeed: 500,
    margin: 0,
    dots: false,
    autoHeight: true
    });
    //sync1.on('mousewheel', '.owl-stage', function (e) {
    //    if (e.deltaY>0) {
    //        sync1.trigger('next.owl');
    //    } else {
    //        sync1.trigger('prev.owl');
    //    }
    //    e.preventDefault();
    // });
    // Go to the next item
    $('.nextBtn').click(function() {
        sync1.trigger('next.owl.carousel');
    })
    // Go to the previous item
    $('.prevBtn').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        sync1.trigger('prev.owl.carousel', [500]);
    })
});
</script>