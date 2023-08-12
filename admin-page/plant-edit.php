<?php
require_once("../db/dbhelper.php");
$id = $_GET['id'];
$plants = executeSingleResult("SELECT * FROM plants WHERE plant_id = $id");
$plant_id = $plants['plant_id'];
$category = executeResult("SELECT * FROM categories");
$image = executeResult("SELECT * FROM image WHERE plant_id = $plant_id");
$inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = $plant_id")['quantity'];
if (isset($_POST['edit'])) {
    $plant_id = $_POST['plant_id'];
    $name = $_POST['name'];
    $cate_id = $_POST['cate_id'];
    $description = addslashes($_POST['description']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    execute("UPDATE plants SET category_id = $cate_id, name = '$name', description = '$description', price = $price WHERE plant_id = $plant_id");
    execute("UPDATE inventory SET quantity = $quantity WHERE plant_id = $plant_id");
    if (!empty($_FILES['image']['name'][0])) {
        // Lấy các đường dẫn hình ảnh cũ từ cơ sở dữ liệu
        $sql_image_old = "SELECT pi.image_path, pt.thumbnail_path FROM image AS pi INNER JOIN thumbnail AS pt ON pi.plant_id = pt.plant_id WHERE pi.plant_id = $plant_id";
        $result_image_old = executeResult($sql_image_old);

        // Tạo một mảng lưu trữ các đường dẫn của các hình ảnh cũ
        $old_image_paths = array();
        foreach ($result_image_old as $image_old) {
            $old_image_paths[] = ($image_old['image_path']);
            $old_image_paths[] = ($image_old['thumbnail_path']);
        }

        // Xóa các hình ảnh cũ trong thư mục và cơ sở dữ liệu
        foreach ($old_image_paths as $old_image_path) {
            $file_path = '../' . $old_image_path;
            if (file_exists($file_path)) {
                unlink($file_path); // Xóa ảnh thực tế trong thư mục
            }
            $sql_delete_image = "DELETE FROM image WHERE image_path = '$old_image_path'";
            execute($sql_delete_image); // Xóa ảnh trong cơ sở dữ liệu

            $sql_delete_thumbnail = "DELETE FROM thumbnail WHERE thumbnail_path = '$old_image_path'";
            execute($sql_delete_thumbnail); // Xóa ảnh trong cơ sở dữ liệu
        }
    }
    $takeid = $plant_id;
    include('uploadImage.php');
    header('Location: plants.php');
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
    <script src="https://cdn.tiny.cloud/1/nb4vev3lun09knzucwhj47n7cmn1y7l4j5w4jhq249xu7j66/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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

            <div class="container-fluid">

                <h1>Plants Edit</h1>
                <form action="" method="post" enctype="multipart/form-data" class="row" onsubmit="validateForm()">
                    <input type="hidden" name="plant_id" value="<?= $id ?>">
                    <div class="row">
                        <div class="col-3">
                            <label for="email">Category:</label>
                            <select class="form-control" name="cate_id">
                                <?php
                                $sql = "SELECT * FROM categories";
                                $categories = executeResult($sql);
                                foreach ($categories as $c) {

                                ?>
                                    <?php $selected = ($plants && $plants['category_id'] == $c['category_id']) ? 'selected' : '' ?>
                                    <option value="<?php echo $c['category_id'] ?>" <?php echo $selected ?>><?php echo $c['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="description">Name:</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" value="<?= $plants['name'] ?>" name="name">
                            <p id="name_error" class="error-message"></p>

                        </div>
                        <div class="mb-3 col-3">
                            <label for="description">Price:</label>
                            <input type="text" class="form-control" id="price" placeholder="Enter price" value="<?= $plants['price'] ?>" name="price">
                            <p id="price_error" class="error-message"></p>

                        </div>
                        <div class="mb-3 col-3">
                            <label for="quantity">Plant's quantity:</label>
                            <input type="text" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity" value="<?= $inventory ?>">
                            <p id="quantity_error" class="error-message"></p>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" placeholder="Enter description" name="description"><?= $plants['description'] ?></textarea>
                        <p id="description_error" class="error-message"></p>

                    </div>

                    <div class="mb-3">
                        <label for="image">Images:</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="row">
                            <?php
                            $count = 0;
                            foreach ($image as $r) {
                                if ($count % 3 == 0) {
                                    echo '</div><div class="row">';
                                }
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <img src="../<?php echo $r['image_path'] ?>" alt="Product Image" class="img-fluid">
                                </div>
                            <?php
                                $count++;
                            }
                            ?>
                        </div>
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary mt-3">Edit</button>
                </form>
        </table>
        </div>
    </section>
    <script>
        function validateForm() {
            // Lấy giá trị của các trường dữ liệu
            var description = document.getElementById('description').value;
            var name = document.getElementById('name').value;
            var price = document.getElementById('price').value;
            var quantity = document.getElementById('quantity').value;

            // Xóa thông báo lỗi cũ
            document.getElementById('description_error').innerHTML = '';
            document.getElementById('name_error').innerHTML = '';
            document.getElementById('price_error').innerHTML = '';
            document.getElementById('quantity_error').innerHTML = '';

            // Kiểm tra các điều kiện và hiển thị thông báo lỗi
            if (description === '') {
                document.getElementById('description_error').innerHTML = 'Please enter the description.';
                return false;
            }

            if (name === '') {
                document.getElementById('name_error').innerHTML = 'Please enter the name.';
                return false;
            }

            if (price === '') {
                document.getElementById('price_error').innerHTML = 'Please enter the price.';
                return false;
            }

            if (quantity === '') {
                document.getElementById('quantity_error').innerHTML = 'Please enter the quantity.';
                return false;
            }

            if (parseInt(quantity) <= 0) {
                document.getElementById('quantity_error').innerHTML = 'Quantity must be greater than 0.';
                return false;
            }

            return true;
        }
    </script>
    <script>
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <script src="script.js"></script>
</body>

</html>