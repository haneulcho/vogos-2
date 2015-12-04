<?php
include_once('./_common.php');

$g5['title'] = 'Sign In';

$url = $_GET['url'];

// url 체크
check_url_host($url);

// 이미 로그인 중이라면
if ($is_member) {
    if ($url)
        goto_url($url);
    else
        goto_url(G5_URL);
}

$login_url        = login_url($url);
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";

// 로그인 스킨이 없는 경우 관리자 페이지 접속이 안되는 것을 막기 위하여 기본 스킨으로 대체
?>
<style type="text/css">
@charset "utf-8";
body {background-color:#fff;font-size:12px;font-family:'Apple SD Gothic Neo','Nanum Gothic', 'Malgun Gothic',dotum, sans-serif;line-height:1.25em;}
/* 로그인 */
#mb_login {max-width:360px;margin:20px auto;padding:0 30px;}
#mb_login h1 {margin:0 0 20px;padding:0 10px 0 0 ;font-size:1.2em;font-family:'Oswald', sans-serif;color:#666;}
#mb_login h2 {margin:0}
#mb_login p {padding:10px 0;line-height:1.5em}
#mb_login #login_frm {position:relative;padding:0;font-size:1em}
#mb_login #login_frm > label {display:block;margin-bottom:5px;}
#mb_login #login_frm div {padding:2px 0 0;text-align:right}
#mb_login .frm_input {display:block;width:100%;height:47px;margin-bottom:7px;padding:12px 10px;line-height:1.8em;}
#mb_login .frm_input, #mb_join .frm_input {border:1px solid #cccccc;-webkit-border-radius:border-radius:5px;-moz-border-radius:5px;-o-border-radius:5px;border-radius:5px;outline:0;background-color:#fff !important;-webkit-transition:all ease .2s;-moz-transition:all ease .2s;-o-transition:all ease .2s;transition:all ease .2s;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
#mb_login .frm_input:focus, #mb_join .frm_input:focus {background-color:#f6f6f6 !important;border-color:#aaa;
	-webkit-box-shadow: inset 0px 3px 1px 0px rgba(237,237,237,1);
-moz-box-shadow: inset 0px 3px 1px 0px rgba(237,237,237,1);
box-shadow: inset 0px 3px 1px 0px rgba(237,237,237,1);}
#mb_login .login_frm_btns {height:45px;padding-top:14px !important;}
#mb_login .login_frm_btns * {letter-spacing:0;line-height:1em;height:45px;-webkit-border-radius:border-radius:5px;-moz-border-radius:5px;-o-border-radius:5px;border-radius:5px;outline:0;
-webkit-transition:all ease .2s;-moz-transition:all ease .2s;-o-transition:all ease .2s;transition:all ease .2s;
-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
#mb_login .login_frm_btns a {float:left;font-size:1.2em;width:33%;margin-right:5px;background-color:#7c7c7c; border:1px solid #757575;color:#fff;text-align:center;padding:16px 0;}
#mb_login .btn_submit {float:right;font-size:1.3em;padding:0 !important;width:63%;text-align:center;color:#fff;background-color:#474747;border:1px solid #323232;font-weight:bold;cursor:pointer;}
#mb_login .login_frm_btns a:hover, #mb_login .btn_submit:hover, #mb_join .tbl_wrap .btn_frmline:hover {background-color:#d4b900;border-color:#cab001;}
#mb_login section {clear:both;margin:25px 0;padding:15px 18px;border:1px solid #e9e9e9;background:#f7f7f7}
#mb_login section div {border-top:1px solid #e9e9e9;text-align:right}
#mb_login section div .find_id {padding:8px 7px 0;background:none;color:#666;border:none;}
#mb_login section div .find_id i {margin-right:5px;}

#mb_login_notmb {margin:30px 0;padding:15px 10px;border:1px solid #cfded8;background:#f7f7f7}
#mb_login_notmb #guest_privacy {margin:0 0 10px;padding:10px;height:150px;border:1px solid #e9e9e9;background:#fff;overflow:auto}
#mb_login_notmb .btn_confirm {margin:20px 0 0;text-align:right}

#mb_login_od {position:relative;margin:20px 5px;border-bottom:0;background:#fff}
#mb_login_od legend {position:absolute;font-size:0;line-height:0;overflow:hidden}
#mb_login_od .od_id {position:absolute;top:26px;left:95px}
#mb_login_od .od_pwd {position:absolute;top:52px;left:95px}
#mb_login_od .frm_input {display:block;margin-bottom:5px;padding:0;width:80%;height:1.8em;line-height:1.8em}
#mb_login_od .btn_submit {position:absolute;top:0;right:0;padding:0 !important;width:18%;height:4em !important;text-align:center}
#mb_login_odinfo {margin:0 0 30px;padding:20px;border:1px solid #cfded8;background:#f7f7f7}
#mb_login_odinfo div {text-align:right}
</style>
<div id="mb_login" class="mbskin">

    <h1><?php $g5['title'] = 'Admin Access Only!<br>Please Sign In'; echo $g5['title'] ?></h1>

    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">

    <div id="login_frm">
        <label for="login_id" class="sound_only">ID</label>
        <input type="text" name="mb_id" id="login_id" placeholder="ID(required)" required class="frm_input required" maxLength="20">
        <label for="login_pw" class="sound_only">Password</label>
        <input type="password" name="mb_password" id="login_pw" placeholder="PW(required)" required class="frm_input required" maxLength="20">
        <div>
                <input type="checkbox" name="auto_login" id="login_auto_login">
                <label for="login_auto_login">Keep me logged in</label>
        </div>
        <div class="login_frm_btns">
            <input type="submit" value="Sign In" class="btn_submit">
        </div>
    </div>
    </form>

</div>

<script>
$(function(){
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
<?php
include_once('./_tail.php');
?>
