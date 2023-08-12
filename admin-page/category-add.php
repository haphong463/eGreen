<?php
require_once("../db/dbhelper.php");
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $target_dir = "../image/category/";
    $target_file = $target_dir . basename($_FILES["banner"]["name"]);
    $upload_ok = 1;
    $image_file_type =
        strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra định dạng file ảnh
    if (
        $image_file_type != "jpg" && $image_file_type != "png"
        && $image_file_type != "avif" && $image_file_type != "webp"
    ) {
        echo 'Only JPG, JPEG, PNG, GIF files are allowed';
        $upload_ok = 0;
    }

    // Kiểm tra tên file trùng lặp
    if (file_exists($target_file)) {
        echo 'The file name already exits. Pls change your file name!';
        $upload_ok = 0;
    }

    if ($_FILES['banner']['size'] > 2097152) {
        echo 'The image file size cannot be greater than 2mb';
        $upload_ok = 0;
    }

    // Lưu tệp tin ảnh
    if ($upload_ok == 1) {
        move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file);
        //echo 'upload successfully!';     
    }
    $image = 'image/category/' . $_FILES["banner"]["name"];
    execute("INSERT INTO categories (name, description, created_at, image) VALUES ('$name', '$description', NOW(), '$image')");
    // header('Location: category.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard Panel</title>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>


        <table class="table">

            <br><br><br>

            <div class="">

                <h1>Category Add</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="email">Category Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" name="description">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="banner">Image: </label>
                        <input type="file" class="form-control" name="banner" id="input-image">
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Submit</button>
                </form>
        </table>
        </div>
    </section>

    <script src="../script.js"></script>
</body>

</html>