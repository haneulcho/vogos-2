<?php
if (!defined('_GNUBOARD_')) exit;

$colspan = 5;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
$bsze = (1000 - ($colspan-1)*45 ) - 80;

// 1000 값을 잘모르겠으면 아래 스크립트를 웹 브라우져 주소창에 적어 주세요.
//javascript:alert($(".pbox").width()+12);
//잘 모르겠으면 

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/inlcude/bootstrap.css">', 0);
?>
<div id="sct" class="sct_wrap">
<div id="sod_title" class="rtap">
    <header class="fullWidth">
        <h2>NOTICE &amp; EVENT<span class="cart_item_num" style="width:170px"><i class="ion-heart"></i></span></h2>
    </header>
</div>
<div class="fullWidth">
<!-- 게시판 목록 시작 { -->
<div id="gbasic" style="width:1000px;margin:0 auto;padding:20px;">

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
	<div class="pbox">
		<?php echo $category_option ?>
    </div>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <?php if($is_admin) { ?>
    <div class="bo_fx">
        <?php if ($rss_href || $write_href) { ?>
            <?php if ($rss_href) { ?><a href="<?php echo $rss_href ?>" class="btn">RSS</a><?php } ?>
            <?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="btn"><span class="glyphicon glyphicon-cog"></span> 관리자</a><?php } ?>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a><?php } ?>
        <?php } ?>
    </div>
    <?php } ?>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

	<div class="bbs-list-top no-text">
		<span class="w45 fl"><span class="glyphicon glyphicon-map-marker" title="번호"></span><span class="text">번호</span></span>
		<?php if ($is_checkbox) { ?>
			<span class="w45 fl"><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></span>
		<?php } ?>
		<span class="fl" style="width:<?=$bsze?>px"><span class="text">제목</span></span>
		<span class="w100 fl"><span class="glyphicon glyphicon-user"></span><span class="text">글쓴이</span></span>
		<span class="w45 fl"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?><span class="glyphicon glyphicon-time" title="날짜"></span><span class="text">날짜</span></a></span>
		<span class="w45 fl"><span class="glyphicon glyphicon-eye-open" title="조회수"></span></span>
		<? if ($is_good){?><span class="w45 fl"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?><span class="glyphicon glyphicon-thumbs-up" title="추천"></span><span class="text">추천</span></a></span><?}?>
		<? if ($is_nogood){?><span class="w45 fl"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?><span class="glyphicon glyphicon-thumbs-down" title="비추천"></span><span class="text">비추천</span></a></span><?}?>
	</div>
	
<? $j=count($list);?>
	<div class="bbs-list">
		<ul>
			<? for ($i=0; $i<$j; $i++) {
			?>
			<li<? if ($wr_id == $list[$i]['wr_id']){?> class="ing"<?}?> ontouchend="document.location.href='<?=$list[$i]['href']?>'">
					<span class="w45 num"><? if ($list[$i]['is_notice']){?><strong>공지</strong><?}else{?><?=$list[$i]['num']?><?}?></span>
					 <? if ($is_checkbox) { ?><label class="w45" for="chk_wr_id_<?php echo $i ?>"><input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="ychk"></label><?}?>
					<p class="bls" style="width:<?=$bsze?>px">
					<?=$list[$i]['icon_reply']?>
                    <?if($is_category && $list[$i]['ca_name']){?>
						<span class="cate">[<?php echo $list[$i]['ca_name'] ?>]</span>
					<?}?>
					<a class="aline" href='<?=$list[$i]['href']?>'>
					<?=$list[$i]['subject']?>
					<?php if ($list[$i]['comment_cnt']) { ?><span class="cn"><?=$list[$i]['wr_comment']?></span><?php } ?>
					</a>
					<? if($list[$i]['icon_new']){?><?=$list[$i]['icon_new']?><?}?>
					<? if ($board['bo_hot'] && $list[$i]['wr_hit'] >= $board['bo_hot']){?><span class="glyphicon glyphicon-heart gon" title="조회수 <?=$board['bo_hot']?> 이상의 게시물 입니다."></span><?}?>
					<? if($list[$i]['icon_file']){?><span class="glyphicon glyphicon-floppy-disk gon" title="첨부파일이 있습니다."></span><?}?>
					<? if($list[$i]['icon_link']) {?><span class="glyphicon glyphicon-link gon" title="링크가 있습니다."></span><?}?>
					<? if($list[$i]['icon_secret']){?><?=$list[$i]['icon_secret']?><?}?>
					</p>
					<p>
						<span class="w100 <? if($board['bo_use_sideview']){?>snon<?}?>"><span class="glyphicon glyphicon-user"></span> <? if($board['bo_use_sideview']){?><span class="sname"><?=$list[$i]['name']?></span><?}?><span class="pname">VOGOS</span></span>
						<span class="w45 date"><span class="glyphicon glyphicon-time ml5"></span> <?=$list[$i]['datetime2']?></span>
						<span class="w45 hit"><span class="glyphicon glyphicon-eye-open ml5"></span> <?=$list[$i]['wr_hit']?></span>
						<?php if ($is_good) { ?><span class="w45 hit gdtxt"><span class="glyphicon glyphicon-thumbs-up ml5"></span> <?php echo $list[$i]['wr_good'] ?></span><?php } ?>
						<?php if ($is_nogood) { ?><span class="w45 hit"><span class="glyphicon glyphicon-thumbs-down ml5"></span> <?php echo $list[$i]['wr_nogood'] ?></span><?php } ?>
					</p>
			</li>
			<?}?>
			<? if($j ==0){?>
				<div class="nitm">
					검색 결과가 없습니다.
				</div>
			<?}?>
		</ul>
	</div>

<!-- 페이지 -->
<?php if ($list_href || $is_checkbox || $write_href) { ?>
<div class="ps_wrap mt20">
	<? if($write_href){?><a href="<?=$write_href?>" class="btn bf"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a><?}?>
	<?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn bf ml15">목록</a><?php } ?>
	<?php if ($is_checkbox) { ?>
			<button type="submit" class="btn_inp ml5" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><span class="glyphicon glyphicon-trash"></span> 선택삭제</button>
			<button type="submit" class="btn_inp ml5" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><span class="glyphicon glyphicon-file"></span> 선택복사</button>
			<button type="submit" class="btn_inp ml5" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><span class="glyphicon glyphicon-move"></span> 선택이동</button>
	<?php } ?>
</div>
<?}?>

    </form>
</div>


		<?=$write_pages?>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>


<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch" class="mt15">
    <form id="sch_frm" class="sfon" name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl" class="fl">
		<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
		<!--
		<option value="wr_1"<?php echo get_selected($sfl, 'wr_1'); ?>>태그</option>
		<option value="wr_subject||wr_1"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+태그</option>
		<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
		-->
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>

    </select>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_inp fl" size="15" maxlength="15">
	<button type="submit" id="searchsubmit" class="btn_sch fl"><span class="glyphicon glyphicon-search"></button>
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
</div></div>
