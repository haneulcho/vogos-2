<?php
include_once('./_common.php');

include_once('./_head.php');

$sql1 = " select * from {$g5['g5_shop_item_table']} ";
$result1 = sql_query($sql1);
?>

<table>
<?php for ($i=0; $it=mysql_fetch_array($result1); $i++) { ?>
<tr>
<td><?php
if($it['it_use'] == 1) {
    echo '판매중 - ';
} else {
    echo '판매안함 - ';
}
echo $it['it_name']; ?></td>
<td>
<?php
$sql2 = " select * from {$g5['g5_shop_item_option_table']}
                where io_type = '0'
                  and it_id = '{$it['it_id']}'
                  and io_use = '1'
                order by io_no asc ";
$result2 = sql_query($sql2);

    $color = array();
    for ($j=0; $row=mysql_fetch_array($result2); $j++) {
        $opt_id = $row['io_id'];
        $opt_val = explode(chr(30), $opt_id);
        $opt = $opt_val[1];

        //echo $opt;

        $color[] = $opt;
        $color_result = array_unique($color);
    }
    $colors = '';
    for($k=1; $k<=count($color_result); $k++) {
        if($k==1) {
            $io_color = $color_result[$k-1];
        } else {
            $io_color = '/'.$color_result[$k-1];
        }
        $colors .= $io_color;
    }
    echo $colors;
?>
</td>
</tr>

<?php } // $i for END ?>
</table>

<?php
    include_once('./_tail.php');
?>