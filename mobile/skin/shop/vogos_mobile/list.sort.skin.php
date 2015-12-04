<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['PHP_SELF'].'?';
if($ca_id)
    $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
    $sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// 상품 정렬 선택시 active 클래스 추가
$it_order_type = $_GET['sort'];
$it_order_sc = $_GET['sortodr'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품 정렬 선택 시작 { -->
<section id="sct_sort">
    <h2>order</h2>

    <ul>
        <li><a<?php if($it_order_type == 'it_price' && $it_order_sc == 'asc') echo ' class="active"'; ?> href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=asc">price <i class="ion-ios-arrow-down"></i></a></li>
        <li><a<?php if($it_order_type == 'it_price' && $it_order_sc == 'desc') echo ' class="active"'; ?> href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=desc">price <i class="ion-ios-arrow-up"></i></a></li>
        <li><a<?php if($it_order_type == 'it_time') echo ' class="active"'; ?> href="<?php echo $sct_sort_href; ?>it_time&amp;sortodr=desc">latest</a></li>
        <li><a<?php if($it_order_type == 'it_order') echo ' class="active"'; ?> href="<?php echo $sct_sort_href; ?>it_order&amp;sortodr=desc">popular</a></li>
    </ul>
</section>
<!-- } 상품 정렬 선택 끝 -->