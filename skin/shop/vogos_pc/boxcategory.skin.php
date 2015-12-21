<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 쇼핑몰 카테고리 시작 { -->
<nav id="gnb">
    <h2>쇼핑몰 카테고리</h2>
    <ul id="gnb_1dul">
        <?php
        // 1단계 분류 판매 가능한 것만
        $hsql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' order by ca_order, ca_id ";
        $hresult = sql_query($hsql);
        for ($i=0; $row=sql_fetch_array($hresult); $i++)
        {
            // 2단계 분류 판매 가능한 것만
            $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
            $result2 = sql_query($sql2);
            $count = mysql_num_rows($result2);
        ?>
        <li class="gnb_1dli">
            <a href="<?php echo G5_SHOP_URL.'/list.php?ca_id='.$row['ca_id']; ?>" class="gnb_1da<?php if ($count) echo ' gnb_1dam'; if ($row['ca_id'] == '60' || $row['ca_id'] == '90') echo ' point'; ?>"><?php echo $row['ca_name']; ?></a>
            <?php
            for ($j=0; $row2=sql_fetch_array($result2); $j++)
            {
                // 3단계 분류 판매 가능한 것만
                $sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '6' and SUBSTRING(ca_id,1,4) = '{$row2['ca_id']}' and ca_use = '1' order by ca_order, ca_id ";
                $result3 = sql_query($sql3);

                if ($j==0) { echo '<div class="gnb_con"><div class="gnb_sub"><div class="gnb_sub_m"><h2>'.$row['ca_name'].'</h2><ul class="gnb_2dul">'; }
            ?>
                <li class="gnb_2dli"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row2['ca_id']; ?>" class="gnb_2da"><?php echo $row2['ca_name']; ?></a>
                    <?php for ($k=0; $row3=sql_fetch_array($result3); $k++) {
                        if ($k==0) { echo '<ul class="gnb_3dul">'; }
                    ?>
                        <li class="gnb_3dli"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row3['ca_id']; ?>" class="gnb_3da"><?php echo $row3['ca_name']; ?></a></li>
                    <?php }
                    if ($k>0) { echo '</ul>';} ?>
                </li>
            <?php } // row2 for END
            if ($j>0) {
                echo '</ul></div>';
            ?>
            <div class="gnb_sub_s">
                <h3><?php echo $row['ca_name']; ?><span> / NEW ARRIVALS</span></h3>
                <?php
                    $set_cate = $row['ca_id'];
                    $order_by = 'it_time desc';
                    $list = new item_list();
                    $list->set_category($set_cate, 1);
                    $list->set_order_by($order_by);
                    $list->set_list_mod(3);
                    $list->set_list_row(1);
                    $list->set_img_size(168, 55);
                    $list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.60.skin.php');
                    $list->set_view('it_img', true);
                    $list->set_view('it_id', true);
                    $list->set_view('it_name', true);
                    $list->set_view('it_basic', false);
                    $list->set_view('it_cust_price', true);
                    $list->set_view('it_price', true);
                    $list->set_view('it_icon', false);
                    $list->set_view('sns', false);
                    echo $list->run();
                ?>
            </div>
            <?php
                echo '</div></div>'; // gnb_sub, gnb_con END
                } // $j>0 END
            ?>
        </li>
        <?php } ?>
        <li class="gnb_1dli">
            <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=spotted" class="gnb_1da point">SPOTTED</a>
        </li>
    </ul>
</nav>
<!-- } 쇼핑몰 카테고리 끝 -->