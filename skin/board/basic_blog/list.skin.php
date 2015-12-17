<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 1;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<!--h2 id="container_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2-->

<!-- 게시판 타이틀 시작 -->
<div id="sod_title" class="mif">
    <header class="fullWidth">
        <h2><?php echo $board['bo_subject'] ?><span class="cart_item_num" style="width:170px"><i class="ion-heart"></i> Celebrity's Choice</a></span></h2>
    </header>
</div>
<!-- 게시판 목록 시작 { -->
<div id="sct" class="sct_wrap">
<div class="fullWidth">
<div id="bo_list" style="width:<?php echo $width; ?>">

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <div id="bo_list_total">
            <?php if ($is_admin) { ?><span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지<?php } ?>
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_wrap">
        <table>
        <!--thead>
			<tr>
				<th scope="col" class="th2" colspan=<?php echo $colspan2 ?>>
				<?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜순</a>
				| <?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회순</a>
				<?php if ($is_good) { ?> | <?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천순</a><?php } ?>
				<?php if ($is_nogood) { ?> | <?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천순</a><?php } ?>
			</tr>
        </thead-->
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
         ?>
			<tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?><?php if ($board[1]) echo "bo_sideview"; ?>">
				<!--td class="td_num">
				<?php
				if ($list[$i]['is_notice']) // 공지사항
					echo '<strong>공지</strong>';
				else if ($wr_id == $list[$i]['wr_id'])
					echo "<span class=\"bo_current\">열람중</span>";
				else
					echo $list[$i]['num'];
				 ?>
				</td-->
				<td class="td_subject" colspan=<?php echo $colspan2; ?> valign="top"<?php if ($is_admin) { ?><?php } else { ?> style="border-bottom:0;"<?php } ?>>
					<?php
					echo $list[$i]['icon_reply'];
					if ($is_category && $list[$i]['ca_name']) {
					 ?>
					<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
					<?php } ?>

					<!-- 본문리스트 추가부분 시작 { -->
					<article id="bo_v">
						<header>
					<?php if ($is_admin) {?>
						<h1 id="bo_v_title">
							<a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject'] ?></a>
						</h1>
					<?php } else { ?>
						<h1 id="bo_v_title">
						<span><?php if ($category_name) echo $list[$i]['ca_name'].' | '; // 분류 출력 끝
							echo cut_str(get_text($list[$i]['wr_subject']), 70); // 글제목 출력
						 ?></span>
						</h1>
					<?php } ?>
						</header>
						<section id="bo_v_info">
							<h2>페이지 정보</h2>
                            <!-- 
							작성자 <strong><?php //echo $list[$i]['wr_name'] ?><?php //if ($is_ip_view) { echo "&nbsp;(".$list[$i]['wr_ip'].")"; } ?></strong>
                            -->
                            <?php if ($is_checkbox) { ?>
                                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                            <?php } ?>
                            <span class="sound_only">작성일</span><strong><?php echo date("ymd", strtotime($list[$i]['wr_datetime'])) ?></strong>
							<!--
							조회<strong><?php echo number_format($list[$i]['wr_hit']) ?>회</strong>
							댓글<strong><?php echo number_format($list[$i]['wr_comment']) ?>건</strong>
							-->
						</section>
						<section id="bo_v_atc">
							<h2 id="bo_v_atc_title">본문</h2>
							<?php // 파일출력
							$v_img_count = count($list[$i]['file']);
							if($v_img_count) {
								//echo "<div id=\"bo_v_img\">\n";
								for ($i2=0; $i2<=count($list[$i]['file']); $i2++) {
									if ($list[$i]['file'][$i2]['view']) {
										//echo $view['file'][$i]['view'];
										echo get_view_thumbnail($list[$i]['file'][$i2]['view']);
									}
								}
								//echo "</div>\n";
							}
							 ?>
							<!-- 본문 내용 시작 { -->
							<div id="bo_v_con"><?php echo get_view_thumbnail($list[$i]['wr_content']); ?></div>
							<?php echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
							<!-- } 본문 내용 끝 -->
							<?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>
                            <?php if ($is_admin) { ?>
                            <a href="<?php echo G5_BBS_URL ?>/write.php?w=u&bo_table=<?php echo $bo_table ?>&wr_id=<?php echo $list[$i]['wr_id'] ?>&page=<?php echo $page ?>">[수정]</a>
                            <a href="<?php echo G5_BBS_URL ?>/delete.php?w=d&bo_table=<?php echo $bo_table ?>&wr_id=<?php echo $list[$i]['wr_id'] ?>&page=<?php echo $page ?>" onclick="del(this.href); return false;">[삭제]</a>
                            <?php } ?>
						</section>
					</article>
					<!-- } 본문리스트 추가부분 끝 -->
					<?php } ?>
<div id="bo_footer">
<!-- 게시판 검색 시작 {
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php //echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php //echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php //echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php //echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php //echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only">필수</strong></label>
    <input type="text" name="stx" value="<?php //echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="20">
    <input type="submit" value="검색" class="btn_submit">
    </form>
</fieldset>
} 게시판 검색 끝 -->
<!-- 페이지 -->
<?php echo $write_pages;  ?>
</div>
				</td>
			</tr>
			<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm">
			<li class="btn_chk"><label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
			<input type="checkbox" id="chkall" value="Check" onclick="if (this.checked) all_checked(true); else all_checked(false);"></li>
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" /></li>
            <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" /></li>
            <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" /></li>
        </ul>
        <?php } ?>

        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

</div></div>

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