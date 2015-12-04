<?php
include_once('./_common.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

// 주문상품 재고체크 js 파일
add_javascript('<script src="'.G5_JS_URL.'/shop.order.js"></script>', 0);

set_session("ss_direct", $sw_direct);
// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_cart_id = get_session('ss_cart_direct');
}
else {
    $tmp_cart_id = get_session('ss_cart_id');
}

if (get_cart_count($tmp_cart_id) == 0)
    alert('Your shopping cart is empty.', G5_SHOP_URL.'/cart.php');

$g5['title'] = 'Proceed to Checkout_admin';

include_once('./_head.php');
if ($default['de_hope_date_use']) {
    include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
}

// 새로운 주문번호 생성
$od_id = get_uniqid();
set_session('ss_order_id', $od_id);
$s_cart_id = $tmp_cart_id;
$order_action_url = G5_HTTPS_SHOP_URL.'/orderformupdate_test.php';
?>
<script>
var f = document.forderform;
</script>
<form name="forderform" id="forderform" method="post" action="<?php echo $order_action_url; ?>" autocomplete="off">
<div id="sod_frm">

    <div id="sod_title">
        <header class="fullWidth">
            <h2 class="title_order"><?php echo $g5['title']; ?></h2>
        </header>
    </div>

    <div class="fullWidth">
    <!-- 주문상품 확인 시작 { -->
    <div class="sct_cart_tbl review_order">
        <div class="ro_title"><span>1</span>Review<br>Your Order</div>
        <table id="sod_list">
        <thead>
        <tr>
            <th class="th_cart_des" scope="col" colspan="2" class="itemdes">ITEM DESCRIPTION</th>
            <th class="th_cart_qty" scope="col">TOTAL QTY</th>
            <th class="th_cart_num" scope="col">UNIT PRICE</th>
            <th class="th_cart_num" scope="col">TOTAL PRICE</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = $goods_it_id = "";
        $goods_count = -1;

        // $s_cart_id 로 현재 장바구니 자료 쿼리
        $sql = " select a.ct_id,
                        a.it_id,
                        a.it_name,
                        a.ct_price,
                        a.ct_point,
                        a.ct_qty,
                        a.ct_status,
                        a.ct_send_cost,
                        a.it_sc_type,
                        b.ca_id,
                        b.ca_id2,
                        b.ca_id3,
                        b.it_notax
                   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                  where a.od_id = '$s_cart_id'
                    and a.ct_select = '1' ";
        $sql .= " group by a.it_id ";
        $sql .= " order by a.ct_id ";
        $result = sql_query($sql);

        $good_info = '';
        $it_send_cost = 0;
        $it_cp_count = 0;

        $comm_tax_mny = 0; // 과세금액
        $comm_vat_mny = 0; // 부가세
        $comm_free_mny = 0; // 면세금액
        $tot_tax_mny = 0;

        for ($i=0; $row=mysql_fetch_array($result); $i++)
        {
            // 합계금액 계산
            $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                            SUM(ct_point * ct_qty) as point,
                            SUM(ct_qty) as qty
                        from {$g5['g5_shop_cart_table']}
                        where it_id = '{$row['it_id']}'
                          and od_id = '$s_cart_id' ";
            $sum = sql_fetch($sql);

            if (!$goods)
            {
                $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row['it_name']);
                $goods_it_id = $row['it_id'];
            }
            $goods_count++;


            $image = get_it_image_best($row['it_id'], 105, 140, 8, '', '', 'original', stripslashes($row['it_name']));

            $it_name = '<span class="cart_it_name"><b>'.stripslashes($row['it_name']).'</b></span>';
            $it_options = print_item_options($row['it_id'], $s_cart_id);
            if($it_options) {
                $it_name .= '<div class="sod_opt">'.$it_options.'</div>';
            }

            // 복합과세금액
            if($default['de_tax_flag_use']) {
                if($row['it_notax']) {
                    $comm_free_mny += $sum['price'];
                } else {
                    $tot_tax_mny += $sum['price'];
                }
            }

            $point      = $sum['point'];
            $sell_price = $sum['price'];

            // 쿠폰
            if($is_member) {
                $cp_button = '';
                $cp_count = 0;

                $sql = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_minimum <= '$sell_price'
                              and (
                                    ( cp_method = '0' and cp_target = '{$row['it_id']}' )
                                    OR
                                    ( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                                  ) ";
                $res = sql_query($sql);

                for($k=0; $cp=sql_fetch_array($res); $k++) {
                    if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                        continue;

                    $cp_count++;
                }

                if($cp_count) {
                    $cp_button = '<button type="button" class="cp_btn btn_frmline">적용</button>';
                    $it_cp_count++;
                }
            }

            // 배송비
            switch($row['ct_send_cost'])
            {
                case 1:
                    $ct_send_cost = '착불';
                    break;
                case 2:
                    $ct_send_cost = 'free';
                    break;
                default:
                    $ct_send_cost = '';
                    break;
            }

            // 조건부무료
            if($row['it_sc_type'] == 2) {
                $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                if($sendcost == 0)
                    $ct_send_cost = '무료';
            }

            $item_qty = $row['ct_qty'];
        ?>

        <tr>
            <td class="cart_img"><?php echo $image; ?></td>
            <td class="cart_des">
                <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                <input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($row['it_name']); ?>">
                <input type="hidden" name="it_price[<?php echo $i; ?>]" value="<?php echo $sell_price; ?>">
                <input type="hidden" name="cp_id[<?php echo $i; ?>]" value="">
                <input type="hidden" name="cp_price[<?php echo $i; ?>]" value="0">
                <input type="hidden" name="item_<?php echo $i; ?>_product" value="<?php echo get_text($row['it_name']); ?>">
                <input type="hidden" name="item_<?php echo $i; ?>_quantity" value="<?php echo $sum['qty']; ?>">
                <input type="hidden" name="item_<?php echo $i; ?>_unitPrice" value="<?php echo number_format($sell_price, 2, ".", ""); ?>">
                <input type="hidden" name="cp_id[<?php echo $i; ?>]" value="">
                <input type="hidden" name="cp_price[<?php echo $i; ?>]" value="0">
                <?php if($default['de_tax_flag_use']) { ?>
                <input type="hidden" name="it_notax[<?php echo $i; ?>]" value="<?php echo $row['it_notax']; ?>">
                <?php } ?>
                <?php echo $it_name; ?>
            </td>
            <td class="cart_qty"><?php echo number_format($sum['qty']); ?></td>
            <td class="cart_num"><?php echo number_format($row['ct_price'], 2); ?></td>
            <td class="cart_num"><span class="total_price"><?php echo number_format($sell_price, 2); ?></span></td>
            <!-- <td class="td_dvr"><?php //echo $ct_send_cost; ?></td> -->
        </tr>

        <?php
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
        } // for 끝

        if ($i == 0) {
            //echo '<tr><td colspan="7" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
            alert('There are no items in your cart.', G5_SHOP_URL.'/cart.php');
        } else {
            // 배송비 계산
            $send_cost = get_sendcost($s_cart_id);
        }

        // 복합과세처리
        if($default['de_tax_flag_use']) {
            $comm_tax_mny = round(($tot_tax_mny + $send_cost) / 1.1);
            $comm_vat_mny = ($tot_tax_mny + $send_cost) - $comm_tax_mny;
        }
        ?>
        </tbody>
        </table>
    </div>

    <?php if ($goods_count) $goods .= ' 외 '.$goods_count.'건'; ?>
    <!-- } 주문상품 확인 끝 -->

    <!-- 주문상품 합계 시작 { -->
    <table id="sod_bsk_tot" class="subtotal_order">
        <tr class="sod_shipping">
            <td class="sod_bsk_dvr">TOTAL PRICE</td>
            <td class="sod_bsk_cnt"><strong>$<?php echo number_format($tot_sell_price, 2); ?></strong></td>
        </tr>
        <tr class="sod_shipping">
            <td class="sod_bsk_dvr">SHIPPING COST</td>
            <td class="sod_bsk_cnt"><strong>$<?php echo number_format($send_cost, 2); ?></strong></td>
        </tr>
        <tr class="sod_subtotal">
            <?php $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비 ?>
            <td class="sod_bsk_dvr">SUBTOTAL</td>
            <td class="sod_bsk_cnt"><strong>$<?php echo number_format($tot_price, 2); ?></strong></td>
        </tr>
    </table>
    <!-- } 주문상품 합계 끝 -->

    <input type="hidden" name="od_price" value="<?php echo number_format($tot_sell_price, 2, ".", ""); ?>">
    <input type="hidden" name="org_od_price" value="<?php echo number_format($tot_sell_price, 2, ".", ""); ?>">
    <input type="hidden" name="od_send_cost" value="<?php echo number_format($send_cost, 2, ".", ""); ?>">
    <input type="hidden" name="od_send_cost2" value="0">
    <input type="hidden" name="item_coupon" value="0">
    <input type="hidden" name="od_coupon" value="0">
    <input type="hidden" name="od_send_coupon" value="0">
    <input type="hidden" name="od_ref" value="<?php echo $od_id; ?>">

