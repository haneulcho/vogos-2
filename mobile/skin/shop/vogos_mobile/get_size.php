<?php
include_once('../../../../common.php');
?>
<?php
if(!empty($_POST['width']) && !empty($_POST['height'])) {
    $mobile_img_width = $_POST['width'];
    $mobile_img_height = $_POST['height'];
    $it_id = $_POST['it_id'];

    echo get_it_image($it_id, $mobile_img_width, $mobile_img_height);
}
?>