<?php
include_once('./_common.php');

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/cart.php');
    return;
}

$g5['title'] = 'My Cart';
include_once('./_head.php');

$tot_point = 0;
$tot_sell_price = 0;

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
                b.ca_id3
           from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
          where a.od_id = '$s_cart_id' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$cart_item_num = mysql_num_rows($result);

$it_send_cost = 0;
?>

<!-- 장바구니 시작 { -->
<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>

<div id="sod_bsk">

    <div id="sod_title">
        <header class="fullWidth">
            <h2>MY CART <span class="cart_item_num"><?php echo $cart_item_num; ?></span></h2>
        </header>
    </div>

    <div class="fullWidth">
    <form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $cart_action_url; ?>">
    <div class="sct_cart_tbl">
        <table>
        <thead>
        <tr>
            <th class="th_cart_des" scope="col" colspan="2" class="itemdes">ITEM DESCRIPTION</th>
            <th class="th_cart_qty" scope="col">TOTAL QTY</th>
            <th class="th_cart_num" scope="col">UNIT PRICE</th>
            <th class="th_cart_num" scope="col">TOTAL PRICE</th>
            <th class="th_cart_chk" scope="col"><div class="chk_all active"><i class="ion-android-checkbox-outline"></i></div></th>
        </tr>
        </thead>
        <tbody>
        <?php
        // 로그분석기 시작
        $row_count = mysql_num_rows($result);
        $http_SO="cart";    //장바구니페이지
        $http_PA="";    //장바구니(상품명_수량)
        // 로그분석기 끝

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

            if ($i==0) { // 계속쇼핑
                $continue_ca_id = $row['ca_id'];
            }

            $a1 = '<a class="cart_it_name" href="./item.php?it_id='.$row['it_id'].'"><b>';
            $a2 = '</b></a>';
            $image = get_it_image_best($row['it_id'], 105, 140, 8, '', '', 'original', stripslashes($row['it_name']));

            $it_name = $a1 . stripslashes($row['it_name']) . $a2; // 상품명
            $it_options = print_item_options_cart($row['it_id'], $s_cart_id);
            if($it_options) {
                $it_name .= '<div class="sod_opt">'.$it_options.'</div>';
                $mod_options = '<div class="sod_option_btn"><button type="button" class="mod_options"><img src="'.G5_SHOP_SKIN_URL.'/img/cart/btn_change.jpg" alt="Change Details"></button>';
            }

            // 배송비
            switch($row['ct_send_cost'])
            {
                case 1:
                    $ct_send_cost = '착불';
                    break;
                case 2:
                    $ct_send_cost = '무료';
                    break;
                default:
                    $ct_send_cost = '선불';
                    break;
            }

            // 조건부무료
            if($row['it_sc_type'] == 2) {
                $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                if($sendcost == 0)
                    $ct_send_cost = '무료';
            }

            $point      = $sum['point'];
            $sell_price = $sum['price'];
        ?>

        <tr>
            <td class="cart_img"><?php echo $image; ?></td>
            <td class="cart_des">
                <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                <input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($row['it_name']); ?>">
                <?php echo $it_name.$mod_options; ?>
                <button type="button" onclick="remove_item('<?php echo $row['it_id']; ?>');" class="mod_remove"><?php echo '<img src="'.G5_SHOP_SKIN_URL.'/img/cart/btn_remove_option.jpg" alt="Remove Items">' ?></button></div>
            </td>
            <td class="cart_qty"><?php echo number_format($sum['qty']); ?></td>
            <td class="cart_num"><?php echo number_format($row['ct_price']); ?></td>
            <td class="cart_num"><span id="sell_price_<?php echo $i; ?>">$<?php echo number_format($sell_price); ?></span></td>
            <td class="cart_chk">
                <label for="ct_chk_<?php echo $i; ?>" class="sound_only">Select</label>
                <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
            </td>
        </tr>

        <?php
            $tot_point      += $point;
            $tot_sell_price += $sell_price;

            // 로그분석기 변수 전달
            $http_PA .= $row['it_name']."_";

            if ($i < $row_count-1) {
                $http_PA .= number_format($sum['qty']).";";
            } else {
                $http_PA .= number_format($sum['qty']);
            }
            // 로그분석기 변수 전달 끝

        } // for 끝

        if ($i == 0) {
            echo '<tr><td colspan="8" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
        } else {
            // 배송비 계산
            $send_cost = get_sendcost($s_cart_id, 0);
        }
        ?>
        </tbody>
        </table>
    </div>

    <?php
    $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
    if ($tot_price > 0 || $send_cost > 0) {
    ?>
    <table id="sod_bsk_tot">
        <?php if ($send_cost > 0) { // 배송비가 0 보다 크다면 (있다면) ?>
        <tr class="sod_shipping">
            <td class="sod_bsk_dvr">배송비</td>
            <td class="sod_bsk_cnt"><strong><?php echo number_format($send_cost); ?> 원</strong></td>
        </tr>
        <?php } ?>
        <?php if ($tot_price > 0) { ?>
        <tr class="sod_subtotal">
            <td class="sod_bsk_dvr">SUBTOTAL</td>
            <td class="sod_bsk_cnt"><strong><?php echo number_format($tot_price); ?> 원 / <?php echo number_format($tot_point); ?> 점</strong></td>
        </tr>
        <?php } ?>
        <?php if ($i > 0) { ?>
        <tr class="sod_checkout">
            <td colspan="2"><button type="button" onclick="return form_check('buy');"><?php echo '<img src="'.G5_SHOP_SKIN_URL.'/img/cart/btn_checkout.jpg" alt="Checkout">' ?></button></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>

    <?php if ($i == 0) { ?>
    <div id="sod_bsk_act_con">
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=10" class="continue">쇼핑 계속하기</a>
    <?php } else { ?>
    <div id="sod_bsk_act">
        <input type="hidden" name="url" value="./orderform.php">
        <input type="hidden" name="records" value="<?php echo $i; ?>">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="it_del_id" value="">
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $continue_ca_id; ?>" class="btn_act"><?php echo '<img src="'.G5_SHOP_SKIN_URL.'/img/cart/btn_continue.jpg" alt="쇼핑 계속하기">' ?></a>
        <button type="button" onclick="return form_check('alldelete');" class="btn_act"><?php echo '<img src="'.G5_SHOP_SKIN_URL.'/img/cart/btn_empty.jpg" alt="Empty cart">' ?></button>
        <?php } ?>
    </div>

    </form>
    </div>

</div>

<!-- 네이버 프리미엄로그분석 전환페이지 설정_ 장바구니담기 -->
 <script type="text/javascript" src="http://wcs.naver.net/wcslog.js"> </script> 
 <script type="text/javascript">
var _nasa={};
 _nasa["cnv"] = wcs.cnv("3","10");
</script>

<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var it_id = $(this).closest("tr").find("input[name^=it_id]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        // 카트 옵션 ajax로 불러오기
        $.post(
            "./cartoption.php",
            { it_id: it_id },
            function(data) {
                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div>");
                $("#mod_option_frm").hide().html(data).fadeIn('fast');
                price_calculate();
            }
        );
    });

    // 모두선택
    $(".chk_all").click(function() {
        if($(this).hasClass('active')) {
            $("input[name^=ct_chk]").attr("checked", false);
            $(this).removeClass('active');            
        } else {
            $("input[name^=ct_chk]").attr("checked", true);
            $(this).addClass('active');
        }
    });

    // 옵션수정 닫기
    $("#mod_option_close").live("click", function() {
        $("#mod_option_frm").fadeOut('fast', function() {
            $(this).remove();            
        });
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function remove_item(remove_id) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if(confirm('이 상품을 장바구니에서 삭제할까요?')) {
        f.act.value = "onedelete";
        f.it_del_id.value = remove_id;
        f.submit();
    }
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy")
    {
        if($("input[name^=ct_chk]:checked").size() < 1) {
            alert("주문하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }
    else if (act == "alldelete")
    {
        if(confirm('정말 장바구니를 비우시겠습니까?')) {
            f.act.value = act;
            f.submit();
        }
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").size() < 1) {
            alert("삭제하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }
        if(confirm('선택한 상품을 장바구니에서 삭제할까요?')) {
            f.act.value = act;
            f.submit();
        }
    }

    return true;
}
</script>
<!-- } 장바구니 끝 -->

<?php
include_once('./_tail.php');
?>