<?php /* 주문폼 자바스크립트 에러 방지를 위해 추가함 */ ?>
<input type="hidden" name="good_mny"    value="<?php echo $tot_price; ?>">
<?php if($default['de_tax_flag_use']) { ?>
    <input type="hidden" name="comm_tax_mny"      value="<?php echo $comm_tax_mny; ?>">         <!-- 과세금액    -->
    <input type="hidden" name="comm_vat_mny"      value="<?php echo $comm_vat_mny; ?>">         <!-- 부가세        -->
    <input type="hidden" name="comm_free_mny"     value="<?php echo $comm_free_mny; ?>">        <!-- 비과세 금액 -->
<?php } ?>

<!-- 결제에 필요 한 필수 파라미터 -->
<input type="hidden" name="ver" value="210" /><!-- 연동 버전 -->
<input type="hidden" name="txntype" value="PAYMENT" /><!-- 거래 타입 -->
<input type="hidden" name="charset" value="UTF-8" /><!-- 기본 값 : UTF-8 -->

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

    <!-- 주문하시는 분 입력 시작 { -->
    <section id="sod_frm_orderer">
    <div class="sct_cart_tbl review_order">
        <div class="ro_title"><span>2</span>Billing<br>Address</div>
        <table id="sod_list" class="ads_list">
            <thead>
                <tr>
                    <th scope="col" colspan="2" class="">Please provide your billing information.</th>
                </tr>
            </thead>
            <tbody>
            <tr><td colspan="2" style="height:12px"></td></tr>
            <tr>
                <th scope="row"><label for="od_name">First Name<strong class="sound_only"> required</strong></label></th>
                <td><input type="text" name="od_name" value="<?php echo $member['mb_name']; ?>" id="od_name" required class="frm_input required" maxlength="20"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_name_last">Last Name<strong class="sound_only"> required</strong></label></th>
                <td><input type="text" name="od_name_last" value="<?php echo $member['mb_name_last']; ?>" id="od_name_last" required class="frm_input required" maxlength="20"></td>
            </tr>

            <?php if (!$is_member) { // 비회원이면 ?>
            <tr>
                <th scope="row"><label for="od_pwd">Password</label></th>
                <td>
                    <input type="password" name="od_pwd" id="od_pwd" required class="frm_input required" maxlength="20" placeholder="Please enter your password 3~20 Characters.">
                </td>
            </tr>
            <?php } ?>
            <tr>
                <th scope="row"><label for="od_email">E-mail</label></th>
                <td><input type="text" name="od_email" value="<?php echo $member['mb_email']; ?>" id="od_email" required class="frm_input required" size="35" maxlength="100"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_tel">Phone Number</label></th>
                <td><input type="text" name="od_tel" value="<?php echo $member['mb_tel']; ?>" id="od_tel" required class="frm_input required" maxlength="20"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_addr1">Address Line 1</label></th>
                <td><input type="text" name="od_addr1" value="<?php echo $member['mb_addr1'] ?>" id="od_addr1" required class="frm_input frm_address required" size="60"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_addr2">Address Line 2</label></th>
                <td><input type="text" name="od_addr2" value="<?php echo $member['mb_addr2'] ?>" id="od_addr2" required class="frm_input frm_address required" size="60"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_city">City</label></th>
                <td><input type="text" name="od_city" value="<?php echo $member['mb_city'] ?>" id="od_city" required class="frm_input required" size="60"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_zip">Postal Code</label></th>
                <td><input type="text" name="od_zip" value="<?php echo $member['mb_zip']; ?>" id="od_zip" required class="frm_input required" size="12" maxlength="12"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_country">Country</label></th>
                <td>
                    <select id="od_country" name="od_country" required>
                    <option value="">SELECT YOUR COUNTRY</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antigua">Antigua</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bonaire">Bonaire</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Canary Islands">Canary Islands</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China, People's Republic">China, People's Republic</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo, The Democratic Republic of">Congo, The Democratic Republic of</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Curacao">Curacao</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands">Falkland Islands</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guernsey">Guernsey</option>
                    <option value="Guinea Republic">Guinea Republic</option>
                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                    <option value="Guyana (British)">Guyana (British)</option>
                    <option value="Guyana (French)">Guyana (French)</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jersey">Jersey</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, North">Korea, North</option>
                    <option value="Korea, South (Republic of Korea)">Korea, South (Republic of Korea)</option>
                    <option value="Kosovo">Kosovo</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau">Macau</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia">Micronesia</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montenegro">Montenegro</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Nevis">Nevis</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion, Island Of">Reunion, Island Of</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saipan">Saipan</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia">Serbia</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="Somaliland">Somaliland</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Sudan">South Sudan</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="St. Barthelemy">St. Barthelemy</option>
                    <option value="St. Eustatius">St. Eustatius</option>
                    <option value="St. Kitts">St. Kitts</option>
                    <option value="St. Lucia">St. Lucia</option>
                    <option value="St. Maarten">St. Maarten</option>
                    <option value="St. Vincent">St. Vincent</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Tahiti">Tahiti</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States Of America">United States Of America</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City">Vatican City</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                    <option value="Virgin Islands (US)">Virgin Islands (US)</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </td>
            </tr>

            <tr><td colspan="2" style="height:12px"></td></tr>
            </tbody>
            </table>
        </div>
    </section>
    <!-- } 주문하시는 분 입력 끝 -->

    <!-- 받으시는 분 입력 시작 { -->
    <?php
    if($is_member) {
        // 배송지 이력
        $addr_list = '';
        $sep = chr(30);

        // 주문자와 동일
        $addr_list .= '<input type="checkbox" name="ad_sel_addr" value="same" id="ad_sel_addr_same">'.PHP_EOL;
        $addr_list .= '<label for="ad_sel_addr_same">It\'s the same as the one in the billing address.</label>'.PHP_EOL;

        // 최근배송지
/*        $sql = " select *
                    from {$g5['g5_shop_order_address_table']}
                    where mb_id = '{$member['mb_id']}'
                      and ad_default = '0'
                    order by ad_id desc
                    limit 1 ";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $val1 = $row['ad_name'].$sep.$row['ad_name_last'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_country'].$sep.$row['ad_subject'];
            $val2 = '<label for="ad_sel_addr_'.($i+1).'">최근배송지('.($row['ad_subject'] ? $row['ad_subject'] : $row['ad_name']).')</label>';
            $addr_list .= '<input type="radio" name="ad_sel_addr" value="'.$val1.'" id="ad_sel_addr_'.($i+1).'"> '.PHP_EOL.$val2.PHP_EOL;
        }
*/
        //$addr_list .= '<label for="od_sel_addr_new">신규배송지</label>'.PHP_EOL;

        //$addr_list .='<a href="'.G5_SHOP_URL.'/orderaddress.php" id="order_address" class="btn_frmline">배송지목록</a>';
    } else {
        // 주문자와 동일
        $addr_list .= '<input type="checkbox" name="ad_sel_addr" value="same" id="ad_sel_addr_same">'.PHP_EOL;
        $addr_list .= '<label for="ad_sel_addr_same">It\'s the same as the one in the billing address.</label>'.PHP_EOL;
    }
    ?>
    <section id="sod_frm_taker">
    <div class="sct_cart_tbl review_order">
        <div class="ro_title"><span>3</span>Shipping<br>Address</div>
        <table id="sod_list" class="ads_list">
            <thead>
                <tr>
                    <th scope="col" colspan="2" class="title">Please provide your shipping information.<span><?php echo $addr_list; ?></span></th>
                </tr>
            </thead>
            <tbody>
            <tr><td colspan="2" style="height:12px"></td></tr>
            <tr>
                <th scope="row"><label for="od_b_name">First Name<strong class="sound_only"> required</strong></label></th>
                <td><input type="text" name="od_b_name" id="od_b_name" required class="frm_input required" maxlength="20"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_name_last">Last Name<strong class="sound_only"> required</strong></label></th>
                <td><input type="text" name="od_b_name_last" id="od_b_name_last" required class="frm_input required" maxlength="20"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_tel">Phone Number<strong class="sound_only"> required</strong></label></th>
                <td><input type="text" name="od_b_tel" id="od_b_tel" required class="frm_input required" maxlength="20"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_addr1">Address Line 1</label></th>
                <td><input type="text" name="od_b_addr1" id="od_b_addr1" class="frm_input frm_address required" maxlength="50"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_addr2">Address Line 2</label></th>
                <td><input type="text" name="od_b_addr2" id="od_b_addr2" class="frm_input frm_address required" maxlength="50"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_city">City</label></th>
                <td><input type="text" name="od_b_city" id="od_b_city" class="frm_input required" maxlength="50"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_zip">Postal Code</label></th>
                <td><input type="text" name="od_b_zip" id="od_b_zip" class="frm_input required" maxlength="12"></td>
            </tr>
            <tr>
                <th scope="row"><label for="od_b_country">Country</label></th>
                <td>
                    <select id="od_b_country" name="od_b_country" required>
                    <option value="">SELECT YOUR COUNTRY</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antigua">Antigua</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bonaire">Bonaire</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Canary Islands">Canary Islands</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China, People's Republic">China, People's Republic</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo, The Democratic Republic of">Congo, The Democratic Republic of</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Curacao">Curacao</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands">Falkland Islands</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guernsey">Guernsey</option>
                    <option value="Guinea Republic">Guinea Republic</option>
                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                    <option value="Guyana (British)">Guyana (British)</option>
                    <option value="Guyana (French)">Guyana (French)</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jersey">Jersey</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, North">Korea, North</option>
                    <option value="Korea, South (Republic of Korea)">Korea, South (Republic of Korea)</option>
                    <option value="Kosovo">Kosovo</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau">Macau</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia">Micronesia</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montenegro">Montenegro</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Nevis">Nevis</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion, Island Of">Reunion, Island Of</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saipan">Saipan</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia">Serbia</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="Somaliland">Somaliland</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Sudan">South Sudan</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="St. Barthelemy">St. Barthelemy</option>
                    <option value="St. Eustatius">St. Eustatius</option>
                    <option value="St. Kitts">St. Kitts</option>
                    <option value="St. Lucia">St. Lucia</option>
                    <option value="St. Maarten">St. Maarten</option>
                    <option value="St. Vincent">St. Vincent</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Tahiti">Tahiti</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States Of America">United States Of America</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City">Vatican City</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                    <option value="Virgin Islands (US)">Virgin Islands (US)</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="2" style="height:12px"></td></tr>
            </tbody>
            </table>
        </div>
    </section>
    <!-- } 받으시는 분 입력 끝 -->

    <!-- 결제정보 입력 시작 { -->
    <?php
    $oc_cnt = $sc_cnt = 0;
    if($is_member) {
        // 주문쿠폰
        $sql = " select cp_id
                    from {$g5['g5_shop_coupon_table']}
                    where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                      and cp_method = '2'
                      and cp_start <= '".G5_TIME_YMD."'
                      and cp_end >= '".G5_TIME_YMD."'
                      and cp_minimum <= '$tot_sell_price' ";
        $res = sql_query($sql);

        for($k=0; $cp=sql_fetch_array($res); $k++) {
            if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                continue;

            $oc_cnt++;
        }

        if($send_cost > 0) {
            // 배송비쿠폰
            $sql = " select cp_id
                        from {$g5['g5_shop_coupon_table']}
                        where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                          and cp_method = '3'
                          and cp_start <= '".G5_TIME_YMD."'
                          and cp_end >= '".G5_TIME_YMD."'
                          and cp_minimum <= '$tot_sell_price' ";
            $res = sql_query($sql);

            for($k=0; $cp=sql_fetch_array($res); $k++) {
                if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                    continue;

                $sc_cnt++;
            }
        }
    }
    ?>

       <?php

        $multi_settle == 0;
        $checked = '';
        $temp_point = 0;
        ?>
    <!-- } 결제 정보 입력 끝 -->

    <?php
