<?php
session_start();
require_once 'db/dbhelper.php';
require_once 'sendmail.php';
function generateOrderCode()
{
    $digits = '0123456789';
    $orderCode = 'VN';
    for ($i = 0; $i < 6; $i++) {
        $orderCode .= $digits[rand(0, 9)];
    }
    return $orderCode;
}
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_SESSION['user_token'])) {
    $user_token = $_SESSION['user_token'];
    $user = executeSingleResult("SELECT * FROM users WHERE token = '$user_token'");
    $user_id = $user['user_id'];
} else {
    header("Location: user-login.php");
}

$user = executeSingleResult("SELECT * FROM users WHERE user_id = $user_id");
if ($user['address'] == NULL || $user['phone'] == NULL) {
    header('Location: useredit.php');
}
$cart_query = executeResult("SELECT * FROM cart WHERE user_id = $user_id");
if ($cart_query == NULL) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>techWich</title>
    <link rel="shortcut icon" type="image" href="img/meo.jpg">
    <!-- BStrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BStrap link -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/checkout.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->


</head>

<body>
    <div class="all-content">






        <?php
        include('part/header.php');
        ?>
        <!-- home Section -->
        <div class="home">

            <div class="header-row">
                <div class="header-row-inside">

                    <h1 class="shopName">Check Out</h1>
                    <div class="header-row__button">
                        <a href="#" class="btn"></a>
                    </div>
                </div>
            </div>

        </div>
        <!-- home Section End-->






        <div class="container">

            <form action="" id="theForm" method="post">

                <div class="row justify-content-center">
                    <div class="col-xl-12 ftco-animate">

                        <div class="row mt-5 pt-3">

                            <div class="col-lg-7">
                                <div class="row-lg-12">
                                    <div class="cart-detail bg-light p-3 p-md-4">
                                        <h2 class="billing-heading mb-4">Shipping Infomation</h2>


                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="checkbox">
                                                            <label style="width:100%;">
                                                                <input type="text" class="mr-2" style="float: right;" <?php if (isset($user)) {
                                                                                                                            echo 'value="' . $user['fullname'] . '" readonly';
                                                                                                                        } ?> placeholder="Enter the recipient's name">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="checkbox">
                                                            <label style="width:100%;">
                                                                <input type="text" <?php
                                                                                    echo 'value="' . $user['phone'] . '" readonly';
                                                                                    ?> class="mr-2" style="float: right;" placeholder="Enter the recipient phone">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label style="width:100%;">
                                                        <input type="text" <?php if (isset($user)) {
                                                                                echo 'value="' . $user['address'] . '" readonly';
                                                                            } ?> class="mr-2" style="float: right;" placeholder="Enter the recipient's address">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <br>
                                <div class="row-lg-12">
                                    <div class="cart-detail bg-light p-3 p-md-4">
                                        <h2 class="billing-heading mb-4">Shipping Infomation <span style="float:right;">
                                                <div id="payment"></div>
                                                <script src="https://www.paypal.com/sdk/js?client-id=ATGXcrNc5l8akd8iyRwk-OI4GXTyXAQy_nybdU9fGSfHpFA3crp3AUjbFIHEKYuiGyTkLpczjCgFS2GH"></script>
                                                <div id="paypal-button-container"></div>
                                                <script>
                                                    paypal.Buttons({
                                                        createOrder: function(data, actions) {
                                                            return actions.order.create({
                                                                purchase_units: [{
                                                                    amount: {
                                                                        value: "<?php echo number_format($_SESSION['total-checkout'], 2); ?>"
                                                                    }
                                                                }]
                                                            });
                                                        },
                                                        onApprove: function(data, actions) {
                                                            return actions.order.capture().then(function(details) {
                                                                document.getElementById('payment').innerHTML = '<input name="payment" value="Paypal" hidden>'
                                                                document.getElementById('theForm').submit();
                                                            });
                                                        }
                                                    }).render('#paypal-button-container');
                                                </script>
                                            </span></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                                    <h3 class="billing-heading mb-4">Cart Total</h3>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label style="width:100%;">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <span style="float: left; font-size:20px;">
                                                                Products :
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-9" style="text-align: center;">
                                                            <span style="float: right; font-size:20px;">
                                                                <?php
                                                                foreach ($cart_query as $item) {
                                                                    $item_name = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$item['plant_id']}")['name'];
                                                                    echo '<p>' . $item_name . '</p>';
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <p>

                                        <span>Subtotal : </span>
                                        <span style="float: right;">
                                            <?php
                                            $subtotal = 0;
                                            foreach ($cart_query as $c) {
                                                $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['price'];
                                                $sale = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['sale'];
                                                $__price = isset($sale) ? $sale : $price;
                                                $subtotal += $c['quantity'] * $__price;
                                            }
                                            echo '$' . number_format($subtotal, 2);

                                            ?>
                                        </span>

                                    </p>
                                    <p>
                                        <span>Delivery : </span>
                                        <span style="float: right;">
                                            Free
                                        </span>
                                    </p>
                                    <p>

                                        <span>Discount :</span>
                                        <span style="float: right;">
                                            $<?= number_format(isset($_SESSION['discount']) ? $_SESSION['discount'] : 0, 2) ?>
                                        </span>

                                    </p>

                                    <hr><br><br>

                                    <p class="total-price">

                                        <span>Total :</span>
                                        <span style="float: right;">
                                            <?= '$' . number_format($_SESSION['total-checkout'], 2); ?>
                                        </span>

                                    </p>

                                </div>
                            </div>


                        </div>
                    </div> <!-- .col-md-8 -->
                </div>

            </form>

        </div>





        <?php
        include('part/footer.php');
        ?>


        <a href="#" class="arrow">
            <i class='bx bx-up-arrow-alt'></i>
        </a>
    </div>





    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>

