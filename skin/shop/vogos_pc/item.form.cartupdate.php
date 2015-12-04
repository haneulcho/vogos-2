<?php
include_once('./_common.php');

// cart id 설정
if($sw_direct) {
    if(!get_session('ss_cart_direct')) {
        set_cart_id($sw_direct);
    }

    $tmp_cart_id = get_session('ss_cart_direct');
} else {
    if(!get_session('ss_cart_id')) {
        set_cart_id($sw_direct);
    }

    $tmp_cart_id = get_session('ss_cart_id');
}

// 브라우저에서 쿠키를 허용하지 않은 경우라고 볼 수 있음.
if (!$tmp_cart_id)
{
    die('You might not be able to take advantage of certain functions of our site.\n\nYou may need to enable cookies.\n\nPlease enable cookies on your device. (Internet option)');
}


// 레벨(권한)이 상품구입 권한보다 작다면 상품을 구입할 수 없음.
if ($member['mb_level'] < $default['de_level_sell'])
{
    die('Sorry! You are not authorized.');
}

$count = count($_POST['it_id']);
if ($count < 1)
    die('Please select items to remove from your cart.');

$ct_count = 0;
for($i=0; $i<$count; $i++) {
    $it_id = $_POST['it_id'][$i];
    $opt_count = count($_POST['io_id'][$it_id]);

    if($opt_count && $_POST['io_type'][$it_id][0] != 0)
        die('Please select an option.');

    for($k=0; $k<$opt_count; $k++) {
        if ($_POST['ct_qty'][$it_id][$k] < 1)
            die('Please specify a quantity to enable the "Add To Shopping Bag" button.');
    }

    // 상품정보
    $sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);
    if(!$it['it_id'])
        die('There is no information for this product.');

    // 최소, 최대 수량 체크
    if($it['it_buy_min_qty'] || $it['it_buy_max_qty']) {
        $sum_qty = 0;
        for($k=0; $k<$opt_count; $k++) {
            if($_POST['io_type'][$it_id][$k] == 0)
                $sum_qty += $_POST['ct_qty'][$it_id][$k];
        }

        if($it['it_buy_min_qty'] > 0 && $sum_qty < $it['it_buy_min_qty'])
            die('The quantity requested is not available. Please enter a lower quantity.');

        if($it['it_buy_max_qty'] > 0 && $sum_qty > $it['it_buy_max_qty'])
            die('The quantity requested is not available. Please enter a lower quantity.');

        // 기존에 장바구니에 담긴 상품이 있는 경우에 최대 구매수량 체크
        if($it['it_buy_max_qty'] > 0) {
            $sql4 = " select count(*) as cnt
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '$tmp_cart_id'
                          and it_id = '$it_id'
                          and io_type = '0'
                          and ct_status = '쇼핑' ";
            $row4 = sql_fetch($sql4);

            if(($sum_qty + $row4['cnt']) > $it['it_buy_max_qty'])
                die('The quantity requested is not available. Please enter a lower quantity.');
        }
    }

    // 옵션정보를 얻어서 배열에 저장
    $opt_list = array();
    $sql = " select * from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' order by io_no asc ";
    $result = sql_query($sql);
    $lst_count = 0;
    for($k=0; $row=sql_fetch_array($result); $k++) {
        $opt_list[$row['io_type']][$row['io_id']]['id'] = $row['io_id'];
        $opt_list[$row['io_type']][$row['io_id']]['use'] = $row['io_use'];
        $opt_list[$row['io_type']][$row['io_id']]['price'] = $row['io_price'];
        $opt_list[$row['io_type']][$row['io_id']]['stock'] = $row['io_stock_qty'];

        // 선택옵션 개수
        if(!$row['io_type'])
            $lst_count++;
    }

    //--------------------------------------------------------
    //  재고 검사
    //--------------------------------------------------------
    // 이미 장바구니에 있는 같은 상품의 수량합계를 구한다.
    for($k=0; $k<$opt_count; $k++) {
        $io_id = $_POST['io_id'][$it_id][$k];
        $io_type = $_POST['io_type'][$it_id][$k];
        $io_value = $_POST['io_value'][$it_id][$k];

        $sql = " select SUM(ct_qty) as cnt from {$g5['g5_shop_cart_table']}
                  where od_id <> '$tmp_cart_id'
                    and it_id = '$it_id'
                    and io_id = '$io_id'
                    and io_type = '$io_type'
                    and ct_stock_use = 0
                    and ct_status = '쇼핑' ";
        $row = sql_fetch($sql);
        $sum_qty = $row['cnt'];

        // 재고 구함
        $ct_qty = $_POST['ct_qty'][$it_id][$k];
        if(!$io_id)
            $it_stock_qty = get_it_stock_qty($it_id);
        else
            $it_stock_qty = get_option_stock_qty($it_id, $io_id, $io_type);

        if ($ct_qty + $sum_qty > $it_stock_qty)
        {
            die('The quantity requested is not available. Please enter a lower quantity.\n\nIn stock : ' . number_format($it_stock_qty - $sum_qty));
        }
    }
    //--------------------------------------------------------

    // 바로구매에 있던 장바구니 자료를 지운다.
    if($i == 0 && $sw_direct)
        sql_query(" delete from {$g5['g5_shop_cart_table']} where od_id = '$tmp_cart_id' and ct_direct = 1 ", false);

    // 장바구니에 Insert
    // 바로구매일 경우 장바구니가 체크된것으로 강제 설정
    if($sw_direct)
        $ct_select = 1;
    else
        $ct_select = 0;

    // 장바구니에 Insert
    $comma = '';
    $sql = " INSERT INTO {$g5['g5_shop_cart_table']}
                    ( od_id, mb_id, it_id, it_name_kr, it_sc_type, it_sc_method, it_sc_price, it_sc_minimum, it_sc_qty, ct_status, ct_price_kr, ct_price_en, ct_point, ct_point_use, ct_stock_use, ct_option, ct_qty, ct_notax, io_id, io_type, io_price, ct_time, ct_ip, ct_send_cost, ct_direct, ct_select )
                VALUES ";

    for($k=0; $k<$opt_count; $k++) {
        $io_id = $_POST['io_id'][$it_id][$k];
        $io_type = $_POST['io_type'][$it_id][$k];
        $io_value = $_POST['io_value'][$it_id][$k];

        // 선택옵션정보가 존재하는데 선택된 옵션이 없으면 건너뜀
        if($lst_count && $io_id == '')
            continue;

        // 구매할 수 없는 옵션은 건너뜀
        if($io_id && !$opt_list[$io_type][$io_id]['use'])
            continue;

        $io_price = $opt_list[$io_type][$io_id]['price'];
        $ct_qty = $_POST['ct_qty'][$it_id][$k];

        // 구매가격이 음수인지 체크
        if($io_type) {
            if((int)$io_price < 0)
                die('Please enter valid number.');
        } else {
            if((int)$it['it_price_kr'] + (int)$io_price < 0)
                die('Please enter valid number.');
        }

        // 동일옵션의 상품이 있으면 수량 더함
        $sql2 = " select ct_id
                    from {$g5['g5_shop_cart_table']}
                    where od_id = '$tmp_cart_id'
                      and it_id = '$it_id'
                      and io_id = '$io_id'
                      and ct_status = '쇼핑' ";
        $row2 = sql_fetch($sql2);
        if($row2['ct_id']) {
            $sql3 = " update {$g5['g5_shop_cart_table']}
                        set ct_qty = ct_qty + '$ct_qty'
                        where ct_id = '{$row2['ct_id']}' ";
            sql_query($sql3);
            continue;
        }

        // 포인트
        $point = 0;
        if($config['cf_use_point']) {
            if($io_type == 0) {
                $point = get_item_point($it, $io_id);
            } else {
                $point = $it['it_supply_point'];
            }

            if($point < 0)
                $point = 0;
        }

        // 배송비결제
        if($it['it_sc_type'] == 1)
            $ct_send_cost = 2; // 무료
        else if($it['it_sc_type'] > 1 && $it['it_sc_method'] == 1)
            $ct_send_cost = 1; // 착불

        $sql .= $comma."( '$tmp_cart_id', '{$member['mb_id']}', '{$it['it_id']}', '".addslashes($it['it_name_kr'])."', '{$it['it_sc_type']}', '{$it['it_sc_method']}', '{$it['it_sc_price']}', '{$it['it_sc_minimum']}', '{$it['it_sc_qty']}', '쇼핑', '{$it['it_price_kr']}', '$point', '0', '0', '$io_value', '$ct_qty', '{$it['it_notax']}', '$io_id', '$io_type', '$io_price', '".G5_TIME_YMDHIS."', '$REMOTE_ADDR', '$ct_send_cost', '$sw_direct', '$ct_select' )";
        $comma = ' , ';
        $ct_count++;
    }

    if($ct_count > 0)
        sql_query($sql);
}

die('OK');
?>