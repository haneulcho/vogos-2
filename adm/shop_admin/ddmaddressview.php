<?php
$sub_menu = '400600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$it_place_ddm = $_GET['it_place_ddm'];

$sql2 = "select * from {$g5['g5_shop_ddmaddress_table']} where ddm_place2 = '$it_place_ddm'";
$row = sql_fetch($sql2);

$it_extract_name = $it_place_ddm."(".$row['ddm_name'].")";

$sql = "select it_id, it_name, it_price, it_2, it_place_ddm, it_name_ddm, it_price_ddm, it_use from {$g5['g5_shop_item_table']} where it_place_ddm = '$it_extract_name'";
$result = sql_query($sql);

$g5['title'] = '['.$row['ddm_name'].']에서 받아온 샘플 자세히보기';

// 이 사입처에 받아온 샘플 수 구하기
$sql3 = " select count(*) as cnt1 from {$g5['g5_shop_item_table']} where it_place_ddm = '$it_extract_name'";
$row3 = sql_fetch($sql3);
if($row3['cnt1'] > 0) {
    $total_count = $row3['cnt1'];
} else {
    die('사입처에서 받아온 샘플이 없습니다!');
}

include_once(G5_PATH.'/head.sub.php');
?>

<section id="cart_list">
    <h2 class="h2_frm">사입처 정보</h2>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>주문 상품 목록</caption>
        <thead>
        <tr>
            <th scope="col">주 판매품목 분류</th>
            <th scope="col">사입처 위치</th>
            <th scope="col">사입처 상세위치</th>
            <th scope="col">사입처명</th>
            <th scope="col">사입처 전화번호</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="td_num"><?php echo $row['ddm_part'] ?></td>
                <td class="td_num"><?php echo $row['ddm_place1'] ?></td>
                <td class="td_num"><?php echo $row['ddm_place2'] ?></td>
                <td class="td_num"><?php echo $row['ddm_name'] ?></td>
                <td class="td_num"><?php echo $row['ddm_tel'] ?></td>
            </tr>
        </tbody>
        </table>
    </div>
</section>

<section id="cart_list">
    <h2 class="h2_frm">[<?php echo $row['ddm_name']; ?>]에서 받아온 샘플 총 <span style="color:#ff0000"><?php echo $total_count; ?>개</span></h2>
    <div class="tbl_head02 tbl_wrap" style="padding-bottom:15px">
        <table>
        <caption><?php echo $row['ddm_name']; ?> 샘플 목록</caption>
        <thead>
        <tr>
            <th scope="col" rowspan="3" style="width:75px">상품코드</th>
            <th scope="col" rowspan="3">이미지</th>
            <th scope="col" colspan="2">사입 정보</th>
            <th scope="col" colspan="2">사이트 정보</th>
            <th scope="col" rowspan="3" style="wdth:85px">사이트 판매여부</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i=0; $row=mysql_fetch_array($result); $i++) {
            $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
            if($row['it_use'] == 0){
                $it_use = '판매안함';
            } else {
                $it_use = '판매중';
            }
        ?>
        <tr>
            <td class="td_num" rowspan="2" style="width:55px"><?php echo $row['it_id']; ?></td>
            <td class="td_num" rowspan="2"><a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image2($row['it_id'], 8, 60, 80, '', '', stripslashes($row['it_name'])); ?></a></td>
            <th class="td_num" style="width:40px">상품명</td>
            <td class="td_num" style="width:90px"><?php echo $row['it_name_ddm']; ?></td>
            <th class="td_num" style="width:40px">상품명</td>
            <td class="td_num" style="width:190px"><a href="<?php echo $href; ?>" target="_blank" style="text-decoration:underline"><?php echo $row['it_name']; ?></a></td>
            <td class="td_num" rowspan="2"><?php echo $it_use; ?></td>
        </tr>
        <tr>
            <th class="td_num" style="width:40px">단가</td>
            <td class="td_num"><?php echo number_format($row['it_price_ddm']); ?>원</td>
            <th class="td_num" style="width:40px">단가</td>
            <td class="td_num">$<?php echo number_format($row['it_price']); ?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>