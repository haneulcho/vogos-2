<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="default_contents">
<div id="mb_login" class="mbskin">
    <h1><?php $g5['title'] = 'VOGOS SIGN IN'; echo $g5['title'] ?></h1>

    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">

    <div id="login_frm">
        <div class="login_frm_inputs">
            <label for="login_id" class="sound_only">ID<strong class="sound_only"> required</strong></label>
            <input type="text" name="mb_id" id="login_id" placeholder="ID(required)" required class="frm_input required" maxLength="20">
            <label for="login_pw" class="sound_only">Password<strong class="sound_only"> required</strong></label>
            <input type="password" name="mb_password" id="login_pw" placeholder="Password(required)" required class="frm_input required" maxLength="20">
            <input type="submit" value="Sign In" class="btn_submit">
        </div>
        <div class="login_frm_keep">
            <input type="checkbox" name="auto_login" id="login_auto_login">
            <label for="login_auto_login">Keep me logged in</label>
        </div>
    </div>
    <section id="login_frm_signup">
        <h2 style="margin-bottom:10px;">Haven't signed up yet? Join us!</h2>
        <p style="display:none;">15% off of your first order when you sign up<br />
        *order must be placed within 7 days from sign up.
        </p>
        <div class="login_frm_btns">
            <a href="./register.php" class="btn01">Sign Up</a>
        </div>
        <div style="display:none;">
                <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="find_id btn02"><i class="ion-help-circled"></i>아이디 / 비밀번호 찾기</a>
        </div>
    </section>

    </form>

    <?php // 쇼핑몰 사용시 여기부터 ?>
    <?php if ($default['de_level_sell'] == 1) { // 상품구입 권한 ?>

        <!-- 주문하기, 신청하기 -->
        <?php if (preg_match("/orderform.php/", $url)) { ?>

    <section id="mb_login_notmb">
        <h2>Order as a guest.</h2>

        <p>
            Become a member and receive reward points on purchases.
        </p>

        <div id="guest_privacy">
            <?php echo $default['de_guest_privacy']; ?>
        </div>

        <label for="agree">Yes, I agree to your Privacy Policy.</label>
        <input type="checkbox" id="agree" value="1">

        <div class="btn_confirm">
            <a href="javascript:guest_submit(document.flogin);" class="btn02">Order Now</a>
        </div>

        <script>
        function guest_submit(f)
        {
            if (document.getElementById('agree')) {
                if (!document.getElementById('agree').checked) {
                    alert("Please agree to our Privacy Policy before proceeding.");
                    return;
                }
            }

            f.url.value = "<?php echo $url; ?>";
            f.action = "<?php echo $url; ?>";
            f.submit();
        }
        </script>
    </section>

        <?php } else if (preg_match("/orderinquiry.php$/", $url)) { ?>

    <fieldset id="mb_login_od">
        <legend>View my order as a guest.</legend>

        <form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">

        <label for="od_id" class="od_id sound_only">Your Order No.<strong class="sound_only"> required</strong></label>
        <input type="text" name="od_id" value="<?php echo $od_id ?>" id="od_id" placeholder="Your Order No." required class="frm_input required" size="20">
        <label for="id_pwd" class="od_pwd sound_only">Password<strong class="sound_only"> required</strong></label>
        <input type="password" name="od_pwd" size="20" id="od_pwd" placeholder="Password" required class="frm_input required">
        <input type="submit" value="OK" class="btn_submit">

        </form>
    </fieldset>

    <section id="mb_login_odinfo">
        <h2>View order as a guest.</h2>
        <p>Please verify your password.</p>
    </section>

        <?php } ?>

    <?php } ?>
    <?php // 쇼핑몰 사용시 여기까지 반드시 복사해 넣으세요 ?>

</div>
</div> <!-- END default_contents -->

<script>
$(function(){
    $("#login_id").focus();
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("Do you want us to keep you logged in?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>