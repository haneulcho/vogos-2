<?php
$sub_menu = '400600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '사입처에서 받아온 샘플 수 동기화';

$sql  = " select * from {$g5['g5_shop_ddmaddress_table']} ";
$result = sql_query($sql);
?>

<?php
$succ_count = 0;

for ($i=0; $row=mysql_fetch_array($result); $i++) {
    $ddm_place2 = $row['ddm_place2'];
    $it_extract_name = $ddm_place2."(".$row['ddm_name'].")";

    // 이 사입처에서 받아온 샘플 수만 구해서 g5_shop_ddmaddress 테이블 속 ddm_sample_num에 삽입
    $sql2 = " select count(*) as cnt1 from {$g5['g5_shop_item_table']} where it_place_ddm = '$it_extract_name'";
    $row2 = sql_fetch($sql2);
    $sample_count = $row2['cnt1'];

    if($sample_count > 0) {
        $sql3 = " UPDATE {$g5['g5_shop_ddmaddress_table']}
                    SET ddm_sample_num  = '$sample_count'
                    WHERE ddm_place2 = '$ddm_place2' ";
        sql_query($sql3);
        $succ_count++;

        echo $row['ddm_place1'].' / '.$row['ddm_place2'].' / '.$row['ddm_name'].$sample_count.'개 업데이트 완료!<br>';
    }
}
echo '총 '.$succ_count.'개 사입처 동기화 완료!';
?>