<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$imgwidth = 340; //표시할 이미지의 가로사이즈
$imgheight = 440; //표시할 이미지의 세로사이즈
?>
<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css">

<div id="oneshot">
<?php for ($i=0; $i<count($list); $i++) {
    $margin_class = '';
    if($i % 3 == 0) {
        $margin_class = ' spot_margin';
    }
?>
    <div class="list_spotted<?php echo $margin_class; ?>">
        <div class="spot_des" style="width:<?php echo $imgwidth; ?>px">
            <ul>
                <li class="spot_sub"><strong><a href="<?php echo $list[$i]['href']; ?>"><?php echo cut_str($list[$i]['subject'], 20, "..") ?></a></strong></li>
                <li class="spot_content"><a href="<?php echo $list[$i]['href']; ?>"><?php echo get_text(cut_str(strip_tags($list[$i]['wr_content']), 50, '...' )) ?></a></li>
            </ul>
        </div>
    	<div class="spot_img" style="width:<?php echo $imgwidth ?>px; height:<?php echo $imgheight ?>px">
            <a href="<?php echo $list[$i]['href']; ?>">
            <?php                
                                $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $imgwidth, $imgheight);    					            
                                if($thumb['src']) {
                                    $img_content = '<img class="img_left" src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" width="'.$imgwidth.'" height="'.$imgheight.'">';
                                } else {
                                    $img_content = 'NO IMAGE';
                                }                
                                echo $img_content;  
            ?>
            </a>
        </div>
        <div class="spot_video">
            <?php  ?>
        </div>
    </div>
<?php } ?>
</div>