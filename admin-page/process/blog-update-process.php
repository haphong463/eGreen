<?php
require_once '../../db/dbhelper.php';
if (isset($_POST['update-blog'])) {
    $id = $_POST['blog_id'];
    $title = $_POST['title'];
    $type = $_POST['cate_id'];
    $content = $_POST['content'];
    $desc = addslashes($content);


    if (isset($_FILES["blog"]) && $_FILES['blog']['name'] != '') {

        $sql = "SELECT img FROM blog WHERE blog_id = $id";
        $slide = executeSingleResult($sql);
        $oldSlide = $slide['img'];
        if (!empty($oldSlide) && file_exists('../../' . $oldSlide)) {
            unlink('../../' . $oldSlide);
        }


        $target_dir = "../../image/blog/";
        $target_file = $target_dir . basename($_FILES["blog"]["name"]);
        $upload_ok = 1;
        $image_file_type =
            strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file ảnh
        if (
            $image_file_type != "jpg" && $image_file_type != "png"
            && $image_file_type != "avif" && $image_file_type != "webp"
        ) {
            echo '<script>alert("Only JPG, AVIF, PNG, Webp files are allowed")</script>';
            $upload_ok = 0;
        }

        // Kiểm tra tên file trùng lặp
        if (file_exists($target_file)) {
            echo 'The file name already exits. Pls change your file name!';
            $upload_ok = 0;
        }

        if ($_FILES['blog']['size'] > 2097152) {
            echo 'The image file size cannot be greater than 2mb';
            $upload_ok = 0;
        }

        // Lưu tệp tin ảnh
        if ($upload_ok == 1) {
            move_uploaded_file($_FILES["blog"]["tmp_name"], $target_file);
            //echo 'upload successfully!';     
        }
        $image = 'image/blog/' . $_FILES["blog"]["name"];
    } else {
        $sql = "SELECT img FROM blog WHERE blog_id = $id";
        $oldImage = executeSingleResult($sql)['img'];
        $image = $oldImage;
    }
}



$sql2 = "UPDATE blog SET title = '$title', content = '$desc', blog_category_id = '$type', img = '$image', created_at = NOW() WHERE blog_id = $id";
execute($sql2);
header('Location: ../blog.php');
?>