<?php
$sub_menu = '400400';
include_once('./_common.php');

if($_POST['mod_type'] == 'info') {
    $sql = " update {$g5['g5_shop_order_table']}
                set od_name = '$od_name',
                    od_name_last = '$od_name_last',
                    od_tel = '$od_tel',
                    od_hp = '$od_hp',
                    od_zip = '$od_zip',
                    od_addr1 = '$od_addr1',
                    od_addr2 = '$od_addr2',
                    od_country = '$od_country',
                    od_city = '$od_city',
                    od_email = '$od_email',
                    od_b_name = '$od_b_name',
                    od_b_name_last = '$od_b_name_last',
                    od_b_tel = '$od_b_tel',
                    od_b_hp = '$od_b_hp',
                    od_b_zip = '$od_b_zip',
                    od_b_country = '$od_b_country',
                    od_b_city = '$od_b_city',
                    od_b_addr1 = '$od_b_addr1',
                    od_b_addr2 = '$od_b_addr2' ";
    if ($default['de_hope_date_use'])
        $sql .= " , od_hope_date = '$od_hope_date' ";
} else {
    $sql = "update {$g5['g5_shop_order_table']}
                set od_shop_memo = '$od_shop_memo' ";
}
$sql .= " where od_id = '$od_id' ";
sql_query($sql);

$qstr = "sort1=$sort1&amp;sort2=$sort2&amp;sel_field=$sel_field&amp;search=$search&amp;page=$page";

goto_url("./orderform.php?od_id=$od_id&amp;$qstr");
?>
