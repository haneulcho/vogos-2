<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/inlcude/bootstrap.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="sct" class="sct_wrap">
<div id="sod_title" class="rtap">
    <header class="fullWidth">
        <h2>1:1 Q &amp; A<span class="cart_item_num" style="width:170px"><i class="ion-heart"></i> <span style="font-size:13px;vertical-align:3px">무엇이든 물어보세요!</span></span></h2>
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
            <a href="<?php echo $list_href ?>" class="btn bf"><span class="glyphicon glyphicon-list-alt"></span> 목록</a>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn bf"><span class="glyphicon glyphicon-pencil"></span> 1:1 문의등록</a><?php } ?>
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
                <span class="bo_v_cate">[<?=$view['category']; ?>]</span><?=cut_str(get_text($view['subject']), 70); // 글제목 출력?>
                <span class="<?php echo ($view['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($view['qa_status'] ? '<span class="glyphicon glyphicon-ok" style="display:inline-block"></span> 답변완료' : '<span class="glyphicon glyphicon-remove" style="display:inline-block"></span> 답변대기'); ?></span>
            </h1>
        </header>
    </div>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <div id="bo_v_file">
        <?php
        // 가변 파일
        for ($i=0; $i<$view['download_count']; $i++) { ?>
                <a href="<?=$view['download_href'][$i]; ?>" class="bo_v_ect">
                    <span class="glyphicon glyphicon-save"></span>
                    <?php echo $view['download_source'][$i] ?>
                </a>
        <?php } ?>
    </div>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <section id="bo_v_atc">
        <?php
        // 파일 출력
        if($view['img_count']) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<$view['img_count']; $i++) {
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
            }

            echo "</div>\n";
        }
        ?>
        
        <!-- 본문 내용 시작 { -->
        <section id="bo_v_info">
            <span class="glyphicon glyphicon-user"></span> <?php echo $view['name'] ?>
            <span class="glyphicon glyphicon-time ml5"></span> <?php echo $view['datetime'] ?>
            <?php if(!empty($view['email'])) { ?>
                <span class="glyphicon glyphicon-envelope"></span> <?php echo $view['email']; ?>
            <?php } ?>
            <?php if(!empty($view['hp'])) { ?>
                <span class="glyphicon glyphicon-phone"></span> <?php echo $view['hp']; ?>
            <?php } ?>
        </section>
        <div id="bo_v_con">
        <?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?></div>
        <!-- } 본문 내용 끝 -->
    </section>

</article>
<!-- } 게시판 읽기 끝 -->

    <?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($qa_skin_path.'/view.answer.skin.php');
        else
            include_once($qa_skin_path.'/view.answerform.skin.php');
    }
    ?>

    <?php if($view['rel_count']) { ?>
    <section id="bo_v_rel">
        <h2>연관질문</h2>

        <div class="tbl_head01 tbl_wrap">
            <table>
            <thead>
            <tr>
                <th scope="col">분류</th>
                <th scope="col">제목</th>
                <th scope="col">상태</th>
                <th scope="col">등록일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0; $i<$view['rel_count']; $i++) {
            ?>
            <tr>
                <td class="td_category"><?php echo get_text($rel_list[$i]['category']); ?></td>
                <td>
                    <a href="<?php echo $rel_list[$i]['view_href']; ?>">
                        <?php echo $rel_list[$i]['subject']; ?>
                    </a>
                </td>
                <td class="td_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($rel_list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></td>
                <td class="td_date"><?php echo $rel_list[$i]['date']; ?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
            </table>
        </div>
    </section>
    <?php } ?>

</article>
<!-- } 게시판 읽기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>


</div></div>