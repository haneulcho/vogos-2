<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section id="bo_v_ans">
    <h2><span class="glyphicon glyphicon-check"></span><?php echo get_text($answer['qa_subject']); ?></h2>
    <!-- <a href="<?php //echo $rewrite_href; ?>" class="btn_b01">추가질문</a> -->
    <section id="ans_v_atc">
        <section id="ans_v_info">
            <span class="glyphicon glyphicon-user"></span> VOGOS
            <span class="glyphicon glyphicon-time ml5"></span> <?php echo $answer['qa_datetime'] ?>
            <span class="glyphicon glyphicon-envelope"></span> help@vogos.com
            <span class="glyphicon glyphicon-phone"></span> 02-1644-3828
        </section>

        <div id="ans_con">
            <?php echo conv_content($answer['qa_content'], $answer['qa_html']); ?>
        </div>

        <div id="ans_add">
            <?php if($answer_update_href) { ?>
            <a href="<?php echo $answer_update_href; ?>" class="btn_b01">답변수정</a>
            <?php } ?>
            <?php if($answer_delete_href) { ?>
            <a href="<?php echo $answer_delete_href; ?>" class="btn_b01" onclick="del(this.href); return false;">답변삭제</a>
            <?php } ?>
        </div>
    </section>
</section>