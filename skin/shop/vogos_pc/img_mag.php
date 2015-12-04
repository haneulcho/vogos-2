<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
        <div id="sit_pvi">
            <div id="sit_pvi_img">
<div id="sync1" class="owl-carousel">
<?php
if (!empty($it['it_1'])) { // 확장변수 있을 경우 비디오 삽입
    echo '<div class="item-video"><a class="owl-video" href="http://vimeo.com/'.$it['it_1'].'"></a></div>';
}
$big_img_count = 0;
$thumbnails = array();
for($i=1; $i<=10; $i++) {
    if(!$it['it_img'.$i])
        continue;
    $img = get_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);
    // 정규식으로 상세정보 작은 이미지의 src, width, height를 가져옴
    if($img) {

        for($k=0; $k<3; $k++) {
            if ($k==0) {
                $regex = '@src="([^"]+)"@';
            }
            else if ($k==1) {
                $regex = '@width\=\"([0-9]+)"@';
            }
            else {
                $regex = '@height\=\"([0-9]+)"@';
            }
            preg_match_all($regex, $img, ${'match'.$k});
            ${'s'.$k} = ${'match'.$k}[1][0];
        }
        // 큰 이미지의 width, height를 가져옴
        $size = getimagesize(G5_DATA_PATH.'/item/'.$it['it_img1']);

        $thumb = get_it_thumbnail($it['it_img'.$i], 80, 112);
        $thumbnails[] = $thumb;
        $big_img_count++;

        echo '<div class="item">'.$img.'</div>';
    }
} // for END
?>
</div>
<?php
// 썸네일
$thumb1 = true;
$thumb_count = 0;
$total_count = count($thumbnails);
if($total_count > 0) {
    echo '<div class="dotsCont">';
    if (!empty($it['it_1'])) { // 확장변수 있을 경우 비디오 삽입
        echo '<div id="thumbVideo"><img src="'.G5_SHOP_SKIN_URL.'/img/play_button_small.png" width="60" height="84"></div>';
    }
    foreach($thumbnails as $val) {
        $thumb_count++;
        echo '<div>'.$val.'</div>';
    }
}
    echo '</div>';
?>
            </div> <!-- sit_pvi_img END -->
        </div> <!-- sit_pvi END -->
<script>
// img_mag.js에서 사용하는 상품 이미지 돋보기 변수 처리
sSrc = "<?php echo $s0; ?>";
sWidth = "<?php echo $s1; ?>";
sHeight = "<?php echo $s2; ?>";
bSrc = "<?php echo G5_DATA_URL.'/item/'.$it['it_img1']; ?>";
bWidth = "<?php echo $size[0]; ?>";
bHeight = "<?php echo $size[1]; ?>";

$(function() {
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    sync1.owlCarousel({
    items: 1,
    video:true,
    loop: false,
    nav: false,
    autoplay: false,
    smartSpeed: 500,
    dotsSpeed: 500,
    margin: 0,
    autoHeight: true,
    dotsContainer: '.dotsCont'
    });
    $('#thumbVideo').on('click', function(){
        $(".active .owl-video-play-icon").trigger("click")
    });
});
</script>