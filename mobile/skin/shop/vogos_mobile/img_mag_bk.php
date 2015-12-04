<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
        <div id="sit_pvi">
            <div id="sit_pvi_img">
<div id="sync1" class="owl-carousel">
<?php
if (!empty($it['it_1'])) { // 확장변수 있을 경우 비디오 삽입
    echo '<div class="item-video"><a class="owl-video" href="http://vimeo.com/'.$it['it_1'].'"></a></div>';
}
$thumbnails = array();
for($i=1; $i<=10; $i++) {
    if(!$it['it_img'.$i])
        continue;
    $thumb_img_w = 280; // 넓이
    $thumb_img_h = 392; // 높이
    $img = get_it_thumbnail($it['it_img'.$i], $thumb_img_w, $thumb_img_h);
    if($img) {
        $thumb = get_it_thumbnail($it['it_img'.$i], 120, 168);
        $thumbnails[] = $thumb;

        echo '<div class="vitem">'.$img.'</div>';
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
        echo '<div id="thumbVideo"><img src="'.G5_MSHOP_SKIN_URL.'/img/play_button_small.png" width="60" height="84"></div>';
    }
    foreach($thumbnails as $val) {
        $thumb_count++;
        echo '<div class="thumbimg">'.$val.'</div>';
    }
}
    echo '</div>';
?>
            </div> <!-- sit_pvi_img END -->
        </div> <!-- sit_pvi END -->
<script>
// img_mag.js에서 사용하는 상품 이미지 돋보기 변수 처리

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