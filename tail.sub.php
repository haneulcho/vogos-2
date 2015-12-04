<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 사용자가 지정한 tail.sub.php 파일이 있다면 include
if(defined('G5_TAIL_SUB_FILE') && is_file(G5_PATH.'/'.G5_TAIL_SUB_FILE)) {
    include_once(G5_PATH.'/'.G5_TAIL_SUB_FILE);
    return;
}
?>

<!--  LOG corp Web Analitics & Live Chat  START -->
<script  type="text/javascript">
//<![CDATA[
 /*custom parameters*/
var _HCmz={
 PC:"<?=$http_PC?>", //상품명 또는 상품코드
 PT:"<?=$http_PT?>", //카테고리명(카테고리가 여러단계일 경우 ';'으로 구분 [예] AA;BB;CC) 
 SO:"<?=$http_SO?>", //시나리오(cart:카트,cartend:주소기입,payend:결제완료,REGC:회원가입 또는 약관동의,REGF:입력폼,REGO:회원완료)
 MP:"<?=$http_MP?>", //구매전환상품 (제품코드_가격_제품수량) 여러개 경우 ';'로 구분
 PS:"<?=$http_PS?>", //상품가격(예:29000)
 PA:"<?=$http_PA?>",  //장바구니(상품명_수량)  여러개 경우 ';'로 구분 (상품명1_수량;상품명2_수량)
 OD:"<?=$http_OD?>"
};
 
function logCorpAScript_full(){
	HTTP_MSN_MEMBER_NAME="";/*member name*/
	LOGSID = "<?=$_SESSION['logsid']?>";/*logsid*/
	LOGREF = "<?=$_SESSION['logref']?>";/*logref*/
	var prtc=(document.location.protocol=="https:")?"https://":"http://";
	var hst=prtc+"asp3.http.or.kr"; 
	var rnd="r"+(new Date().getTime()*Math.random()*9);
	this.ch=function(){
		if(document.getElementsByTagName("head")[0]){logCorpAnalysis_full.dls();}else{window.setTimeout(logCorpAnalysis_full.ch,30)}
	}
	this.dls=function(){
		var  h=document.getElementsByTagName("head")[0];
		var  s=document.createElement("script");s.type="text/jav"+"ascript";try{s.defer=true;}catch(e){};try{s.async=true;}catch(e){};
		if(h){s.src=hst+"/HTTP_MSN/UsrConfig/vogoskorea/js/ASP_Conf.js?s="+rnd;h.appendChild(s);}
	}
	this.init= function(){
		document.write('<img src="'+hst+'/sr.gif?d='+rnd+'"  style="width:1px;height:1px;position:absolute;" alt="" onload="logCorpAnalysis_full.ch()" />');
	}
}
if(typeof logCorpAnalysis_full=="undefined"){	var logCorpAnalysis_full=new logCorpAScript_full();logCorpAnalysis_full.init();}
//]]>
</script>
<noscript><img src="http://asp3.http.or.kr/HTTP_MSN/Messenger/Noscript.php?key=vogoskorea" border="0" style="display:none;width:0;height:0;" /></noscript>
<!-- LOG corp Web Analitics & Live Chat END  -->

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>