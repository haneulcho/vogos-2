<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 하단 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_tail'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_tail'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_tail']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
        <!-- <a href="#hd" id="top_btn">상단으로</a> -->
    </div><!-- } container 콘텐츠 끝 -->
</div><!-- } Wrapper 끝 -->

<!-- 하단 시작 { -->
<div id="ft">
    <div class="fullWidth">
    <div id="ft_wr">
        <div id="ft_about">
            <h2>ABOUT VOGOS</h2>
            <ul>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">Who Are We?</a></li>
            </ul>       
        </div>
        <div id="ft_help">
            <h2>HOW CAN WE HELP</h2>
            <ul>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">Privacy Policy</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">Terms and Conditions</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=shippinginfo">Shipping Info</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=returnpolicy">Returns and Policies</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=sizeguide">Size Guide</a></li>
            </ul>
        </div>
        <div id="ft_like">
            <h2>LIKE &amp; FOLLOW US</h2>
            <ul class="ft_sns">
                <li><a href="https://instagram.com/vogosfashion" target="_blank"><span class="ft_sns_in">Instagram</span></a></li>
                <li><a href="https://facebook.com/VogosFashion" target="_blank"><span class="ft_sns_fb">Facebook</span></a></li>
                <li><a href="#" target="_blank" onClick="alert('Coming Soon!');return false;"><span class="ft_sns_yt">Youtube</span></a></li>
                <li><a href="https://pinterest.com/VogosFashion" target="_blank"><span class="ft_sns_pt">Pinterest</span></a></li>
                <!-- <li><a href="http://"><span>Tumblr</span></a></li> -->                
            </ul>
        <!-- KG이니시스 인증마크 적용 시작 -->
        <img src="http://image.inicis.com/mkt/certmark/inipay/inipay_43x43_gray.png" border="0" alt="클릭하시면 이니시스 결제시스템의 유효성을 확인하실 수 있습니다." style="float:left;cursor:pointer;margin:25px 10px 0 0" onclick="javascript:window.open(&quot;https://mark.inicis.com/mark/popup_v1.php?mid=SIRvogos00&quot;,&quot;mark&quot;,&quot;scrollbars=no,resizable=no,width=565,height=683&quot;);">

        <!-- KB에스크로 이체 인증마크 적용 시작 -->
        <script>
        function onPopKBAuthMark()
        {
        var url = 'https://okbfex.kbstar.com/quics?page=C016760&mHValue=051eaeb9a19ab2af2e0992e7435fd055201507091430377';
        window.open(url,'KB_AUTHMARK','height=604, width=648, status=yes, toolbar=no, menubar=no, location=no');
        document.KB_AUTHMARK_FORM.action='https://okbfex.kbstar.com/quics';
        document.KB_AUTHMARK_FORM.target='KB_AUTHMARK';
        document.KB_AUTHMARK_FORM.submit();
        }
        </script>
        <form name="KB_AUTHMARK_FORM" method="get">
        <input type="hidden" name="page" value="C021590"/>
        <input type="hidden" name="cc" value="b034066:b035526"/>
        <input type="hidden" name="mHValue" value='051eaeb9a19ab2af2e0992e7435fd055201507091430377'/>
        </form>
        <a href="#" style="float:left;display:block;cursor:pointer;margin:13px 0 0 5px" onclick="javascript:onPopKBAuthMark();return false;">
        <img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/escrowcmark.jpg" border="0"/>
        </a>
        <!-- KB에스크로이체 인증마크 적용 종료 -->

        </div>
    </div>
    <div class="ft_bottom">
        <div id="ft_copy">
            Copyright &copy; 2015 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
        </div>
        <p>Tel: +1 323-319-3888 / help@vogos.com<br>
        Tel: +44 (0)20-3239-8282 / 8 Berwick Street, London W1F 0PH, United Kingdom<br>
        Tel: +82 (0)70-7771-5527 / B2 Floor, 31, Teheran-ro 33-gil Gangnam-gu, Seoul, Korea<br>
        Business License: 123-88-00091 / Online Sales License: 2015-서울강남-02347호<br></p>
        <div id="ft_pay">
            <img src="<?php echo G5_SHOP_SKIN_URL ?>/img/payment.png">
        </div>
    </div>
    </div>
</div>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<script>
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<!-- } 하단 끝 -->

<?php
include_once(G5_PATH.'/tail.sub.php');
?>