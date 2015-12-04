//리스트 정렬
(function($) {
    var li = $('.sct_20 .sct_li');
    var win_width = $(window).width();
    if(win_width>1023) { var lic = 1024 }
        else if(win_width>767) { var lic = 768 }
        else if(win_width>639) { var lic = 640 }
        else if(win_width>479) { var lic = 480 }
        else if(win_width>359) { var lic = 360 }
        else { var lic = 340 }
    var lic = 'lic2'+lic;
    li.addClass(lic);
}(jQuery));

function view_video(vid) {
    $.ajax({
        type: 'POST',
        data: {'it_id': vid},
        url: $G5_MSHOP_SKIN_URL + "/video.form.skin.php",
        success: function(data) {
            // success function 불러오기
            $modal_contents = $(data).filter('.modal_contents');
            $modal_wrap = $modal_contents.find('.modal_wrap');
            $modal_video = $modal_contents.find('.modal_video');
            $modal_close = $modal_contents.find('.modal_close');
            $videos = $modal_contents.find('iframe');

            sizeModal($videos);
            $modal_close.css('margin-top', $modal_close_position);
            $('#main').before($modal_contents.html());

            $('.modal_wrap, .modal_close').on("click", function() {
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
        ratioW : 0.8,
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
    videos.attr({
        width : vW,
        height : vH
    });

    if($winHeight < 660) {
        $modal_close_position = 20;
    } else {
        $modal_close_position = Math.round(($winHeight - vH) / 2 - 80);
    }
    $modal_close_position += 'px';
    return $modal_close_position;
}