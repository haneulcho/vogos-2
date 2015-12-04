function view_video(vid) {
    $.ajax({
        type: 'POST',
        data: { it_id: vid},
        url: g5_shop_skin_url + "/video.form.skin.php",
        success: function(data) {
            // success function 불러오기
            $modal_contents = $(data).filter('.modal_contents');
            $modal_wrap = $modal_contents.find('.modal_wrap');
            $modal_video = $modal_contents.find('.modal_video');
            $modal_inform = $modal_contents.find('.modal_inform');
            $modal_close = $modal_contents.find('.modal_close');
            $videos = $modal_contents.find('iframe');

            sizeModal($videos);
            $modal_inform.css({
                'width': Math.round($videos.attr('width')) + 325,
                'height': Math.round($videos.attr('height')),
            });
            $('#vogos').before($modal_contents.html());

            $('.modal_back, .modal_close').on("click", function() {
                $('.modal_wrap').filter(':not(:animated)').animate({opacity:'hide'}, 250, function() {
                    $(this).remove();
                });
                $('.modal_back, .modal_close').fadeOut(250, function() {
                    $(this).remove();
                });
            }); // on.click END

        } // success END
    });
}

function sizeModal(videos) {  
    // 비디오 width, height 기본값
    var vW = 300;
    var vH = 420;
    var $winWidth = $(window).width();
    var $winHeight = $(window).height();

    // 비디오 비율 설정
    var opt = {
        ratioW : 1,
        ratioH : 1.4
    };

    var $divide = $winWidth * opt.ratioH;

    if ($divide > $winHeight) {
        vH = $winHeight * opt.ratioW;
        vW = vH / opt.ratioH;
    } else {
        vW = $winWidth * opt.ratioW;
        vH = vW * opt.ratioH;
    }
    if(vW > 450) {
        vW = 450;
        vH = 450 * 1.4;
    }
    videos.attr({
        width : vW,
        height : vH
    });
}