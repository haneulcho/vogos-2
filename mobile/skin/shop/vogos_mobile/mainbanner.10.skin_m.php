<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<?php
$max_width = $max_height = 0;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    if ($i==0) echo '<section id="sbn_idx" class="sbn">'.PHP_EOL.'<h2>VOGOS BANNER</h2>'.PHP_EOL.'<div id="main_event" class="owl-carousel2">'.PHP_EOL;
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

        if($size[2] < 1 || $size[2] > 16)
            continue;

        if($max_width < $size[0])
            $max_width = $size[0];

        if($max_height < $size[1])
            $max_height = $size[1];

        echo '<div>'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'&amp;url='.urlencode($row['bn_url']).'"'.$bn_new_win.'>';
        }
        echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.$row['bn_alt'].'"'.$bn_border.'>';
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
    var owl2 = $('.owl-carousel2');
    owl2.owlCarousel({
        items: 1, // items가 1일 때 loop 옵션 주면 멈추니 주의할 것
        autoHeight: true,
        margin: 0,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        autoplaySpeed: 800,
        smartSpeed: 500,
        dotsSpeed: 800
    });
});
</script>