<?php
require_once("../db/dbhelper.php");

if (isset($_GET['d_id'])) {
    $id = $_GET['d_id'];
    $sql = "SELECT * FROM coupon WHERE coupon_code = '$id' ";
    $run_sql = executeSingleResult($sql);
    $expirationDate = $run_sql['expiration_date'];
    $discount = number_format($run_sql['discount'], 0) . '%';
    $coupon_code = $run_sql['coupon_code'];
    $quantity = $run_sql['quantity'];
    $endDate = $run_sql['expiration_date'];
    $startDate = $run_sql['startDate'];
    $image = $run_sql['banner'];
    // Tính toán số ngày còn lại
    $remainingDays = intval((strtotime($expirationDate) - strtotime($startDate)) / (60 * 60 * 24));
}
if (isset($_POST['update-coupon'])) {
    $id = $_POST['id'];
    $discount = $_POST['discount'];
    $expirationDays = $_POST['date'];
    $quantity = $_POST['quantity'];
    $discount_result = executeSingleResult("SELECT * FROM coupon WHERE coupon_code = '$id'");
    $startDate = $discount_result['startDate'];

    $startDateFormatted = date('Y-m-d', strtotime($startDate));

    $expirationDate = date('Y-m-d', strtotime("+$expirationDays days", strtotime($startDateFormatted)));
    if (strtotime($expirationDate) < strtotime($startDateFormatted)) {
        $expirationDate = $startDateFormatted;
    }
    if (isset($_FILES["banner"]) && $_FILES['banner']['name'] != '') {

        $sql = "SELECT banner FROM coupon WHERE coupon_code = '$id'";
        $slide = executeSingleResult($sql);
        $oldSlide = $slide['banner'];
        if (!empty($oldSlide) && file_exists('../' . $oldSlide)) {
            unlink('../' . $oldSlide);
        }


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
        $image = 'image/discount/' . $_FILES["banner"]["name"];
    } else {
        $sql = "SELECT banner FROM discount WHERE coupon_code = '$id'";
        $oldImage = executeSingleResult($sql)['banner'];
        $image = $oldImage;
    }

    $sql = "UPDATE discount SET discount = '$discount',
     expiration_date = '$expirationDate', quantity = $quantity, banner = '$image' WHERE coupon_code = '$id'";
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

            <div class="container-fluid">

                <h1>Discount Edit</h1>
                <form action="" class="row" enctype="multipart/form-data" method="post" onsubmit="return validateForm()">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <p class="font-danger" style="font-size:.9rem">Expiration Date: <?php echo $endDate ?></p>
                    <div class="form-group col-md-3">
                        <label for="start_date">Start Date: </label>
                        <input type="date" class="form-control" name="start_date" readonly value="<?php echo date('Y-m-d', strtotime($startDate)); ?>" required id="start_date" placeholder="dd/mm/yyyy">
                        <p id="start_date_error" class="error-message"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discount">Discount: </label>
                        <input type="text" class="form-control" name="discount" value="<?php echo $discount; ?>" id="discount" pattern="^(?:100|[1-9]\d|\d)%?$" placeholder="1-100 (%)">
                        <p id="discount_error" class="error-message"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date">Expiration Date: </label>
                        <input type="number" class="form-control" name="date" value="<?php echo $remainingDays; ?>" id="date" placeholder="">
                        <p id="expiration_error" class="error-message"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="quantity">Quantity: </label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $quantity ?>">
                        <p id="quantity_error" class="error-message"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="banner">Banner: </label>
                        <input type="file" class="form-control" name="banner" id="input-image">
                        <div id="preview-image"></div>

                    </div>
                    <button type="submit" class="btn btn-info" name="update-coupon">Update Coupon</button>
                    <img src="../<?php echo $image ?>" alt="">
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

            // Xóa thông báo lỗi cũ
            document.getElementById('start_date_error').innerHTML = '';
            document.getElementById('discount_error').innerHTML = '';
            document.getElementById('expiration_error').innerHTML = '';
            document.getElementById('quantity_error').innerHTML = '';

            // Kiểm tra các điều kiện và hiển thị thông báo lỗi
            if (startDate === '') {
                document.getElementById('start_date_error').innerHTML = 'Please enter the start date.';
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

            return true;
        }
    </script>
    <script src="../script.js"></script>
</body>

</html>