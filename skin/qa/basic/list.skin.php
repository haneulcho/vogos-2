<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;
//$bsze = (1000 - ($colspan-1)*45 ) - 95;
$bsze = 645;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/inlcude/bootstrap.css">', 0);
?>
<div id="sct" class="sct_wrap">
<div id="sod_title" class="rtap">
    <header class="fullWidth">
        <h2>1:1 Q &amp; A<span class="cart_item_num" style="width:170px"><i class="ion-heart"></i> <span style="font-size:13px;vertical-align:3px">무엇이든 물어보세요!</span></span></h2>
    </header>
</div>
<div class="fullWidth">
<div id="gbasic" style="width:1000px;margin:0 auto;padding:20px;">
<div id="bo_list">
    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
    <nav id="bo_cate">
        <h2><?php echo $qaconfig['qa_title'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <div class="bbs-list-top no-text">
        <span class="w45 fl"><span class="glyphicon glyphicon-map-marker" title="번호"></span><span class="text">번호</span></span>
        <?php if ($is_checkbox) { ?>
            <span class="w45 fl"><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></span>
        <?php } ?>
        <span class="fl" style="width:<?=$bsze?>px"><span class="text">제목</span></span>
        <span class="w80 fl"><span class="glyphicon glyphicon-user"></span><span class="text">글쓴이</span></span>
        <span class="w100 fl"><span class="glyphicon glyphicon-ok"></span><span class="text">상태</span></span>
        <span class="w45 fl"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?><span class="glyphicon glyphicon-time" title="날짜"></span><span class="text">등록일</span></a></span>
    </div>
    
<? $j=count($list);?>
    <div class="bbs-list">
        <ul>
            <? for ($i=0; $i<$j; $i++) {
            ?>
            <li<? if ($qa_id == $list[$i]['view_href']){?> class="ing"<?}?> ontouchend="document.location.href='<?=$list[$i]['view_href']?>'">
                    <span class="w45 num"><?php echo $list[$i]['num']; ?></span>
                     <? if ($is_checkbox) { ?><label class="w45" for="chk_qa_id_<?php echo $i ?>"><input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>" class="ychk"></label><?}?>

                    <p class="bls" style="width:<?=$bsze?>px">
                        <?if($list[$i]['category']){?>
                            <span class="cate">[<?php echo $list[$i]['category'] ?>]</span>
                        <?}?>
                        <a class="aline" href='<?=$list[$i]['view_href']?>'>
                        <?=$list[$i]['subject']?>
                        </a>
                    </p>

                    <p>
                        <span class="w80"><span class="glyphicon glyphicon-user"></span><?php echo $list[$i]['name']; ?></span>
                        <span class="w100 <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '<span class="glyphicon glyphicon-ok" style="display:inline-block"></span> 답변완료' : '<span class="glyphicon glyphicon-remove" style="display:inline-block"></span> 답변대기'); ?></span>
                        <span class="w45 date"><span class="glyphicon glyphicon-time ml5"></span> <?php echo $list[$i]['date']; ?></span>
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
    <?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn"><span class="glyphicon glyphicon-th-list"></span> 목록</a><?php } ?>
    <?php if ($is_checkbox) { ?>
            <button type="submit" class="btn_inp ml5" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><span class="glyphicon glyphicon-trash"></span> 선택삭제</button>
    <?php } ?>
    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <?php if ($admin_href || $write_href) { ?>
            <?php if($is_admin) { ?><?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="btn"><span class="glyphicon glyphicon-cog"></span> 관리자</a><?php } ?><?php } ?>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn"><span class="glyphicon glyphicon-pencil"></span> 1:1 문의등록</a><?php } ?>
        <?php } ?>
    </div>
    <!-- 게시판 페이지 정보 및 버튼 끝 { -->
</div>
<?}?>

    </form>
</div> <!-- gbasic END -->

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch" class="mt15">
    <legend>게시물 검색</legend>

    <form id="sch_frm" class="sfon" name="fsearch" method="get">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_inp fl" size="15" maxlength="15">
    <button type="submit" id="searchsubmit" class="btn_sch fl"><span class="glyphicon glyphicon-search"></button>
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
</div> <!-- fullWidth END -->
</div> <!-- sct END -->