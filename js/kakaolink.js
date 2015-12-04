function shareToApp(types, text, url, img_url) {
	// 카카오톡 링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
	var sh_name = '[VOGOS(보고스)]';
	var sh_site = 'http://vogos.com';
	var sh_title = text;
	var sh_url = url;
	var sh_img_url = img_url;
	var sh_img_width = 150;
	var sh_img_height = 180;
	var sh_msg = encodeURIComponent(sh_name + "\r\n" + sh_title + "\r\n");

	switch(types) {
		case "kakaotalk" :
			Kakao.Link.sendTalkLink({
				label: sh_name + "\n" + sh_title + "\n" + sh_url,
				image: { src: sh_img_url, width: sh_img_width, height: sh_img_height },
				webButton: { text: sh_name + "바로가기", url: sh_site }
			});
		break;
		case "kakaostory" :
			Kakao.Story.share({
				url: sh_url
			});
		break;
		case "naverline" :
			var options = {
				Param: "msg/text/" + sh_msg + sh_url,
				Scheme: "line",
				Package: "jp.naver.line.android",
				Appstore: "itms-apps://itunes.apple.com/app/id443904275"
			};
			openToApp(options);
		break;
		case "naverband" :
			var options = {
				Param: "create/post?text=" + sh_msg + sh_url + "&route=" + sh_url,
				Scheme: "bandapp",
				Package: "com.nhn.android.band",
				Appstore: "itms-apps://itunes.apple.com/app/id542613198"
			};
			openToApp(options);
		break;
	}
} // shareToApp END
function openToApp(options) {
	if(navigator.userAgent.match(/android/i)) {
		setTimeout(function(){ location.href = "intent://" + options.Param + "#Intent;scheme=" + options.Scheme + ";package=" + options.Package + ";end"}, 100);
	} else if(navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i)) {
		setTimeout(function(){ location.href = options.Appstore; }, 200);
		setTimeout(function(){ location.href = options.Scheme + "://" + options.Param }, 100);
	} else {
		alert('모바일 환경에서만 공유하실 수 있습니다.');
	}
} // openToApp END