// 무통장입금 사용
        if ($default['de_bank_use']) {
            $multi_settle++;
            echo '<input type="radio" id="od_settle_bank" name="od_settle_case" value="무통장" '.$checked.'> <label for="od_settle_bank">무통장입금</label>'.PHP_EOL;
            $checked = '';
        }
        // 신용카드 사용
        if ($default['de_card_use']) {
            $multi_settle++;
            echo '<input type="hidden" id="od_settle_card" name="od_settle_case" value="신용카드">'.PHP_EOL;
            $checked = '';
        }
    // 결제대행사별 코드 include (주문버튼)
    ?>
<div id="display_pay_button" style="padding:5px 0 30px;" class="btn_confirm" style="display:none">
    <input type="button" value="CHECKOUT NOW" class="btn_submit" onclick="javascript:forderform_check();">
    <a href="javascript:history.go(-1);" class="btn01">Quit</a>
</div>
<div id="display_pay_process" style="display:none">
    <img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="">
    <span>주문완료 중입니다. 잠시만 기다려 주십시오.</span>
</div>

<script>
document.getElementById("display_pay_button").style.display = "" ;
</script>
    </form>

</div>

</div>

<script>
$(function() {
    var $cp_btn_el;
    var $cp_row_el;
    var zipcode = "";
    var $mb_country = "<?php echo $member['mb_country']; ?>";
    $('#od_country').val($mb_country).attr('selected', 'selected');

    $("#od_b_addr2").focus(function() {
        var zip = $("#od_b_zip").val().replace(/[^0-9]/g, "");
        if(zip == "")
            return false;

        var code = String(zip);

        if(zipcode == code)
            return false;

        zipcode = code;
        calculate_sendcost(code);
    });

    $("#od_settle_bank").on("click", function() {
        $("[name=od_deposit_name]").val( $("[name=od_name]").val() );
        $("#settle_bank").show();
    });

    $("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp").bind("click", function() {
        $("#settle_bank").hide();
    });

    // 배송지선택
    $("input[name=ad_sel_addr]").on("click", function() {
        var addr = $(this).val().split(String.fromCharCode(30));

        if (addr[0] == "same") {
            if($(this).is(":checked"))
                gumae2baesong(true);
            else
                gumae2baesong(false);
        } else {
            if(addr[0] == "new") {
                for(i=0; i<10; i++) {
                    addr[i] = "";
                }
            }

            var f = document.forderform;
            f.od_b_name.value        = addr[0];
            f.od_b_name_last.value   = addr[1];
            f.od_b_tel.value         = addr[2];
            f.od_b_hp.value          = addr[3];
            f.od_b_country.value     = addr[4];
            f.od_b_city.value        = addr[5];

            f.od_b_addr1.value       = addr[6];
            f.od_b_addr2.value       = addr[7];
            f.od_b_zip.value         = addr[8];
            f.ad_subject.value       = addr[9];

            var zip = addr[8].replace(/[^0-9]/g, "");

            if(zip != "") {
                var code = String(zip);

                if(zipcode != code) {
                    zipcode = code;
                    calculate_sendcost(code);
                }
            }
        }
    });

});

