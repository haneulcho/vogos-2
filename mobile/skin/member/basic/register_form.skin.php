<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="default_contents">
<!-- 회원정보 입력/수정 시작 { -->
<div id="mb_join" class="mbskin">
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js"></script>
    <?php } ?>
    <h1><?php echo $w==''?'VOGOS Sign Up':'Edit Information'; ?></h1>
    <form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php } ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면 ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo $member['mb_nick'] ?>">
    <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick'] ?>">
    <?php } ?>

    <div class="tbl">
        <table>
        <caption>Basic Information</caption>
        <tr>
            <th scope="row"><label for="reg_mb_id">ID<strong class="sound_only">Required</strong></label></th>
            <td>
                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" class="frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="A-Z, 0-9" <?php echo $required ?> <?php echo $readonly ?>>
                <span id="msg_mb_id"></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_email">E-mail<strong class="sound_only">required</strong></label></th>
            <td>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email required" size="50" maxlength="100">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_password">Password<strong class="sound_only">*Required</strong></label></th>
            <td><input type="password" name="mb_password" id="reg_mb_password" class="frm_input <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?>></td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_password_re">Verify Password<strong class="sound_only">Required</strong></label></th>
            <td><input type="password" name="mb_password_re" id="reg_mb_password_re" class="frm_input <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?>></td>
        </tr>
        <tr>
            <th scope="row" style="padding-top:0;"><label for="reg_mb_country">Country<strong class="sound_only">Required</strong></label></th>
            <td style="padding-bottom:12px;">
                <select id="reg_mb_country" name="mb_country" <?php echo $required ?>>
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
        </table>
    </div>

<?php if(!$w=='') { ?>
    <div class="tbl">
        <table>
        <caption>Additional Information</caption>
        <tr>
            <th scope="row"><label for="reg_mb_name">First Name<strong class="sound_only">*</strong></label></th>
            <td>
                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo $member['mb_name'] ?>" <?php echo $required ?> class="frm_input <?php echo $required ?>">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_name_last">Last Name<strong class="sound_only">*</strong></label></th>
            <td>
                <input type="text" id="reg_mb_name_last" name="mb_name_last" value="<?php echo $member['mb_name_last'] ?>" <?php echo $required ?> class="frm_input <?php echo $required ?>">
            </td>
        </tr>
        <?php if ($config['cf_use_tel']) { ?>
        <tr>
            <th scope="row"><label for="reg_mb_tel">Telephone</label></th>
            <td>
                <input type="text" name="mb_tel" value="<?php echo $member['mb_tel'] ?>" id="reg_mb_tel" class="frm_input" maxlength="20">
            </td>
        </tr>
        <?php } ?>
        <?php if ($config['cf_use_hp']) { ?>
        <tr>
            <th scope="row"><label for="reg_mb_hp">Mobile</label></th>
            <td>
                <input type="text" name="mb_hp" value="<?php echo $member['mb_hp'] ?>" id="reg_mb_hp" class="frm_input" maxlength="20">
            </td>
        </tr>
        <?php } ?>
        <?php if ($config['cf_use_addr']) { ?>
        <tr>
            <th scope="row"><label for="reg_mb_addr1">Address Line 1</label></th>
            <td>
                <input type="text" name="mb_addr1" value="<?php echo $member['mb_addr1']; ?>" id="reg_mb_addr1" class="frm_input" size="5" maxlength="65">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_addr2">Address Line 2</label></th>
            <td>
                <input type="text" name="mb_addr2" value="<?php echo $member['mb_addr2']; ?>" id="reg_mb_addr2" class="frm_input" size="5" maxlength="65">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_zip">Postal Code</label></th>
            <td>
                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip']; ?>" id="reg_mb_zip" class="frm_input" size="5" maxlength="15">
            </td>
        </tr>
        <?php } ?>
        </table>
    </div>
<?php } ?>

    <div class="tbl" style="margin-bottom:20px;">
        <table>
        <tr>
            <th scope="row" style="padding:12px;">I'd like to receive exclusive discounts and news from VOGOS by email and post</th>
        </tr>
        <tr>
            <td style="padding:0 0 12px 0;text-align:center;">
                <input type="radio" name="mb_mailling" value="1" id="reg_mb_mailling1" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>> <label for="reg_mb_mailling1" style="margin-right:10px;">Yes</label>
                <input type="radio" name="mb_mailling" value="0" id="reg_mb_mailling0"> <label for="reg_mb_mailling0">No thanks</label>
            </td>
        </tr>

        <!-- <tr>
            <th scope="row">자동등록방지</th>
            <td><?php //echo captcha_html(); ?></td>
        </tr> -->
        </table>
    </div>

    <div class="btn_confirm">
        <!-- <a href="<?php //echo G5_URL; ?>/" class="btn_cancel">취소</a> -->
        <input type="submit" value="<?php echo $w==''?'Sign Up':'Confirm'; ?>" id="btn_submit" class="btn_submit" accesskey="s">
    </div>
    </form>

    <script>
    $(function() {
        $("#reg_mb_id").focus();
        $("#reg_zip_find").css("display", "inline-block");

        var $mb_country = "<?php echo $member['mb_country']; ?>";
        $('#reg_mb_country').val($mb_country).attr('selected', 'selected');

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>
    });

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("Please enter your password at least 3 characters.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("Please check that passwords match.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("Please enter your password at least 3 characters.");
                f.mb_password_re.focus();
                return false;
            }
        }

        // 국가 검사
        if (f.w.value=="") {
            if (f.mb_country.value.length < 1) {
                alert("Please select your country.");
                f.mb_country.focus();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert("본인을 추천할 수 없습니다.");
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

</div>
<!-- } 회원정보 입력/수정 끝 -->
</div>