<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<?php /* 주문폼 자바스크립트 에러 방지를 위해 추가함 */ ?>
<input type="hidden" name="good_mny"    value="<?php echo $tot_price; ?>">
<?php if($default['de_tax_flag_use']) { ?>
    <input type="hidden" name="comm_tax_mny"	  value="<?php echo $comm_tax_mny; ?>">         <!-- 과세금액    -->
    <input type="hidden" name="comm_vat_mny"      value="<?php echo $comm_vat_mny; ?>">         <!-- 부가세	    -->
    <input type="hidden" name="comm_free_mny"     value="<?php echo $comm_free_mny; ?>">        <!-- 비과세 금액 -->
<?php } ?>

<!-- 결제에 필요 한 필수 파라미터 -->
<input type="hidden" name="ver" value="210" /><!-- 연동 버전 -->
<input type="hidden" name="txntype" value="PAYMENT" /><!-- 거래 타입 -->
<input type="hidden" name="charset" value="UTF-8" /><!-- 기본 값 : UTF-8 -->

<!-- statusurl(필수 값) : 결제 완료 시 Back-end 방식으로 Eximbay 서버에서 statusurl에 지정된 가맹점 페이지를 Back-end로 호출하여 파라미터를 전송. -->
<!-- 스크립트, 쿠키, 세션 사용 불가 -->
<input type="hidden" name="statusurl" value="<?php echo G5_SHOP_URL.'/eximbay/status.php'; ?>" />
<!-- 추가 필수 파라미터 : Buyer, email, amt -->
<!-- 위 파라미터와 request.php의 mid, secretkey, ref 값 설정만으로 Eximbay 연동 결제 가능  -->

<!-- 배송지 관련 파라미터(선택) -->
<input type="hidden" name="shipTo_country" value="" />
<input type="hidden" name="shipTo_city" value="" />
<input type="hidden" name="shipTo_street1" value="" />
<input type="hidden" name="shipTo_postalCode" value="" />
<input type="hidden" name="shipTo_phoneNumber" value="" />
<input type="hidden" name="shipTo_firstName" value="" />
<input type="hidden" name="shipTo_lastName" value="" />

<!-- 청구지 관련 파라미터 (선택) -->
<input type="hidden" name="billTo_city" value="" />
<input type="hidden" name="billTo_country" value="" />
<input type="hidden" name="billTo_firstName" value="" />
<input type="hidden" name="billTo_lastName" value="" />
<input type="hidden" name="billTo_phoneNumber" value="" />
<input type="hidden" name="billTo_postalCode" value="" />
<input type="hidden" name="billTo_street1" value="" />

<!-- 한국 결제 수단 관련 변수 (선택) -->
<input type="hidden" name="issuercountry" value="" /><!-- KR 값 지정 시 한국 결제 수단 선택. 그 외 해외 결제 수단 -->
<input type="hidden" name="supplyvalue" value="" /><!-- 전체 결제금액의 결제금액의 공급가액 issuercountry가 KR인 경우 필수 값 -->
<input type="hidden" name="taxamount" value="" /><!-- 전체 결제금액의 결제금액의 세액 issuercountry가 KR인 경우 필수 값 -->

<input type="hidden" name="returnurl" value="<?php echo G5_SHOP_URL.'/eximbay/return.php'; ?>" /><!--결제 완료 시 Front-end 방식으로 사용자 브라우저 상에 호출되어 보여질 가맹점 페이지 -->
<input type="hidden" name="displaytype" value="P" /><!-- P : popup(기본값), I : iframe(layer), R : page redirect -->
<input type="hidden" name="shop" value="VOGOS" /><!-- 상점명 : 가맹점명과 다른 경우 사용 -->
<input type="hidden" name="ostype" value="P" /><!-- P: PC 버전(기본값), M : Mobile 버전-->
<input type="hidden" name="tel" value="" />
<input type="hidden" name="mobiletype" value="" />
<input type="hidden" name="appscheme" value="" />
<input type="hidden" name="autoclose" value="" />
<input type="hidden" name="siteforeigncur" value="" />
<input type="hidden" name="paymethod" value="" /><!-- 결제 수단코드 -->

<!-- 결제 응답 값 처리 파라미터 -->
<input type="hidden" name="rescode" />
<input type="hidden" name="resmsg" />
<input type="hidden" name="authcode" />
<input type="hidden" name="cardco" />

<!-- 결제에 필요한 필수 파라미터 -->
<input type="hidden" name="buyer" value="" /> 
<input type="hidden" name="email" value="" />
<input type="hidden" name="ref" value=""/>
<input type="hidden" name="mid" value=""/>
<input type="hidden" name="cur" value=""/>
<input type="hidden" name="amt" value="" />
<input type="hidden" name="lang" value="EN" />