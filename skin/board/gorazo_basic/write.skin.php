<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);

//$notag = array('free','feedback');
//if(!in_array($bo_table,$notag)) $tagon = 1;
?>
<div id="sct" class="sct_wrap">
<div id="sod_title" class="rtap">
    <header class="fullWidth">
        <h2>NOTICE &amp; EVENT<span class="cart_item_num" style="width:170px"><i class="ion-heart"></i></span></h2>
    </header>
</div>
<div class="fullWidth">

<section id="bo_w">
<form name="fwrite" id="wform" class="grz_frm" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<?php
$option = '';
$option_hidden = '';
if ($is_notice || $is_html || $is_secret || $is_mail) {
	$option = '';
	if ($is_notice) {
		$option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
	}

	if ($is_html) {
		if ($is_dhtml_editor) {
			$option_hidden .= '<input type="hidden" value="html1" name="html">';
		} else {
			//$option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
		}
	}

	if ($is_secret) {
		if ($is_admin || $is_secret==1) {
			$option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
		} else {
			$option_hidden .= '<input type="hidden" name="secret" value="secret">';
		}
	}

	if ($is_mail) {
		$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
	}
}

echo $option_hidden;
?>

	<div class="frm_hd">
		글쓰기
	</div>
	<div class="frm_ct">

		<?php if ($option) { ?>
		<div class="item">
			<label class="g_label" >옵션</label>
			<?php echo $option ?>
		</div>
		<?php }	?>

		<div class="item">
			<label class="g_label" >제목</label>
			<input name="wr_subject" id="wr_subject" value="<?php echo $subject ?>" required maxlength="255" class="g_text" />
		</div>

		<?php if ($is_category) { ?>
		<div class="item">		
			<label class="g_label" >카테고리</label>
			<select name="ca_name" id="ca_name" required class="required" >
				<option value="">선택하세요</option>
				<?php echo $category_option ?>
			</select>
		</div>
		<?}?>

		<?php if ($is_name) { ?>
		<div class="item">
			<label class="g_label" >이름</label>
			<input type="text" name="wr_name" id="wr_name" value="<?php echo $name ?>" required maxlength="20" class="g_text" />
		</div>
		<?php } ?>

		<?php if ($is_password) { ?>
		<div class="item">
			<label class="g_label" >비밀번호</label>
			<input type="password" name="wr_password" id="wr_password" required maxlength="20" class="g_text" />
		</div>
		<?php } ?>
		
		<?php if ($is_email) { ?>
		<div class="item dno">
			<label class="g_label">이메일</label>
			<input type="text" name="wr_email" id="wr_email" value="<?php echo $email ?>" maxlength="100" class="g_text" />
		</div>
		<?php } ?>

		<?php if ($is_homepage) { ?>
		<div class="item dno">
			<label class="g_label">홈페이지</label>
			<input type="text" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage ?>" maxlength="50" class="g_text" />
		</div>
		<?php } ?>

		<div class="item">
		<label class="g_label" >내용</label>
		<? if(!$is_dhtml_editor){?><label class="rlbl"><?}else{?><div class="dhtml"><?}?>
		<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
		<? if(!$is_dhtml_editor){?></label><?}else{?></div><?}?>
		<?php if($write_min || $write_max) { ?>
		<!-- 최소/최대 글자 수 사용 시 -->
		<div id="char_count_wrap"><span id="char_count"></span>글자</div>
		<?php } ?>
		</div>

		<div class="item">
			<label class="g_label">링크</label>
			<input type="text" name="wr_link1" id="wr_link1" value="<?php if($w=="u"){echo$write['wr_link1'];} ?>" maxlength="100" class="g_text"/>
		</div>

		<? if($tagon){?>
		<div class="item">
			<label class="g_label">태그</label>
			<input id="tag_inp" maxlength="100" class="g_text">

			<div id="g_tagbox">	</div>
			<input type="hidden" name="wr_1" id="wr_1" value="<?php echo $write['wr_1']?>" maxlength="100" class="g_text">
		</div>
		<?}?>
		
		<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
		<div class="item">
			<label class="g_label">파일</label>
			<input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능">
			<?php if ($is_file_content) { ?>
			<input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input" size="50">
			<?php } ?>
			<?php if($w == 'u' && $file[$i]['file']) { ?>
			<input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
			<?php } ?>
		</div>
	   <?php } ?>

		<?php if ($is_guest) { //자동등록방지  ?>
		<div class="item">
			<label class="g_label">자동등록방지</label>
			<?php echo $captcha_html ?>
		</div>
		<?php } ?>
	</div>
	<div class="frm_tl">
		<input type="submit" class="submit" accesskey="s" value="확인 (Alt+s)" />
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn ml5">취소</a>
	</div>
</form>

<script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
	
<? if($tagon){?>
$( document ).ready(function() {
	$("#tag_inp").keypress(function(e) {
		if(e.which == 13 || e.which == 44) {
			tag_chk();			
			return false;
		}
	}).focusout(function(e){
			tag_chk();
	});

	function tag_chk(){
		var inp = $("#tag_inp");
		var inpv = $("#tag_inp").val();
		var iparr = inpv.split(",");
		var isz = iparr.length;

		for(var a = 0;a<isz;a++){
			var garr = new Array();
			var act = 0;
			inpv = iparr[a].trim();
			if(inpv != ""){
				var j = $("#g_tagbox div.gtag").length;
				if(j > 0){
					for(var i=0;i<j;i++){
						var hh = $("#g_tagbox div.gtag a.gt_name").eq(i).html();
						if(garr.indexOf(hh) == -1) garr.push(hh);
					}			
				}
				if(garr.indexOf(inpv) != -1) act = 1;
				else garr.push(inpv);

				var txt = '<div class="gtag"><a class="gt_name">'+inpv+'</a><a class="cls">&times;</a></div>';
				if(act == 0) $("#g_tagbox").append(txt);
				$("#tag_inp").val("");
				$("#wr_1").val(garr);
			}
		}

		return false;
	}

	$("#g_tagbox .gtag .cls" ).live("click", function() {
		$(this).parent().remove();

		var garr = new Array();
		var j = $("#g_tagbox div.gtag").length;
		for(var i=0;i<j;i++){
			var hh = $("#g_tagbox div.gtag a.gt_name").eq(i).html();
			garr.push(hh);
		}			

		$("#wr_1").val(garr);
	});

	$("#g_tagbox .gtag .gt_name" ).live(" dblclick", function() {
		var hh = $(this).html();
		$("#tag_inp").val(hh);
		$(this).parent().remove();
	});

	var wr_1 = '<?=$write[wr_1]?>';
	if(wr_1 != ''){
		var warr = wr_1.split(",");
		
		for(var i=0;i<warr.length;i++){
			var txt = '<div class="gtag"><a class="gt_name">'+warr[i]+'</a><a class="cls">&times;</a></div>';
			$("#g_tagbox").append(txt);
		}
	}
});
<?}?>
    </script>
</div></div>