function coupon_cancel($el)
{
    var $dup_sell_el = $el.find(".total_price");
    var $dup_price_el = $el.find("input[name^=cp_price]");
    var org_sell_price = $el.find("input[name^=it_price]").val();

    $dup_sell_el.text(number_format(String(org_sell_price)));
    $dup_price_el.val(0);
    $el.find("input[name^=cp_id]").val("");
}

function calculate_total_price()
{
    var $it_prc = $("input[name^=it_price]");
    var $cp_prc = $("input[name^=cp_price]");
    var tot_sell_price = sell_price = tot_cp_price = 0;
    var it_price, cp_price, it_notax;
    var tot_mny = comm_tax_mny = comm_vat_mny = comm_free_mny = tax_mny = vat_mny = 0;
    var send_cost = parseFloat($("input[name=od_send_cost]").val());

    $it_prc.each(function(index) {
        it_price = parseFloat($(this).val());
        cp_price = parseFloat($cp_prc.eq(index).val());
        sell_price += it_price;
        tot_cp_price += cp_price;
    });

    tot_sell_price = sell_price - tot_cp_price + send_cost;

    $("#ct_tot_coupon").text("$"+number_format(String(tot_cp_price), 2, ".", ","));
    $("#ct_tot_price").text("$"+number_format(String(tot_sell_price), 2, ".", ","));

    $("input[name=good_mny]").val(number_format(String(tot_sell_price), 2, ".", ""));
    $("input[name=od_price]").val(sell_price - tot_cp_price);
    $("input[name=item_coupon]").val(tot_cp_price);
    $("input[name=od_coupon]").val(0);
    $("input[name=od_send_coupon]").val(0);
    <?php if($oc_cnt > 0) { ?>
    $("input[name=od_cp_id]").val("");
    $("#od_cp_price").text(0);
    if($("#od_coupon_cancel").size()) {
        $("#od_coupon_btn").text("쿠폰적용");
        $("#od_coupon_cancel").remove();
    }
    <?php } ?>
    <?php if($sc_cnt > 0) { ?>
    $("input[name=sc_cp_id]").val("");
    $("#sc_cp_price").text(0);
    if($("#sc_coupon_cancel").size()) {
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();
    }
    <?php } ?>
    $("input[name=od_temp_point]").val(0);
    <?php if($temp_point > 0 && $is_member) { ?>
    calculate_temp_point();
    <?php } ?>
    calculate_order_price();
}

