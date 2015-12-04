$(function(){
// #ft_totop 클릭하면 최상단으로 이동
$('#ft_totop').click(function(e) {
	e.preventDefault();
	$("html, body").animate({
		scrollTop: 0
	}, 600);
});
// 스크롤 내리면 상단 메뉴 fixed 되도록
function scrollNav(){
	var timer;
	var header = $('body').find('#header');

	var navPosition = header.offset().top;
	$(window).scroll(function() {
		var wPosition = $(window).scrollTop();
		if(timer) { clearTimeout(timer); }
		timer = setTimeout(function() {
			if(navPosition < wPosition) {
				if(!header.hasClass('scrolled')){
					header.addClass('scrolled');
					$('body').addClass('scrolled');
				}
			}
			if(220 > wPosition) {
				header.removeClass('scrolled');
				$('body').removeClass('scrolled');
			}
		}, 100);
	}); // scroll function END
}; // scrollNav END
scrollNav();

});