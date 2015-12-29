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
        if($i % 5 == 0) {
            $margin_class = ' spot_margin';
        }
    ?>
        <div class="list_spotted">
        	<div class="spot_img">
                <a href="<?php echo $list[$i]['href']; ?>">
                <?php
                    $tw_max = 240; //썸네일 가로 최대 사이즈 
                    $th_max = 320; //썸네일 세로 최대 사이즈 

                    $data_path = G5_URL."/data/file/".$bo_table; 

                    $file_list = urlencode($list[$i][file][0][file]); 
                    if (preg_match("/\.(gif|jpg|png)$/i", $file_list)) { 
                    //$file_ori = $data_path ."/".$file_list; //원본 이미지 

                    $t_w = $list[$i][file][0][image_width]; //원본파일 사이즈 
                    $t_h = $list[$i][file][0][image_height]; 

                    if ($t_w < $tw_max){ 
                     if ($t_h > $th_max){ 
                            $h = $th_max ; 
                            $w = ceil( $t_w * ( $th_max / $t_h ) ); 
                          } else { 
                            $h = $t_h; 
                            $w = $t_w; 
                          } 
                    }else{ 
                        if (( $t_h / $t_w ) > ($th_max / $tw_max)){ 
                            $h = $th_max ; 
                            $w = ceil( $t_w * ( $th_max / $t_h ) ); 
                            }else{ 
                            $w = $tw_max ; 
                            $h = ceil( $t_h * ( $tw_max / $t_w ) ); 
                     } 
                    } 

                    $w = (int)$w; //소수점이하 버림 
                    $h = (int)$h;
                    }

                    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $w, $h);
                    if($thumb['src']) {
                        $img_content = '<img class="img_left" src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'">';
                    } else {
                        $img_content = 'NO IMAGE';
                    }                
                    echo $img_content;  
                ?>
                </a>
            </div>
            <div class="spot_des">
                <ul>
                    <li class="spot_sub"><strong><a href="<?php echo $list[$i]['href']; ?>"><?php echo $list[$i]['subject']; ?></a></strong></li>
                    <li class="spot_content"><a href="<?php echo $list[$i]['href']; ?>"><?php echo preg_replace('/^(&nbsp;)+/', ' ', strip_tags($list[$i]['wr_content'])) ?></a></li>
                </ul>
                <div class="spot_btns">
                    <!-- <a class="buynow" href="<?php //echo G5_SHOP_URL.'/item.php?it_id='.$list[$i]['wr_1']; ?>"><i class=\"ion-checkmark-round\"></i>BUY NOW</a> -->
                    <a class="viewmore" href="<?php echo $list[$i]['href']; ?>"><i class="ion-android-arrow-dropright-circle"></i>SEE MORE</a>
                </div>
            </div>
        </div> <!--list_spotted END -->
    <?php } ?>
</div> <!-- oneshot END -->
<?php add_javascript('<script src="'.$latest_skin_url.'/jaliswall.js"></script>', 10); ?>
<script>
$(document).ready(function() {
    $('#oneshot').jaliswall({item:'.list_spotted'});
});
</script>