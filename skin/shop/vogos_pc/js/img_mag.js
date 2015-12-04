$(function(){
	var opt = {
		smallSrc : sSrc,
		smallWidth : Number(sWidth),
		smallHeight : Number(sHeight),
		
		bigSrc : bSrc,
		bigWidth : Number(bWidth),
		bigHeight : Number(bHeight)
	};

	var oWin = $(window);
	var owraper = $("#sit_pvi_img");
	var oSmall = $("#sit_pvi_small");
	var oBig = $("#sit_pvi_big");
	var obg = $("#bg");
	var oMask = $("#mask");
	
	var oBigImg = null;
	var oBigImgWidth = opt.bigWidth;
	var oBigImgHeight = opt.bigHeight;
	
	var iBwidth = oBig.width();
	var iBheight = oBig.height();
	
	oBig.css("display", "none");

	var owrapperOffset = owraper.offset();
	var iTop = owrapperOffset.top;
	var iLeft = owrapperOffset.left;
	var iWidth = opt.smallWidth;
	var iHeight = opt.smallHeight;
	//var iWidth = owraper.width();
	//var iHeight = owraper.height();
	var iSpeed = 200;
	
	var setOpa = function( o )
	{
		o.css({
			opacity : 0,
			filter : 'alpha(opacity=0)'
		});
		return o;
	};

	var imgs = function( opt )
	{
		if( jQuery.type( opt ) !== "object" ) return false;

		var oBig = $(new Image());
		oBig.attr({
			'src' : opt.bigSrc,
			'width' : opt.bigWidth,
			'height' : opt.bigHeight
		});
		
		var oSmall = $(new Image());
		oSmall.attr({
			'src' : opt.smallSrc,
			'width' : opt.smallWidth,
			'height' : opt.smallHeight
		});
		
		oBigImg = oBig;
		
		return {
			bigImg : setOpa( oBig ),
			smallImg : setOpa( oSmall )
		};
	};
	
	var append = function( o, img )
	{
		o.append( img );
		
		$(img).animate({opacity: 1},
			iSpeed*2, null, function() {
				$(this).css = ({
					opacity : '',
					filter : ''
				});
			});
	};
	
	var eventMove = function( e )
	{
		var e = e || window.event;
		
		var w = oMask.width();
		var h = oMask.height();
		var x = e.clientX - iLeft + oWin.scrollLeft() - w/2;
		var y = e.clientY - iTop + oWin.scrollTop() - h/2;

		var l = iWidth - w - 2;
		var t = iHeight - h - 2;

		if( x < 0 )
		{
			x = 0;	
		}
		else if( x > l )
		{
			x = l;
		};
		
		if( y < 0 )
		{
			y = 0;	
		}
		else if( y > t )
		{
			y = t;
		};

		oMask.css(
		{
			left : x < 0 ? 0 : x > l ? l : x,
			top : y < 0 ? 0 : y > t ? t : y
		});
		
		var bigX = x / ( iWidth - w );
		var bigY = y / ( iHeight - h );
		
		oBigImg.css(
		{
			left : bigX * ( iBwidth - oBigImgWidth ),
			top : bigY * ( iBheight - oBigImgHeight )
		});

		return false;
	};
	
	var eventOver = function()
	{
		oMask.show();
		obg.stop()
			.animate(
			{
				opacity : .1
			}, iSpeed );
		oBig.show()
			.stop()
			.animate(
			{
				opacity : 1	
			}, iSpeed/2 );
		
		return false;
	};
	
	var eventOut = function()
	{
		oMask.hide();
		obg.stop()
			.animate(
			{
				opacity : 0
			}, iSpeed/2);
			
		oBig.stop()
			.animate(
			{
				opacity : 0
			}, iSpeed, null, function()
			{
				$(this).hide();
			});
		
		return false;
	};
	
	var _init = function( object, oB, oS, callback ){
		var num = 0;
		
		oBig.css("opacity", 0);
		
		append( oB, object.bigImg );
		append( oS, object.smallImg );
		
		object.bigImg.onload = function()
		{
			num += 1;
			
			if( num === 2 )
			{ 
				callback.call( object.smallImg );
			};
		};
		
		object.smallImg.onload = function()
		{
			num += 1;
			
			if( num === 2 )
			{ 
				callback.call( object.smallImg );
			};
		};
	};
	
	_init( imgs( opt ), oBig, oSmall, function()
	{
		oWin.resize(function(){
			iTop = owraper.top();
			iLeft = owraper.left();
			// iWidth = owraper.width();
			// iHeight = owraper.height();
			iWidth = opt.smallWidth;
			iHeight = opt.smallHeight;
		});
		oSmall.hover( eventOver, eventOut )
			  .mousemove( eventMove );
	});
		oSmall.hover( eventOver, eventOut )
			  .mousemove( eventMove );
});

function showModal(flag) {
  if(flag) {
  	var $btn_video = $('#sit_pvi_video_btn');
  	var $modal_info = $('#sit_pvi_video_btn + .modal_info');
  	var $modal_wrap = $modal_info.children('#sit_pvi_video');
  	var $videos = $('#sit_pvi_video > video');

  	sizeModal($videos);

    $modal_layer = "<div class=\"modal_video\"></div>";
    $modal_close = "<div class=\"modal_close\" style=\"margin-top:"+ $modal_close_position +"\"></div>";

    $btn_video.after($modal_layer);
    $modal_wrap.append($modal_close);

    $modal_info.filter(':not(:animated)').animate({opacity:'show'}, 250);
    $videos.get(0).play();

    $('.modal_info, .modal_close').live("click", function() {
			$modal_info.filter(':not(:animated)').animate({opacity:'hide'}, 250);
			$videos.get(0).pause();
      $('.modal_video, .modal_close').fadeOut(250, function() {
        $(this).remove();
      });
    }); // live.click END
  } // if END
} // flag END

function sizeModal(videos) {
	// 비디오 width, height 기본값
	var vW = 300;
	var vH = 420;
	var	$winWidth = $(window).width();
	var $winHeight = $(window).height();

	// 비디오 비율 설정
	var opt = {
		ratioW : 0.6,
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
	})

	$modal_close_position = Math.round(($winHeight - vH) / 2 - 80);
	$modal_close_position += 'px';
	console.log($modal_close_position);
	return $modal_close_position;

}