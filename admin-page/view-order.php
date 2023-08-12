<?php
require_once '../db/dbhelper.php';
if ($_GET['order_id']) {
    $order_id = $_GET['order_id'];
    $order_query = "SELECT * FROM order_details WHERE order_id = '$order_id'";
    $order_result = executeResult($order_query);
    if (!empty($order_result)) {
        foreach ($order_result as $order) {
            $product_id =  $order['plant_id'];
        }
        // Lấy thông tin sản phẩm từ bảng "product" dựa trên các tên sản phẩm đã tách được

        $product_query = "SELECT plant_id, category_id, name, price FROM plants WHERE plant_id = $product_id";
        $product_result = executeResult($product_query);
    }

    // Sử dụng thông tin sản phẩm trong mảng $products để hiển thị trong trang Order Details

    $sql4 = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $total = executeSingleResult($sql4);

    $order_date = $total['order_date'];

    $cancel_order_query = "SELECT * FROM cancel_order WHERE order_id = '$order_id'";
    $cancel_order_result = executeSingleResult($cancel_order_query);

    if ($cancel_order_result != NULL) {
        $reason = $cancel_order_result['reason'];
        switch ($reason) {
            case "out_of_stock":
                $reason = "Item is out of stock";
                break;
            case "decision":
                $reason = "Changed my purchase decision";
                break;
            case "changed_mind":
                $reason = "Changed my mind";
                break;
            case "other":
                $reason = "Other reason";
                break;
        }
    }
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
    <style>
        .product-physical {
            max-height: 50vh;
            overflow: auto;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .product-details {
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-weight: bold;
        }

        .product-info p {
            margin: 0;
            font-weight: 600;
        }

        .user-info {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-info p {
            margin-bottom: 10px;
            font-size: 17px;
        }

        .user-info p:last-child {
            margin-bottom: 0;
        }

        .user-info p span {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>

        <div class="container-fluid">

            <br><br><br>



            <h1>Orders List</h1>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <b>ORDER #<?php echo $order_id ?></b>
                            <b style="margin-left:30px; margin-right:30px"><?php echo $order_date ?></b>
                            <a href="print.php?order_id=<?php echo $order_id ?>" class="btn btn-primary" style="border-radius: 0;">Print <img src="../image/print.png" width="20px" height="20px" alt=""></a>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8 mb-3 mb-lg-0">
                                    <h4>Order Details</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Information</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $subtotal = 0; // Khởi tạo biến subtotal

                                                foreach ($order_result as $order_details) {
                                                    $pid = $order_details['plant_id'];
                                                    $quantity = $order_details['quantity'];

                                                    $sql = "SELECT min(thumbnail_id) as thumbnail, thumbnail_path FROM thumbnail WHERE plant_id = $pid";
                                                    $image = executeSingleResult($sql);

                                                    $sql2 = "SELECT * FROM plants WHERE plant_id = $pid";
                                                    $product = executeSingleResult($sql2);
                                                    $cat_id = $product['category_id'];

                                                    $sql3 = "SELECT * FROM categories WHERE category_id = $cat_id";
                                                    $category = executeSingleResult($sql3);

                                                    $__price = $order_details['price'];

                                                    $total_amount_item = $quantity * $__price;
                                                    $subtotal += $total_amount_item;

                                                    echo '
                                                            
                                                            <tr>
                                                            
                                                            <td>
                                                                <div class="product-info">
                                                                    <div class="product-image">
                                                                        <img src="../' . $image['thumbnail_path'] . '" alt="Product Image">
                                                                    </div>
                                                                    <div class="product-details">
                                                                        <h6 class="product-name">' . $product['name'] . '</h6>
                                                                        <p class="product-info">Gender: ' . $category['name'] . '</p>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>$' . number_format($__price, 2, '.') . '</td>
                                                            <td>' . $quantity . '</td>
                                                            <td>$' . number_format($total_amount_item, 2, '.') . '</td>
                                                        </tr>
                                                            
                                                            ';
                                                }
                                                ?>
                                            </tbody>

                                            <tfoot>
                                                <?php

                                                $sql5 = "SELECT * FROM coupon WHERE coupon_code = '{$total['voucher']}'";
                                                $coupon = executeSingleResult($sql5);

                                                $discount_amount = isset($coupon['discount']) ? $coupon['discount'] : 0;
                                                $code = isset($coupon['coupon_code']) ? "(Code: " . $coupon['coupon_code'] . ")" : '';

                                                echo '
                                                        
                                                        <tr>
                                                            <td colspan="3"><b>Sub Total:</b></td>
                                                            <td>$' . number_format($subtotal, 2, '.') . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><b>Discount ' . $code . ':</b></td>
                                                            <td>' . number_format($discount_amount, 2, '.') . '%</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><b>Shipping Fee:</b></td>
                                                            <td>Free</td>
                                                        </tr>
                                                
                                                        <tr>
                                                            <td colspan="3"><b>Total:</b></td>
                                                            <td><b>$' . number_format($total['total_amount'], 2, '.') . '</b></td>
                                                        </tr>
                                                        ';
                                                ?>

                                            </tfoot>
                                        </table>
                                    </div>
                                    <?php
                                    // <a href="process/cancel-order-process.php?order_id=' . $order_id . '" 
                                    // class="btn btn-info">CANCEL ORDER</a>
                                    if ($total['status'] == "Place Order") {
                                        echo '
                                                <a href="process/confirm-order-process.php?order_id=' . $order_id . '" 
                                                class="btn btn-info">CONFIRM ORDER</a>
                                                
                                                ';
                                    } elseif ($total['status'] == "Requesting cancellation") {
                                        echo '<p><span style="color:red;">Canceled</span> with reason: ' . $reason . '</p>  
                                                <a href="process/approve-order-process.php?order_id=' . $order_id . '" 
                                                class="btn btn-info">Approved</a>                   
                                                
                                             
                                                ';
                                    } elseif ($total['status'] == "Canceled") {

                                        echo '<p><span style="color:red;">Canceled</span> with reason: ' . $reason . '</p> ';
                                    } elseif ($total['status'] == "Processing") {
                                        echo '
                                                
                                                <a href="process/confirm-order-process.php?order_go=' . $order_id . '" 
                                                class="btn btn-info">Go</a>
                                                
                                                ';
                                    } elseif ($total['status'] == "Shipping") {
                                        echo '
                                                
                                                <a href="process/confirm-order-process.php?finish_order=' . $order_id . '" 
                                                class="btn btn-info">Finish</a>
                                                
                                                ';
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </div>
                                <?php
                                $sql6 = "SELECT * FROM users WHERE user_id = '{$total['user_id']}'";
                                $users = executeSingleResult($sql6);
                                ?>
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <h4>Shipping information</h4>
                                    <div class="user-info">
                                        <p style="font-style:italic; font-weight:bold;"><?php echo $users['fullname'] ?></p>
                                        <p> <?php echo $users['email'] ?></p>
                                        <p><?php echo $users['phone'] ?></p>
                                        <p> <?php echo $users['address'] ?> </p>
                                        <?php

                                        echo '<p>Payment Method: ' .   $total['payment_method'] . '</span></p>';

                                        echo '<p>Payment Status: ' .   $total['payment_status'] . '</span></p>';
                                        ?>
                                        <?php
                                        echo '<p>Status: ' . $total['status'] . '</span></p>';
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $return = executeSingleResult("SELECT * FROM returns WHERE order_id = '$order_id'");
            if ($return != NULL) {
                echo '

                <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <h4>Returns</h4>
                                    <div class="user-info">
                                        <p>Reason: ' . $return['reason'] . '</p>
                                        <img src="../' . $return['image_path'] . '" width="200px" height="200px"></img>';
                                        if($total['status'] == "Requesting return"){
                                            echo '
                                            <p>  
                                                    <a href="process/approve-return-order.php?return_order=' . $order_id . '" 
                                                    class="btn btn-info mt-3">Approve</a>
                                                    <a href="process/cancel-return-order.php?cancel_return_order=' . $order_id . '" 
                                                    class="btn btn-info mt-3">Cancel</a>
                                                </p>
                                            ';
                                        }
                                        if($total['status'] == "Returned"){
                                            echo '
                                            <p style="color: red; text-decoration:underline; font-style:italic;" class="mt-3 text-center">  
                                                    Returned
                                                </p>
                                            ';
                                        }

                                        if($total['status'] == "Returning"){
                                            echo '
                                             <a href="process/confirm-return-order.php?return_order=' . $order_id . '" 
                                                    class="btn btn-info mt-3">Confirm</a>
                                            ';
                                        }

                                        if($total['status'] == "Return canceled"){
                                            echo '
                                            <p style="color: red; text-decoration:underline; font-style:italic;" class="mt-3 text-center">  
                                                    Return canceled
                                                </p>
                                            ';
                                        }
                                                
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
                ';
            }
            ?>

        </div>

    </section>

    <script src="script.js"></script>

</body>

</html>