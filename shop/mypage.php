<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/mypage.php');
    return;
}

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

if (empty($member['mb_name'])) {
    $g5['title'] = $member['mb_id'].'\'s VOGOS';
} else {
    $g5['title'] = $member['mb_name'].'\'s VOGOS';    
}

include_once('./_head.php');

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}
?>

<!-- 마이페이지 시작 { -->
<div id="smb_my">

    <div id="sod_title" class="mif">
        <header class="fullWidth">
        <?php if(empty($member['mb_name'])) { ?>
            <h2><?php echo $member['mb_id']; ?>'s VOGOS <span class="cart_item_num"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a></span></h2>
        <?php } else { ?>
            <h2><?php echo $member['mb_name']; ?>'s VOGOS <span class="cart_item_num"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a></span></h2>
        <?php } ?>
        </header>
    </div>

    <div class="fullWidth">

    <!-- 회원정보 개요 시작 { -->
    <section id="smb_my_ov">
        <h2><i class="ion-android-happy"></i> MY INFORMATION
            <div class="smb_my_more">
                <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();"><i class="ion-android-exit"></i> 탈퇴하기</a>
            </div>
        </h2>
        <div class="sct_iqv_tbl sct_iqv_tbl2">
            <table>
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row">ID</th>
                <?php if(empty($member['mb_id'])) { ?>
                <td class="btn_edit_info"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a>을 눌러 부가 정보를 입력하세요.</td>
                <? } else { ?>
                <td><?php echo $member['mb_id']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">First Name</th>
                <?php if(empty($member['mb_name'])) { ?>
                <td class="btn_edit_info"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a>을 눌러 부가 정보를 입력하세요.</td>
                <? } else { ?>
                <td><?php echo $member['mb_name']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">E-mail</th>
                <?php if(empty($member['mb_email'])) { ?>
                <td class="btn_edit_info"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a>을 눌러 부가 정보를 입력하세요.</td>
                <? } else { ?>
                <td><?php echo $member['mb_email']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">Telephone</th>
                <?php if(empty($member['mb_tel'])) { ?>
                <td class="btn_edit_info"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a>을 눌러 부가 정보를 입력하세요.</td>
                <? } else { ?>
                <td><?php echo $member['mb_tel']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">Mobile</th>
                <?php if(empty($member['mb_hp'])) { ?>
                <td class="btn_edit_info"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a>을 눌러 부가 정보를 입력하세요.</td>
                <? } else { ?>
                <td><?php echo $member['mb_hp']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">주소</th>
                <?php if(empty($member['mb_addr1'])) { ?>
                <td class="btn_edit_info"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><i class="ion-compose"></i> 내 정보 수정</a>을 눌러 부가 정보를 입력하세요.</td>
                <? } else { ?>
                <td><?php echo sprintf("(%s-%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></td>
                <?php } ?>
            </tr>
            </tbody>
            </table>
        </div>
    </section>
    <!-- } 회원정보 개요 끝 -->

    <!-- 최근 주문내역 시작 { -->
    <section id="smb_my_od">
        <h2><i class="ion-android-list"></i> 내 주문 내역
            <div class="smb_my_more">
                <a href="./orderinquiry.php"><i class="ion-android-arrow-dropright-circle"></i>주문 내역 더 보기</a>
            </div>
        </h2>
        <?php
        // 최근 주문내역
        define("_ORDERINQUIRY_", true);

        $limit = " limit 0, 3 ";
        include G5_SHOP_PATH.'/orderinquiry.sub.php';
        ?>
    </section>
    <!-- } 최근 주문내역 끝 -->
    </div>

</div>

<script>
$(function() {
    $(".win_coupon").click(function() {
        var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=700, height=600, scrollbars=1");
        new_win.focus();
        return false;
    });
});

function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>
<!-- } 마이페이지 끝 -->

<?php
include_once("./_tail.php");
?>