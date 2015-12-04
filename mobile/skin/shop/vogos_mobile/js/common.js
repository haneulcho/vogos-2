// #ft_totop 클릭하면 최상단으로 이동
$(function(){
    $('#ft_totop').click(function(e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
    });

    $('body').find('#hamburger').click(function() {
        if($(this).hasClass('open')){ // sideNav 이미 열려있을 때
            sideNav('close'); // sideNav를 닫는다
        } else {
            sideNav('open');
        }
    });

    function sideNav(status) {
        var $btnHamburger = $('body').find('#hamburger i');
        var iconOpen = 'ion-navicon';
        var iconClose = 'ion-android-close';
        if(status == 'open') { // sideNav를 연다 status = open
            $btnHamburger.removeClass(iconOpen).addClass(iconClose);
            $('#sct_win, #main, #hamburger, #hd').addClass(status);
            $('html, body').css({
                'overflow-x' : 'hidden',
                'height' : '100%'
            });
            touchNav(true); // 터치 메소드 실행
        } else { // sideNav를 닫는다
            $btnHamburger.addClass(iconOpen).removeClass(iconClose);
            $('#sct_win, #main, #hamburger, #hd').removeClass('open');
            $('html, body').css({
                'overflow-x' : '',
                'height' : 'auto'
            });
            touchNav(false); // 터치 메소드 해제
        }
    }; // sideNav END

    function touchNav(flag) {
        var $container = $('body').find('#main');
        if(flag) {
            $container.bind('touchstart', function(event) {
                event.preventDefault();
                var e = event.originalEvent;
                startX = e.targetTouches[0].pageX;
            }).bind('touchmove', function(event) {
                event.preventDefault();
                var e = event.originalEvent;
                moveX = e.targetTouches[0].pageX;
                movePosition = startX - moveX;
                if(movePosition > 0 && movePosition < 180) {
                    $(this).css({
                        'z-index': 3,
                        'left': - movePosition + 'px'
                    });
                    flag = false;
                }
            }).bind('touchend touchcancel', function(event) {
                if(!flag) {
                    $(this).animate({'left': '', 'z-index': 1}, 300);
                    sideNav('close');
                }
            });
        } else {
            $container.unbind('touchstart')
            .unbind('touchmove')
            .unbind('touchend');
        }
    } // touchNav END

});