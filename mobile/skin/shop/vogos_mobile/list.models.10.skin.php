<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

    <ul id="mds_list">
<?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
?>
    <li>
    <a class="mds_href" href="<?php echo G5_MSHOP_URL.'/models.php?mds_id='.$row['mds_id'] ?>">
        <div class="mds_bimg">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH.'/models/'.$row['mds_id'].'_b';

            if (file_exists($bimg)) {
                $bimg_str = '<img src="'.G5_DATA_URL.'/models/'.$row['mds_id'].'_b" alt="">';
            }
            if ($bimg_str) {
                echo $bimg_str;
            }
            ?>
        </div>
        <div class="mds_des">
            <h3 class="mds_subject"><?=$row['mds_subject'] ?></h3>
            <?php
                $cut_summary = strip_tags($cut_summary);
                $cut_summary = mb_substr($row['mds_html'], 0, 214, "UTF-8");
                $cut_summary.= "...";
            ?>
            <div class="mds_sum"><?=$cut_summary; ?><span style="display:inline-block;float:right;color:#888;font-weight:bold;font-size:13px;">&gt; 더보기</span>
            <ul id="mds_imglist">
                <!-- 모델스초이스 영상 캡쳐이미지 리스트에서 최대 3개 출력 -->
                <?php for($i=1; $i<=3; $i++) { ?>
                <li>
                    <?php
                    $simg_str = "";
                    $simg = G5_DATA_PATH.'/models/'.$row['mds_id'].'_s'.$i;

                    if (file_exists($simg)) {
                        $simg_str = '<img src="'.G5_DATA_URL.'/models/'.$row['mds_id'].'_s'.$i.'" width="60" alt="">';
                    }
                    if ($simg_str) {
                        echo $simg_str;
                    }
                    ?>
                </li>
                <?php } ?>
                <!-- 모델스초이스 영상 캡쳐이미지 리스트에서 최대 3개 출력 -->
            </ul>
            </div>
        </div>
    </a>
    </li>
    <?php } // for END ?>
    </ul>