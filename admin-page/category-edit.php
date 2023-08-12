<?php
require_once("../db/dbhelper.php");
$id = $_GET['id'];
$categories = executeSingleResult("SELECT * FROM categories WHERE category_id = $id");
if (isset($_POST['edit'])) {
    $cate_id = $_POST['cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    if (isset($_FILES["banner"]) && $_FILES['banner']['name'] != '') {

        $sql = "SELECT image FROM categories WHERE category_id = '$id'";
        $slide = executeSingleResult($sql);
        $oldSlide = $slide['image'];
        if (!empty($oldSlide) && file_exists('../' . $oldSlide)) {
            unlink('../' . $oldSlide);
        }


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
            echo '<script>alert("Only JPG, AVIF, PNG, Webp files are allowed")</script>';
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
    } else {
        $sql = "SELECT image FROM categories WHERE category_id = '$id'";
        $oldImage = executeSingleResult($sql)['image'];
        $image = $oldImage;
    }
    execute("UPDATE categories SET name = '$name', description = '$description', image = '$image' WHERE category_id = $cate_id");
    header('Location: category.php');
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
    <script src="https://cdn.tiny.cloud/1/nb4vev3lun09knzucwhj47n7cmn1y7l4j5w4jhq249xu7j66/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

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

            <div class="container">

                <h1>Category Edit</h1>
                <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <input type="hidden" name="cate_id" value="<?= $id ?>">
                    <div class="mb-3 mt-3">
                        <label for="email">Category Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" value="<?= $categories['name'] ?>" name="name">
                        <span id="nameError" class="error" style="color: red;"></span> <!-- Error message for title field -->
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description"><?php echo $categories['description'] ?></textarea>
                        <span id="descError" class="error" style="color: red;"></span> <!-- Error message for title field -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="banner">Image: </label>
                        <input type="file" class="form-control" name="banner" id="input-image">
                        <br><span id="imgError" class="error" style="color: red;"></span> <!-- Error message for blog image field -->
                    </div>
                    <img src="../<?= $categories['image'] ?>" alt="">

                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                </form>
        </table>
        </div>
    </section>
    <script>
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'lists',
            toolbar: 'undo redo | blocks fontsize | bold italic underline | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap',
        });
    </script>

    <script src="../script.js"></script>

    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var desc = document.getElementById("description").value;
            var img = document.getElementById("input-image").value;

            if (name === "") {
                document.getElementById("nameError").innerText = "Please enter a name.";
                return false;
            } else {
                document.getElementById("nameError").innerText = ""; // Clear the error message
            }

            if (desc === "") {
                document.getElementById("descError").innerText = "Please enter the description.";
                return false;
            } else {
                document.getElementById("descError").innerText = ""; // Clear the error message
            }

            if (img === "") {
                document.getElementById("imgError").innerText = "Please select image.";
                return false;
            } else {
                document.getElementById("imgError").innerText = ""; // Clear the error message
            }

            return true; // Submit the form if all the validations pass
        }
    </script>
</body>

</html>