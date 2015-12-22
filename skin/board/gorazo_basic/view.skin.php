<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/inlcude/bootstrap.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="sct" class="sct_wrap">
<div id="sod_title" class="rtap">
    <header class="fullWidth">
        <h2>NOTICE &amp; EVENT<span class="cart_item_num" style="width:170px"><i class="ion-heart"></i></span></h2>
    </header>
</div>
<div class="fullWidth">
<!-- 게시물 읽기 시작 { -->
<article id="bo_v">
    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_navi">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <div class="bo_left">
            <?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>" class="btn bf">이전글</a><?php } ?>
            <?php if ($next_href) { ?><a href="<?php echo $next_href ?>" class="btn bf">다음글</a><?php } ?> 
        </div>
        <?php } ?>

        <div class="bo_right">
            <?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="btn bf"><span class="glyphicon glyphicon-edit"></span> 수정</a><?php } ?>
            <?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="btn bf" onclick="del(this.href); return false;"><span class="glyphicon glyphicon-trash"></span> 삭제</a><?php } ?>
            <?php if ($copy_href) { ?><a href="<?php echo $copy_href ?>" class="btn bf" onclick="board_move(this.href); return false;"><span class="glyphicon glyphicon-file"></span> 복사</a><?php } ?>
            <?php if ($move_href) { ?><a href="<?php echo $move_href ?>" class="btn bf" onclick="board_move(this.href); return false;"><span class="glyphicon glyphicon-move"></span> 이동</a><?php } ?>
            <?php if ($search_href) { ?><a href="<?php echo $search_href ?>" class="btn bf">검색</a><?php } ?>
            <a href="<?php echo $list_href ?>" class="btn bf"><span class="glyphicon glyphicon-list-alt"></span> 목록</a>
            <?php if ($reply_href) { ?><a href="<?php echo $reply_href ?>" class="btn bf"><span class="glyphicon glyphicon-share-alt"></span> 답변</a><?php } ?>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn bf"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a><?php } ?>
        </div>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

	<div id="bo_v_sub">
		<header>
			<h1 id="bo_v_title">
				<?=cut_str(get_text($view['wr_subject']), 70); // 글제목 출력?>
			</h1>
		</header>
	</div>

    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
    ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <div id="bo_v_file">
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
                <a href="<?=$view['file'][$i]['href']?>" class="bo_v_ect">
                    <span class="glyphicon glyphicon-save"></span>
                    <?php echo $view['file'][$i]['source'] ?>
                    <?php echo $view['file'][$i]['bf_content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
					<span class="cn"><?php echo $view['file'][$i]['download'] ?></span>
                </a>
        <?php
            }
        }
         ?>
    </div>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if (implode('', $view['link'])) {
     ?>
     <!-- 관련링크 시작 { -->
	<? if($bo_table != 'play'){?>
		<div id="bo_v_link">
			<?php
			// 링크
			$cnt = 0;
			for ($i=1; $i<=count($view['link']); $i++) {
				if ($view['link'][$i]) {
					$cnt++;
					$link = cut_str($view['link'][$i], 70);
			 ?>
					<a class="bo_v_ect" href="<?php echo $view['link_href'][$i] ?>" target="_blank">
						<span class="glyphicon glyphicon-link"></span>
						<?=$link?>
						<span class="cn"><?php echo $view['link_hit'][$i] ?></span>
					</a>
			<?php
				}
			}
			 ?>
		</div>
	<?}?>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <section id="bo_v_atc">
        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }

		 if($bo_table == 'play'){
			 $getyt = parse_url($view['link'][1],PHP_URL_QUERY);
			 parse_str($getyt, $getytv);

			 if(!$getytv['v']){
				if(strpos($view['link'][1],'youtu') >= 0){
					$pat = parse_url($view['link'][1],PHP_URL_PATH);
					$getytv['v'] = substr($pat,1);
				}
			 }
		 }
         ?>
		
        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con">
        <section id="bo_v_info">
            <span class="glyphicon glyphicon-user"></span>VOGOS <?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?>
            <? if ($category_name){?><span class="glyphicon glyphicon-bookmark ml5"></span> <?=$view['ca_name']?> <?}?>
            <span class="glyphicon glyphicon-time ml5"></span> <?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?>
            <span class="glyphicon glyphicon-eye-open ml5"></span> <?php echo number_format($view['wr_hit']) ?>
        </section>
        <?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

		<? if($view['wr_1']){?>
			<p id="tags"><span class="glyphicon glyphicon-tag" ></span> 
				<span id="tagl"><?=$view['wr_1']?></span>
			</p>
		<?}?>
        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>
    </section>

	<? if($bo_table == 'qna' && $view['ca_name'] != '해결'){?>
		<a id="qna_an" style="display:block;background:#fff;border:1px solid #ccc;width:auto;padding:15px;margin:15px 0;text-align:center;cursor:pointer" onclick="qna_com(<?=$wr_id?>)"><span class="glyphicon glyphicon-ok"></span> 질문 해결</a>
	<?}?>
	
    <?
    include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?>

    <?php
    include_once('./view_comment.php');
     ?>

    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot" style="margin:20px 0">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}

function qna_com(no){
	if(do_submit){
		alert("이미 진행 중 입니다.");
		return;
	}
	
	du_submit = true;
	$.ajaxSetup({ scriptCharset: "utf-8" ,contentType: "application/x-www-form-urlencoded; charset=UTF-8" });
	$.ajax({
			type: "post",
			url: "../include/qna_up.php",
			data:
				{
					no:no
				},
			dataType : "html",
			success: function(res) {
					if(res == "ok"){
						//location.reload();
						alert('질문이 해결 되었습니다.');
						$("#qna_an").remove();
					}else if(res == 'err1'){
						alert('본인이 아닙니다');
					}else{
						alert(res);
					}
					du_submit = false;
		}
	});
}

<? if($view['wr_1']){?>
$( document ).ready(function() {
	var tagl = $("span#tagl");
	var tagl_text = tagl.text();

	var tarr = new Array();
	tarr = tagl_text.split(",")
	var tcnt = tarr.length;

	var thtml = '';
	for(var i = 0;i<tcnt;i++){
		thtml += '<a href="./board.php?bo_table=<?=$bo_table?>&sca=&sop=and&sfl=wr_1&stx='+tarr[i]+'">'+tarr[i]+'</a>';
	}
	tagl.html(thtml);
	
});
<?}?>
</script>
<!-- } 게시글 읽기 끝 -->
</div></div>