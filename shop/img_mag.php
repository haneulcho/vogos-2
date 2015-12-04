<?php
$big_img_count = 0;
$thumbnails = array();
for($i=1; $i<=10; $i++) {
    if(!$it['it_img'.$i])
        continue;
    $img = get_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);
    if($img) {
        $big_img_count++;

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
        	preg_match_all($regex, $img, $match.$k);
        	$s.$k = $match.$k[1][0];
        }
/*        preg_match_all('@src="([^"]+)"@', $img, $match);
        $sSrc = $match[1][0];
        preg_match_all('@width\=\"([0-9]+)"@', $img, $match2);
        $sWidth = $match2[1][0];
        preg_match_all('@height\=\"([0-9]+)"@', $img, $match3);
        $sHeight = $match3[1][0];*/

        $size = getimagesize(G5_DATA_PATH.'/item/'.$it['it_img1']);
    }
}
if($big_img_count == 0) {
    $sSrc = '<img src="'.G5_SHOP_URL.'/img/no_image.gif" alt="">';
}
?>
<script>
// img_mag.js에서 사용하는 상품 이미지 돋보기 변수 처리
sSrc = "<?php echo $s0; ?>";
sWidth = "<?php echo $s1; ?>";
sHeight = "<?php echo $s2; ?>";

bSrc = "<?php echo G5_DATA_URL.'/item/'.$it['it_img1']; ?>";
bWidth = "<?php echo $size[0]; ?>";
bHeight = "<?php echo $size[1]; ?>";
</script>
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/Aui-core-1.42-min.js"></script>
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/img_mag.js"></script>
		<div id="sit_pvi">
			<div id="sit_pvi_small">
				<span id="mask">
					<div></div>
				</span>
				<samp id="bg"></samp>
			</div>
			<div id="sit_pvi_big">
			</div>
		</div>