function calculate_order_price()
{
    var sell_price = parseFloat($("input[name=od_price]").val());
    var send_cost = parseFloat($("input[name=od_send_cost]").val());
    var send_cost2 = parseFloat($("input[name=od_send_cost2]").val());
    var send_coupon = parseFloat($("input[name=od_send_coupon]").val());
    var tot_price = sell_price + send_cost + send_cost2 - send_coupon;

    $("input[name=good_mny]").val(tot_price);
    $("#od_tot_price").text(number_format(String(tot_price)));
    <?php if($temp_point > 0 && $is_member) { ?>
    calculate_temp_point();
    <?php } ?>
}

function calculate_temp_point()
{
    var sell_price = parseInt($("input[name=od_price]").val());
    var mb_point = parseInt(<?php echo $member['mb_point']; ?>);
    var max_point = parseInt(<?php echo $default['de_settle_max_point']; ?>);
    var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
    var temp_point = max_point;

    if(temp_point > sell_price)
        temp_point = sell_price;

    if(temp_point > mb_point)
        temp_point = mb_point;

    temp_point = parseInt(temp_point / point_unit) * point_unit;

    $("#use_max_point").text("최대 "+number_format(String(temp_point))+"점");
    $("input[name=max_temp_point]").val(temp_point);
}

