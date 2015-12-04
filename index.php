<?php
define('_INDEX_', true);
include_once('./_common.php');

// 초기화면 파일 경로 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($config['cf_include_index'] && is_file(G5_PATH.'/'.$config['cf_include_index'])) {
    include_once(G5_PATH.'/'.$config['cf_include_index']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

// 루트 index를 쇼핑몰 index 설정했을 때
if(isset($default['de_root_index_use']) && $default['de_root_index_use']) {
    require_once(G5_SHOP_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once('./_head.php');
?>


<?php
include_once('./_tail.php');
?>