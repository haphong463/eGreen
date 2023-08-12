<?php
require_once '../db/dbhelper.php';
if (isset($_POST['create-coupon'])) {
    function generateCouponCode($length = 5)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $couponCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $couponCode .= $characters[$randomIndex];
        }

        return $couponCode;
    }

    $coupon = generateCouponCode();
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $startDate = date('Y-m-d', strtotime($_POST['start_date']));
    $expirationDays = $_POST['date'];
    $expirationDate = date('Y-m-d', strtotime("+$expirationDays days", strtotime($startDate)));


    $target_dir = "../image/discount/";
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
    $image = 'image/discount/' . $_FILES["banner"]["name"];


    $sql = "INSERT INTO coupon (coupon_code, discount, quantity, startDate, expiration_date, banner) VALUES ('$coupon', '$discount','$quantity', '$startDate', '$expirationDate', '$image')";
    execute($sql);
    header('Location: discount.php');
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>    <title>Admin Dashboard Panel</title>
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

                <h1>New one Coupon</h1>
                <form action="" class="row" enctype="multipart/form-data" method="post" onsubmit="return validateForm()">
                    <div class="form-group col-md-6">
                        <label for="start_date">Start Date: </label>
                        <input type="date" class="form-control" name="start_date" id="start_date" placeholder="dd/mm/yyyy">
                        <div id="start_date_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discount">Discount: </label>
                        <input type="text" class="form-control" name="discount" id="discount" pattern="^(?:100|[1-9]\d|\d)%?$" placeholder="1-100 (%)">
                        <div id="discount_error"></div>
                    </div>
                    <div class="form-grou col-md-6">
                        <label for="date">Expiration Date: </label>
                        <input type="number" class="form-control" name="date" id="date" placeholder="">
                        <div id="expiration_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="quantity">Quantity: </label>
                        <input type="number" class="form-control" name="quantity" id="quantity">
                        <div id="quantity_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="banner">Banner: </label>
                        <input type="file" class="form-control" name="banner" id="input-image">
                        <div id="preview-image"></div>
                        <div id="banner_error"></div>
                    </div>
                    <button type="submit" class="btn btn-info" name="create-coupon">Add Coupon</button>
                </form>
        </table>
        </div>
    </section>
    <script>
        function validateForm() {
            // Lấy giá trị của các trường dữ liệu
            var startDate = document.getElementById('start_date').value;
            var discount = document.getElementById('discount').value;
            var expirationDays = document.getElementById('date').value;
            var quantity = document.getElementById('quantity').value;
            var banner = document.getElementById('input-image');


            // Xóa thông báo lỗi cũ
            document.getElementById('start_date_error').innerHTML = '';
            document.getElementById('discount_error').innerHTML = '';
            document.getElementById('expiration_error').innerHTML = '';
            document.getElementById('quantity_error').innerHTML = '';
            document.getElementById('banner_error').innerHTML = '';

            // Kiểm tra các điều kiện và hiển thị thông báo lỗi
            if (startDate === '') {
                document.getElementById('start_date_error').innerHTML = 'Please enter the start date.';
                return false;
            }

            var currentDate = new Date().toISOString().split('T')[0]; // Lấy ngày hiện tại
            if (startDate < currentDate) {
                document.getElementById('start_date_error').innerHTML = 'Start date cannot be in the past.';
                return false;
            }

            if (discount === '') {
                document.getElementById('discount_error').innerHTML = 'Please enter the discount.';
                return false;
            }

            if (expirationDays === '') {
                document.getElementById('expiration_error').innerHTML = 'Please enter the expiration days.';
                return false;
            }

            if (parseInt(expirationDays) < 0) {
                document.getElementById('expiration_error').innerHTML = 'Expiration days must be a positive number.';
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
            if (banner.files.length === 0) {
                document.getElementById('banner_error').innerHTML = 'Please select a banner file.';
                return false;
            }

            return true;
        }
    </script>
    <script src="script.js"></script>
</body>

</html>