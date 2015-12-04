<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="mbskin">

    <p align="center">
    <a href="<?php echo G5_URL; ?>"><img style="width:100%" src="<?php echo G5_SHOP_URL; ?>/img/member_con.jpg"></a>
    </p>


</div>
<!-- } 회원가입결과 끝 -->