<?php
$orderCode = generateOrderCode();
if (isset($_POST['payment'])) {
    execute("INSERT INTO orders (order_id, user_id, order_date, total_amount, voucher, payment_method, payment_status, status)
     VALUES ('$orderCode', $user_id, NOW(), {$_SESSION['total-checkout']}, '{$_SESSION['coupon']}', 'Paypal', 'Transfer', 'Place Order')");
    if (isset($_SESSION['coupon'])) {
        execute("UPDATE coupon SET quantity = quantity - 1 WHERE coupon_code = '{$_SESSION['coupon']}'");
    }
    foreach ($cart_query as $item) {
        $item_id = $item['plant_id'];
        $quantity = $item['quantity'];
        $price_old = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$item['plant_id']}")['price'];
        $sale = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$item['plant_id']}")['sale'];

        if ($sale != NULL && $sale > 0) {
            $__price = $sale;
        } else {
            $__price = $price_old;
        }
        execute("UPDATE inventory SET quantity = quantity - $quantity WHERE plant_id = $item_id");
        execute("INSERT INTO order_details (order_id, user_id, plant_id, quantity, price) VALUES ('$orderCode', $user_id, $item_id, $quantity, $__price)");
    }

    $order_Details = executeResult("SELECT * FROM order_details WHERE user_id = $user_id and order_id = '$orderCode'");
    $amount = executeSingleResult("SELECT * FROM orders WHERE order_id = '$orderCode'")['total_amount'];
    $email = $user['email'];


    $title = 'Notice: ORDER #' . $orderCode . '';
    $content = '<html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            background-color: #fff;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                        }

                        a.tab-button {
                            text-decoration: none;
                            font-size: 14px;
                            font-weight: 600;
                            position: relative;
                            letter-spacing: .02em;
                            display: block;
                            padding: 10px 25px;
                            outline: none;
                            background: #eee;
                            color: #333;
                            border: none;
                        }
                        a.tab-button.active,
                        a.tab-button:hover {
                            transition: .5s;
                            opacity: 1;
                            text-decoration: none;
                            background-color: #fff;
                            color: #000;
                        }

                        h1 {
                            color: #333;
                            font-size: 24px;
                        }
                        p {
                            font-size: 16px;
                            line-height: 24px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Order Confirmation</h1>
                        <p>Dear ' . $user['fullname'] . ',</p>
                        <p>Thank you for placing an order with our store. Your order has been received and is being processed.</p>

                        <p>We are excited to let you know that our team is working diligently to prepare your items for shipment. Once your order has been shipped, we will send you a notification with the tracking details.</p>

                        <p>Please take a moment to review your order details below:</p>

                        <!-- Insert order details here -->
                        <table>
                            <thead>
                                <tr>
                                    <th>Information</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>';

    foreach ($order_Details as $order_details) {
        $pid = $order_details['plant_id'];
        $quantity = $order_details['quantity'];

        $sql2 = "SELECT * FROM plants WHERE plant_id = $pid";
        $product = executeSingleResult($sql2);
        $content .= '
                                            <tr>
                                                <td>' . $product['name'] . '</td>
                                                <td>' . $quantity . '</td>
                                                <td>' . number_format($order_details['price'], 2, '.') . '</td>
                                            </tr>';
    }
    $content .= '   
                                            </tbody>
                                        </table>

                                        <p>
                                            Total amount: $' . number_format($amount, 2, '.') . '
                                        </p>

                                        <p>If you have any questions or need further assistance, please don\'t hesitate to contact our customer support team at support@chicandcool.com.</p>

                                        <p>
                                            <a class="tab-button" href="localhost/techwiz/order-details.php?order_id=' . $orderCode . '">View Order</a>
                                            <a class="tab-button" href="localhost/techwiz">Visit Website</a>
                                        </p>

                                        <p>Once again, thank you for choosing our store. We truly appreciate your business!</p>

                                        <p>Sincerely,</p>
                                        <p>PlantNest</p>
                                    </div>
                                </body>
                            </html>';




    $mailer = new Mailer();
    $mailer->dathangmail($title, $content, $email);









    execute("DELETE FROM cart WHERE user_id = $user_id");
    unset($_SESSION['discount']);
    unset($_SESSION['total-checkout']);
    unset($_SESSION['coupon']);
    echo '<script>window.location.href = "index.php"</script>';
}


?>