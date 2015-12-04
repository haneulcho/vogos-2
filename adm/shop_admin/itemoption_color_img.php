<?php
include_once('./_common.php');

$po_run = false;

if($it['it_id']) {
    $sql = " select * from {$g5['g5_shop_item_option_table']} where io_type = '0' and it_id = '{$it['it_id']}' order by io_no asc ";
    $result = sql_query($sql);

    if(mysql_num_rows($result))
        $po_run = true;
} else if(!empty($_POST)) {


    $po_run = true;
}

if($po_run) {
?>

<section id="it_color_img">
    <h2 class="h2_frm">상품선택옵션 이미지</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>이미지 업로드</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
    <?php
    if($it['it_id']) {
        foreach($it_color_result as $key){
            echo $key."</br>";
    ?>
        <tr>
            <th scope="row"><label for="it_color_img">
            <?php
            echo '<span style="display:block;color:#ff0000;font-weight:bold">'.$key.'</span>';
            ?></label></th>
            <td>
                <input type="file" name="it_color_img" id="it_color_img">
                <?php
                $it_color_img = G5_DATA_PATH.'/item/'.$it['it_color_img'];
                if(is_file($it_color_img) && $it['it_color_img']) {
                    $size = @getimagesize($it_color_img);
                    $thumb = get_it_thumbnail($it['it_color_img'], 30, 30);
                ?>
                <label for="it_color_img_del"><span class="sound_only">이미지 </span>파일삭제</label>
                <input type="checkbox" name="it_color_img_del" id="it_color_img_del" value="1">
                <span><?php echo $thumb; ?></span>
                <div id="limg" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/item/<?php echo $it['it_color_img']; ?>" alt="" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
                <?php } ?>
            </td>
        </tr>

    <?php
        } // end foreach
    } else {
        // 기존에 설정된 값이 있는지 체크
        if($_POST['w'] == 'u') {
            $sql = " select io_price, io_stock_qty, io_noti_qty, io_use
                        from {$g5['g5_shop_item_option_table']}
                        where it_id = '{$_POST['it_id']}'
                          and io_id = '$opt_id'
                          and io_type = '0' ";
            $row = sql_fetch($sql);

            if($row) {
                $opt_price = (int)$row['io_price'];
                $opt_stock_qty = (int)$row['io_stock_qty'];
                $opt_noti_qty = (int)$row['io_noti_qty'];
                $opt_use = (int)$row['io_use'];
            }
        }
    ?>
        <tr>
            <th scope="row"><label for="it_color_img">
            <?php
            echo '<span style="display:block;color:#ff0000;font-weight:bold">상품옵션 컬러이미지</span>';
            ?></label></th>
            <td>
                먼저 상품옵션을 선택하세요.
            </td>
        </tr>
    <?php
    } // END else
    ?>
        </tbody>
        </table>
    </div>
</section>


<?php
} // END po_run
?>