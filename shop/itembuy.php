<?php
include_once('./_common.php');

$it_id = $_GET['it_id'];
$io_id = $_GET['opt'];

// 상품정보
$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$it = sql_fetch($sql);

if(!$it['it_id'])
    alert('There is no information for this product.', G5_SHOP_URL);

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($it_id, 'item');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

if(is_soldout($it['it_id']))
    alert('Out of Stock.\\nPlease select other items.', G5_SHOP_URL);

// 상품옵션체크
$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' and io_type = '0' and io_use = '1' ";
$cnt = sql_fetch($sql);

if(($io_id && !$cnt['cnt']) || (!$io_id && $cnt['cnt']))
    alert('Some options are changed.\\nPlease try again.', G5_SHOP_URL.'/item.php?it_id='.$it_id);

// 최소구매수량이 있으면 상세페이지에서 다시 주문토록 안내
if($it['it_buy_min_qty'] > 1)
    alert(get_text($it['it_name_kr']).' The quantity requested is not available.\\nPlease enter a higher quantity.', G5_SHOP_URL.'/item.php?it_id='.$it_id);

// 옵션정보
if($io_id && $it['it_option_subject']) {
    $sql = " select * from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' and io_id = '$io_id' ";
    $opt = sql_fetch($sql);

    $subj = explode(',', $it['it_option_subject']);
    $arr_opt = explode(chr(30), $io_id);

    if(count($subj) != count($arr_opt))
        alert('We could not process your request.\\nPlease try again.', G5_SHOP_URL.'/item.php?it_id='.$it_id);

    $io_value = '';
    $sep = '';
    for($n=0; $n<count($subj); $n++) {
        $io_value .= $sep.$subj[$n].':'.$arr_opt[$n];
        $sep = ' / ';
    }
} else {
    $io_value = $it['it_name_kr'];
}

$tot_prc = $it['it_price_kr'] + $opt['io_price'];

// 배송비결제
$ct_send_cost = 0;
if($it['it_sc_type'] == 1)
    $ct_send_cost = 2; // 무료
else if($it['it_sc_type'] > 1 && $it['it_sc_method'] == 1)
    $ct_send_cost = 1; // 착불

$_POST['it_id'][0] = $it['it_id'];
$_POST['io_id'][$it['it_id']][0] = $opt['io_id'];
$_POST['io_type'][$it['it_id']][0] = 0;
$_POST['ct_qty'][$it['it_id']][0] = 1;
$_POST['io_value'][$it['it_id']][0] = $io_value;
$_POST['ct_send_cost'] = $ct_send_cost;

include_once(G5_SHOP_PATH.'/cartupdate.php');
?>