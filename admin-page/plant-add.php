<?php
require_once("../db/dbhelper.php");
$categories = executeResult("SELECT * FROM categories");
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $cate_id = $_POST['cate_id'];
    $quantity = $_POST['quantity'];
    execute("INSERT INTO plants (name, description, price, category_id) VALUES ('$name', '$description', $price, $cate_id)");

    $max_id = executeSingleResult("SELECT max(plant_id) as max FROM plants")['max'];
    execute("INSERT INTO inventory (plant_id, quantity, created_at) VALUES ($max_id, $quantity, NOW())");
    $takeid = $max_id;
    include('uploadImage.php');
    // header('Location: plants.php');
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

                <h1>Category Add</h1>
                <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="mb-3 mt-3">
                        <label for="email">Category:</label>
                        <select name="cate_id">
                            <?php
                            foreach ($categories as $cate) {
                                echo '
                                
                                <option value=" ' . $cate['category_id'] . '">' . $cate['name'] . '</option>

                                ';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email">Plant's name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name">
                        <p id="name_error" class="error-message" style="color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="price">Plant's price:</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter price" name="price">
                        <p id="price_error" class="error-message" style="color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Plant's quantity:</label>
                        <input type="text" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
                        <p id="quantity_error" class="error-message" style="color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="description">Plant's description:</label>
                        <textarea class="form-control" id="description" placeholder="Enter description" name="description"></textarea>
                        <p id="description_error" class="error-message" style="color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="image">Plant's image:</label>
                        <input type="file" class="form-control" id="image" placeholder="Enter description" name="image[]" multiple>
                        <br><span id="imgError" class="error" style="color: red;"></span> <!-- Error message for blog image field -->
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Submit</button>
                </form>
        </table>
        </div>
    </section>

    <script src="script.js"></script>

    <script>
        function validateForm() {
            // Lấy giá trị của các trường dữ liệu
            var description = document.getElementById('description').value;
            var name = document.getElementById('name').value;
            var price = document.getElementById('price').value;
            var quantity = document.getElementById('quantity').value;
            var img = document.getElementById('image').value;

            // Xóa thông báo lỗi cũ
            document.getElementById('description_error').innerHTML = '';
            document.getElementById('name_error').innerHTML = '';
            document.getElementById('price_error').innerHTML = '';
            document.getElementById('quantity_error').innerHTML = '';
            document.getElementById('imgError').innerHTML = '';

            // Kiểm tra các điều kiện và hiển thị thông báo lỗi
            if (name === '') {
                document.getElementById('name_error').innerHTML = 'Please enter the name.';
                return false;
            }

            if (description === '') {
                document.getElementById('description_error').innerHTML = 'Please enter the description.';
                return false;
            }

            if (price === '') {
                document.getElementById('price_error').innerHTML = 'Please enter the price.';
                return false;
            }

            if (!(/^\d+$/.test(price))) {
                document.getElementById('price_error').innerHTML = 'Please enter a valid number.';
                return false;
            }

            if (parseInt(price) <= 0) {
                document.getElementById('price_error').innerHTML = 'Price must be greater than 0.';
                return false;
            }

            if (quantity === '') {
                document.getElementById('quantity_error').innerHTML = 'Please enter the quantity.';
                return false;
            }

            if (!(/^\d+$/.test(quantity))) {
                document.getElementById('quantity_error').innerHTML = 'Please enter a valid number.';
                return false;
            }

            if (parseInt(quantity) <= 0) {
                document.getElementById('quantity_error').innerHTML = 'Quantity must be greater than 0.';
                return false;
            }

            if (img === '') {
                document.getElementById('imgError').innerHTML = 'Please select the image.';
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
</body>

</html>