function calculate_sendcost(code)
{
    $.post(
        "./ordersendcost.php",
        { zipcode: code },
        function(data) {
            $("input[name=od_send_cost2]").val(data);
            $("#od_send_cost2").text(number_format(String(data)));

            calculate_order_price();
        }
    );
}

function calculate_tax()
{
    var $it_prc = $("input[name^=it_price]");
    var $cp_prc = $("input[name^=cp_price]");
    var sell_price = tot_cp_price = 0;
    var it_price, cp_price, it_notax;
    var tot_mny = comm_free_mny = tax_mny = vat_mny = 0;
    var send_cost = parseFloat($("input[name=od_send_cost]").val());
    var send_cost2 = parseFloat($("input[name=od_send_cost2]").val());
    var od_coupon = parseFloat($("input[name=od_coupon]").val());
    var send_coupon = parseFloat($("input[name=od_send_coupon]").val());
    var temp_point = 0;

    $it_prc.each(function(index) {
        it_price = parseFloat($(this).val());
        cp_price = parseFloat($cp_prc.eq(index).val());
        sell_price += it_price;
        tot_cp_price += cp_price;
        it_notax = $("input[name^=it_notax]").eq(index).val();
        if(it_notax == "1") {
            comm_free_mny += (it_price - cp_price);
        } else {
            tot_mny += (it_price - cp_price);
        }
    });

    if($("input[name=od_temp_point]").size())
        temp_point = parseInt($("input[name=od_temp_point]").val());

    tot_mny += (send_cost + send_cost2 - od_coupon - send_coupon - temp_point);
    if(tot_mny < 0) {
        comm_free_mny = comm_free_mny + tot_mny;
        tot_mny = 0;
    }

    tax_mny = Math.round(tot_mny / 1.1);
    vat_mny = tot_mny - tax_mny;
    $("input[name=comm_tax_mny]").val(tax_mny);
    $("input[name=comm_vat_mny]").val(vat_mny);
    $("input[name=comm_free_mny]").val(comm_free_mny);
}

