<?php
include_once('./_common.php');

include_once(G5_MSHOP_PATH.'/_head.php');

define('G5_SHOP_CSS_URL', G5_MSHOP_SKIN_URL);


$mds_id = trim($_GET['mds_id']);

// 모델스초이스 게시글의 정보를 얻음
$sql = " select * from {$g5['g5_shop_models_table']} where mds_id = '$mds_id' ";
$mds = sql_fetch($sql);
if (!$mds['mds_id'])
    alert('모델스초이스 게시글이 없습니다.');
if (!($mds['mds_use'])) {
    if (!$is_admin)
        alert('현재 진행중인 모델스초이스가 아닙니다.');
}

// 조회수 증가
if (get_cookie('ck_mds_id') != $mds_id) {
    sql_query(" update {$g5['g5_shop_models_table']} set mds_hit = mds_hit + 1 where mds_id = '$mds_id' "); // 1증가
    set_cookie("ck_mds_id", $mds_id, time() + 3600); // 1시간동안 저장
}

// 스킨경로
$skin_dir = G5_MSHOP_SKIN_PATH;

if(is_dir($skin_dir)) {
    $form_skin_file = G5_MSHOP_SKIN_PATH.'/models.info.skin.php';
}

$g5['title'] = $mds['mds_subject'].' &gt; 모델스초이스';


?>

<!-- 모델스초이스 상세보기 시작 { -->
<?php
// 이전 상품보기
$sql = " select mds_id, mds_subject from {$g5['g5_shop_models_table']} where mds_id > '$mds_id' and mds_use = '1' order by mds_id asc limit 1 ";
$row = sql_fetch($sql);
if ($row['mds_id']) {
    $prev_title = '<img src="'.G5_SHOP_SKIN_URL.'/img/lArrow.png" alt="이전 모델스초이스"><span class="sound_only"> '.$row['mds_subject'].'</span>';
    $prev_href = '<a href="./models.php?mds_id='.$row['mds_id'].'" id="siblings_prev">';
    $prev_href2 = '</a>'.PHP_EOL;
} else {
    $prev_title = '';
    $prev_href = '';
    $prev_href2 = '';
}

// 다음 상품보기
$sql = " select mds_id, mds_subject from {$g5['g5_shop_models_table']} where mds_id < '$mds_id' and mds_use = '1' order by mds_id desc limit 1 ";
$row = sql_fetch($sql);
if ($row['mds_id']) {
    $next_title = '<img src="'.G5_SHOP_SKIN_URL.'/img/rArrow.png" alt="다음 모델스초이스"><span class="sound_only"> '.$row['mds_subject'].'</span>';
    $next_href = '<a href="./models.php?mds_id='.$row['mds_id'].'" id="siblings_next">';
    $next_href2 = '</a>'.PHP_EOL;
} else {
    $next_title = '';
    $next_href = '';
    $next_href2 = '';
}

// 관련상품의 개수를 얻음
$sql = " select count(*) as cnt from {$g5['g5_shop_models_item_table']} a left join {$g5['g5_shop_models_table']} b on (a.mds_id2=b.mds_id and b.mds_use='1') where a.mds_id = '{$mds['mds_id']}' ";
$row = sql_fetch($sql);
$models_relation_count = $row['cnt'];

// 소셜 관련
$sns_title = get_text($mds['mds_subject']).' | '.get_text($config['cf_title']);
$sns_url  = G5_MSHOP_URL.'/models.php?mds_id='.$mds['mds_id'];
$sns_share_links .= get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_fb_s.png', $thumb_url).' ';
$sns_share_links .= get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_twt_s.png', $thumb_url).' ';
$sns_share_links .= get_sns_share_link('googleplus', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_goo_s.png', $thumb_url);

?>

<div id="sit">
    <div id="sct_location">
        <a href="<?php echo G5_MSHOP_URL; ?>/" class="sct_bg">Home</a>
        <a href="<?php echo G5_MSHOP_URL.'/modelslist.php' ?>" class="sct_here">Model's Choice</a>
    </div>

    <?php
    // 상품 상세정보
    $info_skin = $skin_dir.'/models.item.info.skin.php';
    if(!is_file($info_skin))
        $info_skin = G5_MSHOP_SKIN_PATH.'/models.info.skin.php';
    include $info_skin;
    ?>

</div>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>