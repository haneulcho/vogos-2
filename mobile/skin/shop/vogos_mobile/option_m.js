// list.20.skin VIDEO Plugin 코드 추가
$(function() {
    var $showHref = $('.hasVideo');

    $showHref.each(function() {
        var $itemDetail = $(this).children('.sct_a').children('.itemDetail');
        var $btn_video = $(this).children('.btn_video');
        var $modal_info = $(this).children('.modal_info');
        var $modal_wrap = $(this).children('.modal_info').children('.vsit_ov_wrap');
        $(this).mouseenter(function(e) {
                $itemDetail.filter(':not(:animated)').fadeIn(300);
                $btn_video.filter(':not(:animated)').fadeIn(300);
            })
            .mouseleave(function() {
                $itemDetail.filter(':not(:animated)').fadeOut(300);
                $btn_video.filter(':not(:animated)').fadeOut(300);
            });
        $btn_video.on('click', function(e){
            showModal(true);
            e.preventDefault();
        });
        function showModal(flag) {
            if(flag) {
                $modal_layer = "<div class=\"modal_video\"></div>";
                $modal_close = "<div class=\"modal_close\" style=\"height:300px\"></div>";
                $btn_video.after($modal_layer);
                $modal_wrap.append($modal_close);
                $modal_info.filter(':not(:animated)').animate({opacity:'show'}, 250);
                $('.modal_video, .modal_close').live("click", function() {
                    $modal_info.filter(':not(:animated)').animate({opacity:'hide'}, 250);
                    $('.modal_video, .modal_close').fadeOut(250, function() {
                        $('#wish_msg_layer').remove();
                        $(this).remove();
                    });
                });
            }
        }
    });
});