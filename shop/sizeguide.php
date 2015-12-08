<?php
include_once('../common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

define('G5_SHOP_CSS_URL', G5_SHOP_SKIN_URL);

$g5['title'] = 'VOGOS SIZE GUIDE | VOGOS';
$content_skin_url  = G5_SKIN_URL.'/content/basic';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<meta property="og:type" content="website">
<?php if (!isset($og_title)) { ?>
<meta property="og:title" content="VOGOS.com">
<meta property="og:url" content="http://vogos.com">
<meta property="og:description" content="Everywhere is a Runway, Everyday VOGOS">
<meta property="og:image" content="<?php echo G5_SHOP_SKIN_URL.'/img/og_img2.png' ?>">
<?php } else { ?>
<meta property="og:title" content="<?=$og_title ?>">
<meta property="og:url" content="<?=$og_url ?>">
<meta property="og:description" content="<?=$og_description?>">
<meta property="og:image" content="<?=$og_img?>"> 
<?php } ?>
<title><?php echo $g5_head_title; ?></title>
<?php
    $shop_css = '_shop';
    echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css">'.PHP_EOL;
?>
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_shop_url   = "<?php echo G5_SHOP_URL ?>";
var g5_shop_skin_url   = "<?php echo G5_SHOP_SKIN_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php
if ($is_admin) {
    echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
}
?>
</script>
<!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<?php
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.shop.menu.js"></script>
<?php
    }
} else {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link href="//fonts.googleapis.com/css?family=Lato:100normal,100italic,300normal,300italic,400normal,400italic,700normal,700italic,900normal,900italic&subset=all" rel="stylesheet" type="text/css">
<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?> style="width:auto;min-width:0 !important;">

<div id="smb_my">
    <div id="sod_title" class="sgd">
        <header class="fullWidth" style="width:auto !important;">
            <h2>SIZE GUIDE</h2>
        </header>
    </div>
    <div class="fullWidth" style="width:auto !important;">
    <section class="sgd_ov">
        <h2><i class="ion-android-happy"></i> SHOES</h2>
        <div class="sct_iqv_tbl sct_iqv_tbl2">
            <table>
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row">mm</th>
                <td>225</td>
                <td>230</td>
                <td>235</td>
                <td>240</td>
                <td>245</td>
                <td>250</td>
                <td>255</td>
            </tr>
            <tr>
                <th scope="row">EURO</th>
                <td>36</td>
                <td>36.5</td>
                <td>37</td>
                <td>37.5</td>
                <td>38</td>
                <td>38.5</td>
                <td>39</td>
            </tr>
            <tr>
                <th scope="row">UK</th>
                <td>3</td>
                <td>3.5</td>
                <td>4</td>
                <td>4.5</td>
                <td>5</td>
                <td>5.5</td>
                <td>6</td>
            </tr>
            <tr>
                <th scope="row">US</th>
                <td>5</td>
                <td>5.5</td>
                <td>6</td>
                <td>6.5</td>
                <td>7</td>
                <td>7.5</td>
                <td>8</td>
            </tr>
            </tbody>
            </table>
        </div>
    </section>

    <section class="sgd_ov">
        <h2><i class="ion-tshirt"></i> SIZE CHART</h2>
        <div class="sct_iqv_tbl sct_iqv_tbl2">
            <table>
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row">VOGOS SIZE</th>
                <td>XS</td>
                <td>S</td>
                <td>M</td>
                <td>L</td>
            </tr>
            <tr>
                <th scope="row">US</th>
                <td>0-2</td>
                <td>4</td>
                <td>6</td>
                <td>8</td>
            </tr>
            <tr>
                <th scope="row">UK</th>
                <td>6</td>
                <td>8</td>
                <td>10</td>
                <td>12</td>
            </tr>
            <tr>
                <th scope="row">EU</th>
                <td>32</td>
                <td>34</td>
                <td>36</td>
                <td>38</td>
            </tr>
            <tr>
                <th scope="row">IT</th>
                <td>36</td>
                <td>38</td>
                <td>40</td>
                <td>42</td>
            </tr>
            </tbody>
            </table>
        </div>
    </section>
    </div>
</div>
</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>