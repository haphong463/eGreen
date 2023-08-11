<?php
session_start();
require_once('db/dbhelper.php');
$perPage = 8;

// Trang hiện tại, mặc định là 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính chỉ mục bắt đầu của dữ liệu trên trang hiện tại
$start = ($page - 1) * $perPage;
$user_id = $_SESSION['user']['user_id'];
$order_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date desc LIMIT $start, $perPage";
$order_result = executeResult($order_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>techWiz</title>
    <link rel="shortcut icon" type="image" href="img/meo.jpg">
    <!-- BStrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BStrap link -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/box.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->
    <style>
        .cart-table {
            margin-bottom: 28px;
        }

        .cart-table table {
            width: 100%;
        }

        .cart-table table thead {
            border-bottom: 2px solid #D0D7DB;
        }

        .cart-table table thead tr th {
            color: #838383;
            font-size: 12px;
            font-weight: 500;
            padding: 16px 0;
        }

        .cart-table table tbody td {
            margin-top: 29px;
            padding-top: 29px;
        }

        .cart-table table .product-h {
            text-align: left;
        }

        .cart-table table .quan {
            padding-left: 30px;
        }

        .cart-table table .product-col {
            display: table;
        }

        .cart-table table .product-col img {
            max-width: 168px;
        }

        .cart-table table .product-col .p-title {
            display: table-cell;
            vertical-align: middle;
            padding-left: 30px;
            padding-right: 15px;
        }

        .cart-table table .product-col .p-title h5 {
            color: #1e1e1e;
            font-weight: 600;
        }

        .cart-table table .price-col {
            color: #1e1e1e;
            font-size: 18px;
            font-weight: 600;
            width: 14%;
            padding-right: 15px;
        }

        .cart-table table .quantity-col {
            width: 28%;
        }

        .cart-table table .quantity-col .pro-qty {
            height: 56px;
            width: 173px;
            border: 2px solid #EEF1F2;
            border-radius: 50px;
            text-align: center;
        }

        .cart-table table .quantity-col .pro-qty input {
            width: 50px;
            text-align: center;
            background: transparent;
            border: none;
            font-size: 18px;
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            height: 100%;
        }

        .cart-table table .quantity-col .pro-qty .qtybtn {
            color: #838383;
            cursor: pointer;
            font-size: 18px;
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            padding: 16px 0;
        }

        .cart-table table .total {
            color: #1e1e1e;
            font-size: 18px;
            font-weight: 600;
            width: 16%;
        }

        .cart-table table .product-close {
            color: #1e1e1e;
            font-size: 18px;
            font-weight: 600;
            width: 6%;
            cursor: pointer;
        }
    </style>

</head>

<body>






    <?php
    include('part/header.php');
    ?>
    <div class="home">

        <div class="header-row">
            <div class="header-row-inside">

                <h1 class="shopName">Details</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <div class="cart-page" style="margin-bottom:40vh">
        <div class="container">
            <h2>Order history</h2>
            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Complete Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order_result as $order) {
                            $order_id = $order['order_id'];
                            $payment_method = $order['payment_method'];
                            $status = $order['status'];
                            echo '
                            <tr>
                                <td><a style="border-radius: 0" class="btn btn--secondary btn--small" href="order-details.php?order_id=' . $order['order_id'] . '">' . $order['order_id'] . '</a></td>
                                <td>' . $order['order_date'] . '</td>
                                <td>' . $payment_method . '</td>
                                <td>' . $status . '</td>
                                <td><b>$' . number_format($order['total_amount'], 2) . '</b></td>
                            <tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination mt-2" style="margin:unset">
                    <?php
                    // Câu truy vấn SQL để lấy tổng số dòng dữ liệu
                    $sql_count = "SELECT COUNT(*) AS total FROM orders WHERE user_id = $user_id";
                    $result = executeSingleResult($sql_count);
                    $totalRows = $result['total'];

                    // Tính tổng số trang
                    $totalPages = ceil($totalRows / $perPage);

                    // Hiển thị các liên kết phân trang
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<a style="margin:unset" class="btn review-btn" href="?page=' . $i . '">' . $i . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
    <?php
    include('part/footer.php');
    ?>


    <a href="#" class="arrow">
        <i class='bx bx-up-arrow-alt'></i>
    </a>








    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>