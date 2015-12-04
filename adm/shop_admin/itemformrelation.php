<?php
$sub_menu = '400300';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$ca_id = trim($ca_id);
$it_name_kr = trim(strip_tags($it_name_kr));

if(!$ca_id && !$it_name_kr)
    die('<p>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>');

$sql = " select ca_id, it_id, it_name_kr, it_price_kr
           from {$g5['g5_shop_item_table']}
          where it_id <> '$it_id' ";
if($ca_id)
    $sql .= " and ( ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%' ) ";

if($it_name_kr)
    $sql .= " and it_name_kr like '%$it_name_kr%' ";

$sql .= " order by ca_id, it_name_kr ";
$result = sql_query($sql);

$list = '';

for($i=0;$row=sql_fetch_array($result);$i++) {
    $sql2 = " select count(*) as cnt from {$g5['g5_shop_item_relation_table']} where it_id = '$it_id' and it_id2 = '{$row['it_id']}' ";
    $row2 = sql_fetch($sql2);
    if ($row2['cnt'])
        continue;

    $it_name_kr = get_it_image($row['it_id'], 50, 50).' '.$row['it_name_kr'];

    $list .= '<li class="list_res">';
    $list .= '<input type="hidden" name="re_it_id[]" value="'.$row['it_id'].'">';
    $list .= '<div class="list_item">'.$it_name_kr.'</div>';
    $list .= '<div class="list_item_btn"><button type="button" class="add_item btn_frmline">추가</button></div>';
    $list .= '</li>'.PHP_EOL;
}

if($list)
    $list = '<ul>'.$list.'</ul>';
else
    $list = '<p>등록된 상품이 없습니다.';

echo $list;
?>