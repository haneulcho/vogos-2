<?php
$sub_menu = '400300';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$g5['title'] = '엑셀파일로 일괄수정 한글화';
include_once(G5_PATH.'/head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <form name="fitemexcel1" method="post" action="./itemkrformupdate.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">

    <div id="excelfile_upload">
        <label for="excelfile1">상품 한글화 파일선택</label>
        <input type="file" name="excelfile1" id="excelfile1">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="한글화 엑셀파일 등록" class="btn_submit">
        <button type="button" onclick="window.close();">닫기</button>
    </div>

    </form>

</div>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <form name="fitemexcel2" method="post" action="./itemkrformupdate2.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">

    <div id="excelfile_upload">
        <label for="excelfile2">가격 파일선택</label>
        <input type="file" name="excelfile2" id="excelfile2">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="한글화 엑셀파일 등록" class="btn_submit">
        <button type="button" onclick="window.close();">닫기</button>
    </div>

    </form>

</div>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <form name="fitemexcel3" method="post" action="./itemkrformupdate3.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">

    <div id="excelfile_upload">
        <label for="excelfile3">영문 가격수정 파일선택</label>
        <input type="file" name="excelfile3" id="excelfile3">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="영문 가격수정 엑셀파일 등록" class="btn_submit">
        <button type="button" onclick="window.close();">닫기</button>
    </div>

    </form>

</div>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <form name="fitemexcel4" method="post" action="./itemkrformupdate4.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">

    <div id="excelfile_upload">
        <label for="excelfile4">영문 카테고리, 유형, 인덱스 순서 파일선택</label>
        <input type="file" name="excelfile4" id="excelfile4">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="영문 가격수정 엑셀파일 등록" class="btn_submit">
        <button type="button" onclick="window.close();">닫기</button>
    </div>

    </form>

</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>