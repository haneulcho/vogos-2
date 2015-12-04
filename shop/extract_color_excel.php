<?php
include_once('./_common.php');

// 1.04.01
// MS엑셀 XLS 데이터로 다운로드 받음
$sql1 = " select * from {$g5['g5_shop_item_table']} ";
$result1 = sql_query($sql1);

$cnt = @mysql_num_rows($result1);
if (!$cnt)
    alert("출력할 내역이 없습니다.");

    //header('Content-Type: text/x-csv');
    header("Content-charset=utf-8");
    header('Content-Type: doesn/matter');
    header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Content-Disposition: attachment; filename="colorlist-' . date("ymd", time()) . '.csv"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo iconv('utf-8', 'euc-kr', "상품코드,카테고리,판매여부,상품명,컬러\n");

for ($i=0; $it=mysql_fetch_array($result1); $i++) {
    $it = array_map('iconv_euckr', $it);    
    if($it['it_use'] == 1) {
        $it_use = '판매중';
    } else {
        $it_use = '판매안함';
    }

    if($it['ca_id2'] == '11') {
        $it_ca = 'KINTWEAR';
    } else {
        switch ($it['ca_id']) {
            case '10':
                $it_ca = 'OUTWEAR';
                break;
            case '20':
                $it_ca = 'TOPS';
                break;
            case '30':
                $it_ca = 'DRESSES';
                break;
            case '40':
                $it_ca = 'BOTTOMS';
                break;
            case '50':
                $it_ca = 'ACCESSORIES';
                break;
            case '60':
                $it_ca = 'SHOES';
                break;
            
            default:
                break;
        }
    }
    $it_id = iconv('utf-8', 'euc-kr', $it['it_id']);
    $it_ca = iconv('utf-8', 'euc-kr', $it_ca);
    $it_use = iconv('utf-8', 'euc-kr', $it_use);
    $it_name = iconv('utf-8', 'euc-kr', $it['it_name']);

    echo '"'.$it_id.'"'.',';
    echo '"'.$it_ca.'"'.',';
    echo '"'.$it_use.'"'.',';
    echo '"'.$it_name.'"'.',';

    $sql2 = " select * from {$g5['g5_shop_item_option_table']}
                    where io_type = '0'
                      and it_id = '{$it['it_id']}'
                      and io_use = '1'
                    order by it_id asc ";
    $result2 = sql_query($sql2);

    $color = array();
    for ($j=0; $row=mysql_fetch_array($result2); $j++) {
        $opt_id = $row['io_id'];
        $opt_val = explode(chr(30), $opt_id);
        $opt = $opt_val[1];

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
    echo '"'.$colors.'"'.',';
    echo "\n";
}


exit;
?>