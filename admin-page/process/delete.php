<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.css">
</head>

</html>
<?php
require_once ('../../db/dbhelper.php');

if(isset($_GET['delete_cat'])){
    $id = $_GET['delete_cat'];
    $check = executeResult("SELECT * FROM plants WHERE category_id = $id");

    if ($check != NULL) {
        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Cannot delete this category!',
            text: 'There are products assigned to this category.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '../category.php';
        });
    </script>";
        exit;
    }
    execute("DELETE FROM categories WHERE category_id = $id");
    
    header('Location: ../category.php');
}

if(isset($_GET['delete_plant'])){
    $id = $_GET['delete_plant'];
    $sql_image_old = "SELECT pi.image_path, pt.thumbnail_path FROM image AS pi INNER JOIN thumbnail AS pt ON pi.plant_id = pt.plant_id WHERE pi.plant_id = $id";
    $result_image_old = executeResult($sql_image_old);
    $old_image_paths = array();
    foreach ($result_image_old as $image_old) {
        $old_image_paths[] = ($image_old['image_path']);
        $old_image_paths[] = ($image_old['thumbnail_path']);
    }

    // Xóa các hình ảnh cũ trong thư mục và cơ sở dữ liệu
    foreach ($old_image_paths as $old_image_path) {
        $file_path = '../../' . $old_image_path;
        if (file_exists($file_path)) {
            unlink($file_path); // Xóa ảnh thực tế trong thư mục
        }
        $sql_delete_image = "DELETE FROM image WHERE image_path = '$old_image_path'";
        execute($sql_delete_image); // Xóa ảnh trong cơ sở dữ liệu

        $sql_delete_thumbnail = "DELETE FROM thumbnail WHERE thumbnail_path = '$old_image_path'";
        execute($sql_delete_thumbnail); // Xóa ảnh trong cơ sở dữ liệu
    }
    execute("DELETE FROM plants WHERE plant_id = $id");
    execute("DELETE FROM inventory where plant_id = $id");
    header('Location: ../plants.php');
}
