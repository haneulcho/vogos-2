<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/listtype.php');
    return;
}

$type = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['type']);
if ($type == 1) {
    // Editor's Pick
    $g5['title'] = 'EDITOR\'S PICK';
    $nbm_class = 'editors_pick';
}
else if ($type == 2) {
    // 추천상품 > 인덱스 Runway
    $g5['title'] = 'VOGOS RUNWAY';
    $nbm_class = 'vogos_runway';
}
else if ($type == 3) {
    // 최신상품 > NEW ARRIVALS
    $g5['title'] = 'NEW ARRIVALS';
    $nbm_class = 'new_arrivals';
}
else if ($type == 4) { 
    // 인기상품 > 리스트 좌측 스팟
    $g5['title'] = 'VOGOS BESTSELLERS';
    $nbm_class = 'vogos_bestsellers';
}
else if ($type == 5) $g5['title'] = 'UP TO 7% OFF';
else
    alert('An error Occured. Please try again later.');

include_once('./_head.php');

// 한페이지에 출력하는 이미지수 = $list_mod * $list_row
$list_mod   = 4;    // 한줄에 이미지 몇개씩 출력?
$list_row   = 5;    // 한 페이지에 몇라인씩 출력?

$img_width  = 270;  // 출력이미지 폭
$img_height = 360;  // 출력이미지 높이
?>

<?php
// 상품 출력순서가 있다면
$order_by = ' it_order, it_time desc ';
if ($sort != '')
    $order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
else
    $order_by = 'it_order, it_id desc';

if (!$skin)
    $skin = 'list.20.skin.php';

define('G5_SHOP_CSS_URL', G5_SHOP_SKIN_URL);

// 리스트 유형별로 출력
$list_file = G5_SHOP_SKIN_PATH.'/'.$skin;

// header title 출력
echo '<div id="sod_title" class="mif"><header class="fullWidth">';
if($type !=5) {
$nbm = '<h2 class="'.$nbm_class.'">'.$g5['title'].'</h2>';
echo $nbm;
echo '</header></div>';
}
?>
<!-- 상품 목록 시작 { -->
<div id="sct" class="sct_wrap" style="padding-top:25px">
    <div class="fullWidth">
<?php
if (file_exists($list_file)) {
    // 총몇개 = 한줄에 몇개 * 몇줄
    $items = $list_mod * $list_row;
    // 페이지가 없으면 첫 페이지 (1 페이지)
    if ($page < 1) $page = 1;
    // 시작 레코드 구함
    $from_record = ($page - 1) * $items;

    $list = new item_list();
    $list->set_type($type);
    $list->set_list_skin($list_file);
    $list->set_list_mod($list_mod);
    $list->set_list_row($list_row);
    $list->set_img_size($img_width, $img_height);
    $list->set_is_page(true);
    $list->set_order_by($order_by);
    $list->set_from_record($from_record);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name_kr', true);
    $list->set_view('it_cust_price_kr', true); // 할인 가격 보이게
    $list->set_view('it_price_kr', true);
    $list->set_view('it_icon', false); // 추천, 신상, 베스트 아이콘 안 보이게
    $list->set_view('sns', false); // sns 아이콘 안 보이게
    echo $list->run();

    // where 된 전체 상품수
    $total_count = $list->total_count;
    // 전체 페이지 계산
    $total_page  = ceil($total_count / $items);
}
else
{
    echo '<div align="center">'.$skin.' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</div>';
}
?>
</div></div>
<!-- } 상품 목록 끝 -->
<?php
$qstr .= '&amp;type='.$type.'&amp;sort='.$sort;
echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");
?>

<?php
include_once('./_tail.php');
?>