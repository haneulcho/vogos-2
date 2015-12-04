// 인덱스 Video 모달창 상품보관 위시리스트 ajax 처리를 위해 추가된 부분
function vitem_wish(it_id)
{
    if(!it_id) {
        alert("상품코드가 올바르지 않습니다.");
        return false;
    }

    $.post(
        g5_shop_skin_url+"/item.form.wishupdate.php",
        { it_id: it_id },
        function(error) {
            if(error != "OK") {
                alert(error.replace(/\\n/g, "\n"));
                return false;
            }

            var wish_msg_layer = "";
            wish_msg_layer += "<div id=\"wish_msg_layer\">";
            wish_msg_layer += "<p>상품이 위시리스트에 담겼습니다.<br><strong>지금 확인하시겠습니까?</strong></p>";
            wish_msg_layer += "<div>";
            wish_msg_layer += "<button type=\"button\" id=\"wish_msg_yes\"><img src=\""+g5_shop_skin_url+"/img/pop_msg_yes.gif\" alt=\"예\"></button>";
            wish_msg_layer += "<button type=\"button\" id=\"wish_msg_no\"><img src=\""+g5_shop_skin_url+"/img/pop_msg_no.gif\" alt=\"아니오\"></button>";
            wish_msg_layer += "</div>";
            wish_msg_layer += "</div>";

            $('#v'+it_id).append(wish_msg_layer);
        }
    );
}
$(function(){
    // 위시리스트 레이어 닫기
    $("#wish_msg_close, #wish_msg_no").live("click", function() {
        $("#wish_msg_layer").fadeOut(400, function() {
            $(this).remove();
        });
    });

    // 위시리스트 이동
    $("#wish_msg_yes").live("click", function() {
        document.location.href = g5_shop_url+"/wishlist.php";
    });
});