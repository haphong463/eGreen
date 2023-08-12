<?php
require_once 'db/dbhelper.php';
session_start();

if (isset($_SESSION['user']) || isset($_SESSION['user_token'])) {
    if (isset($_GET['order_id']) && isset($_GET['reason'])) {
        $order_id = $_GET['order_id'];
        $reason = $_GET['reason'];

        $order_details_query = "SELECT * FROM order_details WHERE order_id = '$order_id'";
        $order_details_result = executeResult($order_details_query);

        $cancel_order_query = "INSERT INTO cancel_order (order_id, reason, isAccept, created_at) VALUES ('$order_id', '$reason', 0, NOW())";
        execute($cancel_order_query);

        execute("UPDATE orders SET updated_at = NOW() WHERE order_id = '$order_id'");

        if (!empty($order_details_result)) {
            foreach ($order_details_result as $order_details) {
                $product_id = $order_details['plant_id'];
                $quantity = $order_details['quantity'];
                $update_product_variant_query = "UPDATE inventory SET quantity = quantity + $quantity WHERE plant_id = $product_id";
                execute($update_product_variant_query);
            }
        }

        $sql_update = "UPDATE orders SET status = 'Requesting cancellation' WHERE order_id = '$order_id'";
        execute($sql_update);
        // $delete_order_details_query = "DELETE FROM order_details WHERE order_id = '$order_id'";
        // execute($delete_order_details_query);

        // $delete_order_query = "DELETE FROM orders WHERE order_id = '$order_id'";
        // execute($delete_order_query);

        // $delete_transaction_query = "DELETE FROM transaction WHERE order_id = '$order_id";
        // execute($delete_transaction_query);

        header("Location: orders.php");
    } elseif (isset($_POST['returns'])) {
        $order_id = $_POST['order_id'];
        $reason = $_POST['reason'];

        $target_dir = "image/returns/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
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

        if ($_FILES['image']['size'] > 2097152) {
            echo 'The image file size cannot be greater than 2mb';
            $upload_ok = 0;
        }

        // Lưu tệp tin ảnh
        if ($upload_ok == 1) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            //echo 'upload successfully!';     
        }
        $image = 'image/returns/' . $_FILES["image"]["name"];

        $sql = "INSERT INTO returns (order_id, reason, isAccept, image_path) VALUES ('$order_id', '$reason', 0, '$image')";
        execute($sql);
        execute("UPDATE orders SET status = 'Requesting return' WHERE order_id = '$order_id' ");
        header('Location: orders.php');
    }
} else {
    header('Location: user-login.php');
}
