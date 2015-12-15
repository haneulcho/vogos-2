<?php
$sub_menu = '400600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '사입처관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

/*
검색분류 = sca -> ddm_part = 의류, ACC, 신발
검색대상 = sfl -> ddm_name, ddm_place1, ddm_place2, ddm_tel
        LIKE sfl = '%stx%'
검색어 = stx
*/

$sql_search = "";

// 검색분류가 있으면
if ($sca != "") {
    $sql_search .= " where ddm_part = '$sca'";
    // 검색어가 있으면
    if ($stx != "") {
        // 검색대상이 있으면
        if ($sfl != "") {
            $sql_search .= " and $sfl like '%$stx%' ";
        }
        if ($save_stx != $stx)
            $page = 1;
    }    
} else {
    // 검색어가 있으면
    if ($stx != "") {
        // 검색대상이 있으면
        if ($sfl != "") {
            $sql_search .= " where $sfl like '%$stx%' ";
        }
        if ($save_stx != $stx)
            $page = 1;
    }
}

// 검색대상이 없을 경우
if ($sfl == "") {
    $sfl = "ddm_name";
}

$sql_common = " from {$g5['g5_shop_ddmaddress_table']}";
$sql_common .= $sql_search;

// 등록된, 검색된 구분
if ($sca != "" || $stx != "") {
    $ddmtitle = '검색된';
} else {
    $ddmtitle = '등록된';
}

///////////////////////////////////////////////////// 검색 로직 끝

/*
정렬타겟 = sst (ddm_part, ddm_place1, ddm_place2, ddm_name, ddm_tel)
정렬기준 = sod (asc, desc)
*/

if (!$sst) {
    $sst  = "ddm_name";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

///////////////////////////////////////////////////// 정렬 로직 끝


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select * $sql_common $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;
$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    <?php echo $ddmtitle; ?> 사입처 <?php echo $total_count; ?>건
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
        echo '<option value="의류" '.get_selected($sca, '의류').'>'.$nbsp.'의류</option>'.PHP_EOL;
        echo '<option value="ACC" '.get_selected($sca, 'ACC').'>'.$nbsp.'ACC</option>'.PHP_EOL;
        echo '<option value="신발" '.get_selected($sca, '신발').'>'.$nbsp.'신발</option>'.PHP_EOL;
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="ddm_name" <?php echo get_selected($sfl, 'ddm_name'); ?>>사입처명</option>
    <option value="ddm_place1" <?php echo get_selected($sfl, 'ddm_place1'); ?>>사입처 구분(디오트, 청평화, ...)</option>
    <option value="ddm_place2" <?php echo get_selected($sfl, 'ddm_place2'); ?>>사입처 위치(디1e4, 청2ab2, ...)</option>
    <option value="ddm_tel" <?php echo get_selected($sfl, 'ddm_tel'); ?>>사입처 전화번호</option>
</select>

<label for="stx" class="sound_only">검색어</label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input" style="width:240px">
<input type="submit" value="검색" class="btn_submit">

</form>

<div class="btn_add01 btn_add">
    <a href="./ddmaddressform.php">사입처 등록(개발중 누르지 마시오)</a>
</div>

<form name="fitemlistupdate" method="post" action="./itemlistupdate.php" onsubmit="return fitemlist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">사입처 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('ddm_part', 'sca='.$sca); ?>주 판매품목 분류</a></th>        
        <th scope="col"><?php echo subject_sort_link('ddm_place1', 'sca='.$sca); ?>사입처 위치</a></th>
        <th scope="col"><?php echo subject_sort_link('ddm_place2', 'sca='.$sca); ?>사입처 상세위치</a></th>
        <th scope="col"><?php echo subject_sort_link('ddm_name', 'sca='.$sca, 1); ?>사입처명</a></th>
        <th scope="col"><?php echo subject_sort_link('ddm_tel', 'sca='.$sca, 1); ?>사입처 전화번호</a></th>
        <th scope="col">이 사입처에 받아온 샘플</th>
        <th scope="col">이 사입처와 거래한 상품</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=mysql_fetch_array($result); $i++)
    {
    ?>
    <tr>
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['ddm_name']); ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
        </td>
        <td class="td_num"><?php echo $row['ddm_part']; ?></td>
        <td class="td_num"><?php echo $row['ddm_place1']; ?></td>
        <td class="td_num"><?php echo $row['ddm_place2']; ?></td>
        <td headers="th_pc_title" class="td_num"><?php echo $row['ddm_name']; ?></td>
        <td class="td_num"><?php echo $row['ddm_tel']; ?></td>
        <td class="td_num">
        <?php
            $ddm_place2 = $row['ddm_place2'];
            $it_extract_name = $ddm_place2."(".$row['ddm_name'].")";
            $detail_link = G5_ADMIN_URL.'/shop_admin/ddmaddressview.php?it_place_ddm='.$ddm_place2;
            //$sql_match  = "select it_name, it_price, it_2, it_place_ddm, it_name_ddm, it_price_ddm from {$g5['g5_shop_ddmaddress_table']} where it_place_ddm like '$ddm_place2%'";
            //$result_match = sql_query($sql);
            //for ($j=0; $row=mysql_fetch_array($result_match); $j++) {
            $sql2 = " select count(*) as cnt1 from {$g5['g5_shop_item_table']} where it_place_ddm = '$it_extract_name'";
            $row2 = sql_fetch($sql2);
            if($row2['cnt1'] > 0) {
                $total_count = '<a href="'.$detail_link.'" target="_blank" onclick="return popitup(\''.$detail_link.'\', \'VOGOS 사입처에 받아온 샘플\', \'700\', \'500\')"><span style="color:#ff0000;font-weight:bold;">'.$row2['cnt1'].'개</span> <i class="ion-ios-search-strong" style="margin:0 2px 0 8px;font-style:normal"></i>자세히</a>';
            } else {
                $total_count = '<span style="color:#bbb;">없음</span>';
            }
        ?>
        <?php echo $total_count; ?>
        </td>
        <td class="td_num">개발중...</td>
        <td class="td_mng">
            <a href="./ddmaddressform.php?w=u&amp;ddm_place2=<?php echo $row['ddm_place2']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['ddm_place2'],250, "")); ?> </span>수정</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="12" class="empty_table">검색된 자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제(개발중 누르지 마시오)" onclick="document.pressed=this.value">
    <?php } ?>
</div>
<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="일괄수정(개발중 누르지 마시오)" class="btn_submit" accesskey="s">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function popitup(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
    return false;
}
</script>

<script>
function fitemlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function() {
    $(".itemcopy").click(function() {
        var href = $(this).attr("href");
        window.open(href, "copywin", "left=100, top=100, width=300, height=200, scrollbars=0");
        return false;
    });
});

function excelform(url)
{
    var opt = "width=600,height=450,left=10,top=10";
    window.open(url, "win_excel", opt);
    return false;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>