function forderform_check()
{
    var f = document.forderform;
    // 재고체크
    var stock_msg = order_stock_check();
    if(stock_msg != "") {
        alert(stock_msg);
        return false;
    }

    errmsg = "";
    errfld = "";
    var deffld = "";

    check_field(f.od_name, "Please enter your name.");
    if (typeof(f.od_pwd) != 'undefined')
    {
        clear_field(f.od_pwd);
        if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
            error_field(f.od_pwd, "Please enter your password");
    }
    check_field(f.od_tel, "Please enter your Telephone/Mobile number.");
    check_field(f.od_zip, "");

    clear_field(f.od_email);
    if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
        error_field(f.od_email, "Invalid E-mail address. Please check your E-mail again.");

    check_field(f.od_b_name, "Please enter recipient's name.");
    check_field(f.od_b_tel, "Please enter recipient's Telephone/Mobile number.");
    check_field(f.od_b_zip, "");

    // 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
    f.od_send_cost.value = parseFloat(f.od_send_cost.value);

    if (errmsg)
    {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    var settle_case = document.getElementsByName("od_settle_case");
    var settle_check = false;
    var settle_method = "";
    for (i=0; i<settle_case.length; i++)
    {
            settle_check = true;
            settle_method = settle_case[i].value;
            break;
    }
    if (!settle_check)
    {
        alert("결제방식을 선택하십시오.");
        return false;
    }

    var od_price = parseFloat(f.od_price.value);
    var send_cost = parseFloat(f.od_send_cost.value);
    var send_cost2 = parseFloat(f.od_send_cost2.value);
    var send_coupon = parseFloat(f.od_send_coupon.value);

    var max_point = 0;
    if (typeof(f.max_temp_point) != "undefined")
        max_point  = parseInt(f.max_temp_point.value);

    var temp_point = 0;
    if (typeof(f.od_temp_point) != "undefined") {
        if (f.od_temp_point.value)
        {
            var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
            temp_point = parseInt(f.od_temp_point.value);

            if (temp_point < 0) {
                alert("Redeem minimum 1,000 points.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point > od_price) {
                alert("Invalid number. Please input valid number.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
                alert("Invalid number. Please input valid number.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point != od_price && document.getElementById("od_settle_vpoint").checked) {
                alert("You do not have enough points. \nPlease select another payment method.");
                document.getElementById("od_settle_card").focus();
                return false;
            }

            if (temp_point == od_price) {
                if(temp_point < 50000 && document.getElementById("od_settle_vpoint").checked) {
                    alert("Free shipping on orders over 80$");
                    document.getElementById("od_settle_card").focus();
                    return false;
                } else if (document.getElementById("od_settle_vbank").checked || document.getElementById("od_settle_card").checked || document.getElementById("od_settle_hp").checked) {
                    alert("Your total order should be above 1$.");
                    document.getElementById("od_settle_vpoint").focus();
                    return false;
                }
            }

            if (temp_point > max_point) {
                alert("Please redeem your points up to " + max_point);
                f.od_temp_point.select();
                return false;
            }

            if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
                alert("Reward points can be redeemed to any value in multiples of "+String(point_unit));
                f.od_temp_point.select();
                return false;
            }

            // pg 결제 금액에서 포인트 금액 차감
            if(settle_method != "무통장") {
                f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
            }
        }
    }

    var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

    <?php if($default['de_tax_flag_use']) { ?>
    calculate_tax();
    <?php } ?>

    // pay_method 설정
    <?php if($default['de_pg_service'] == 'eximbay') { ?>
        f.txntype.value = "PAYMENT";
    <?php } else if($default['de_pg_service'] == 'kcp') { ?>
    switch(settle_method)
    {
        case "계좌이체":
            f.pay_method.value = "010000000000";
            break;
        case "가상계좌":
            f.pay_method.value = "001000000000";
            break;
        case "휴대폰":
            f.pay_method.value = "000010000000";
            break;
        case "신용카드":
            f.pay_method.value = "100000000000";
            break;
        default:
            f.pay_method.value = "무통장";
            break;
    }
    <?php } else if($default['de_pg_service'] == 'lg') { ?>
    switch(settle_method)
    {
        case "계좌이체":
            f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
            f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
            break;
        case "가상계좌":
            f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
            f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
            break;
        case "휴대폰":
            f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
            f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
            break;
        case "신용카드":
            f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
            f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
            break;
        default:
            f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
            break;
    }
    <?php }  else if($default['de_pg_service'] == 'inicis') { ?>
    switch(settle_method)
    {
        case "계좌이체":
            f.gopaymethod.value = "onlydbank";
            break;
        case "가상계좌":
            f.gopaymethod.value = "onlyvbank";
            break;
        case "휴대폰":
            f.gopaymethod.value = "onlyhpp";
            break;
        case "신용카드":
            f.gopaymethod.value = "onlycard";
            break;
        case "전액포인트":
            f.gopaymethod.value = "전액포인트";
            break;
        default:
            f.gopaymethod.value = "무통장";
            break;
    }
    <?php } ?>

    // 결제정보설정
    <?php if($default['de_pg_service'] == 'eximbay') { ?>
    f.ref.value = f.od_ref.value;
    f.mid.value = '<?php echo $mid; ?>';
    f.cur.value = 'USD';
    f.amt.value = number_format(f.good_mny.value, 2, ".", "");
    f.buyer.value = f.od_name.value + " " + f.od_name_last.value;
    f.tel.value = f.od_tel.value;
    f.email.value = f.od_email.value;
    f.shipTo_country = f.od_b_country.value;
    f.shipTo_city = f.od_b_city.value;
    f.shipTo_fistName = f.od_b_name.value;
    f.shipTo_lastName = f.od_b_name_last.value;
    f.shipTo_phoneNumber = f.od_b_tel.value;
    f.shipTo_postalCode = f.od_b_zip.value;
    f.shipTo_street1 = f.od_b_addr1.value + " " + f.od_b_addr2.value;

    f.submit();
    <?php } ?>
} // END forderform_check

// 구매자 정보와 동일합니다.
function gumae2baesong(checked) {
    var f = document.forderform;

    if(checked == true) {
        f.od_b_name.value      = f.od_name.value;
        f.od_b_name_last.value = f.od_name_last.value;
        f.od_b_tel.value       = f.od_tel.value;
        f.od_b_city.value      = f.od_city.value;
        f.od_b_country.value   = f.od_country.value;
        f.od_b_addr1.value     = f.od_addr1.value;
        f.od_b_addr2.value     = f.od_addr2.value;
        f.od_b_zip.value       = f.od_zip.value;

        calculate_sendcost(String(f.od_b_zip.value));
    } else {
        f.od_b_name.value      = "";
        f.od_b_name_last.value = "";
        f.od_b_tel.value       = "";
        f.od_b_city.value        = "";
        f.od_b_country.value   = "";
        f.od_b_addr1.value     = "";
        f.od_b_addr2.value     = "";
        f.od_b_zip.value       = "";
    }
}

<?php if ($default['de_hope_date_use']) { ?>
$(function(){
    $("#od_hope_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", minDate: "+<?php echo (int)$default['de_hope_date_after']; ?>d;", maxDate: "+<?php echo (int)$default['de_hope_date_after'] + 6; ?>d;" });
});
<?php } ?>
</script>

<?php
include_once('./_tail.php');

// 결제대행사별 코드 include (스크립트 실행)
require_once('./'.$default['de_pg_service'].'/orderform.5.php');
?>