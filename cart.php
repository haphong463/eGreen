<?php
require_once 'db/dbhelper.php';
session_start();
$user_id = $_SESSION['user']['user_id'];
$cartItems = executeResult("SELECT * FROM cart WHERE user_id = $user_id");
$totalCart = 0;
if (isset($_POST['add-cart'])) {
    unset($_SESSION['discount']);
    $id = $_POST['pid'];
    $quantity = $_POST['quantity'];
    $inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = $id");
    $check_cart = executeSingleResult("SELECT * FROM cart WHERE user_id = $user_id and plant_id = $id");
    $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = $id")['price'];

    if ($quantity > $inventory['quantity']) {
        echo '<script>alert("So luong > so luong kho!"); window.location.href = "product-detail.php?pid=' . $id . '"</script>';
        exit;
    } else {
        if (isset($check_cart)) {
            execute("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id and plant_id = $id");
        } else {
            $insert_cart_query = execute("INSERT INTO cart (user_id, plant_id, quantity) VALUES ($user_id, $id, $quantity)");
        }
    }
    header('Location: cart.php');
}
if (isset($_GET['delete_item'])) {
    $item_id = $_GET['delete_item'];
    execute("DELETE FROM cart WHERE plant_id = $item_id");
    header('Location: cart.php');
}
if (isset($_POST['clear-cart'])) {
    $sql = "DELETE FROM cart WHERE user_id = $user_id";
    execute($sql);

    $_SESSION['discount'] = 0;
    echo '<script>window.location.href = "cart.php";</script>';
    exit();
}

if (isset($_POST['update-cart'])) {
    $quantities = $_POST['quantity'];

    foreach ($cartItems as $key => $cartItem) {
        $quantity = $quantities[$key];
        $inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = {$cartItem['plant_id']}");

        $price_old = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$cartItem['plant_id']}")['price'];
        $sale = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$cartItem['plant_id']}")['sale'];
        if ($sale != NULL && $sale > 0) {
            $__price = $sale;
        } else {
            $__price = $price_old;
        }
        if ($quantity > $inventory['quantity']) {
            $quantity = 1;
            echo '<script>alert("So luong > so luong kho!"); window.location.href = "cart.php"</script>';
        }
        $cartItems[$key]['quantity'] = $quantity;
        $subtotal = $__price * $quantity;
        $totalCart += $subtotal;
        execute("UPDATE cart SET quantity = $quantity WHERE plant_id = {$cartItem['plant_id']}");
    }


    $coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
    $_SESSION['coupon'] = $coupon_code;
    if (!empty($coupon_code)) {
        $sql = "SELECT * FROM coupon WHERE coupon_code = '$coupon_code'";
        $coupon = executeSingleResult($sql);
        if ($coupon) {
            $expirationDate = $coupon['expiration_date'];
            $quantity = $coupon['quantity'];
            $currentDate = date('Y-m-d');
            $startDateTimestamp = strtotime($coupon['startDate']);
            $currentDateTimestamp = strtotime($currentDate);

            if ($currentDateTimestamp > strtotime($expirationDate)) {
                echo '<script>alert("Coupon has expired")</script>';
            } elseif ($quantity == 0) {
                echo '<script>alert("No coupon")</script>';
            } else {
                $discountPercentage = $coupon['discount'];
                $discountAmount = $totalCart * ($discountPercentage / 100);
                $_SESSION['discount'] = $discountAmount;
                $total = $totalCart - $discountAmount;
            }
        } else {
            echo '<script>alert("Invalid coupon code");</script>';
        }
    } else {
        $_SESSION['discount'] = 0;
    }

    header('Location: cart.php');
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
    <link rel="stylesheet" href="css/box.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->


</head>
<style>
    td,
    tr {
        text-align: center;
        /* Căn giữa theo chiều ngang */
        vertical-align: middle;
        /* Căn giữa theo chiều dọc */
    }

    input {
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 10px;
        font-size: 16px;
        color: black;
        padding: 12px 20px 12px 20px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    input::placeholder {
        color: black;
    }
</style>

<body>
    <div class="all-content">




        <?php
        include('part/header.php');
        ?>
        <!-- home Section -->
        <div class="home">

            <div class="header-row">
                <div class="header-row-inside">

                    <h1 class="shopName">Cart</h1>
                    <div class="header-row__button">
                        <a href="#" class="btn"></a>
                    </div>
                </div>
            </div>

        </div>
        <!-- home Section End-->
        <br><br><br><br>

        <div class="container">
            <div class="row">


                <div class="cart-list">

                    <form action="cart.php" method="post">
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <!-- <th>Image</th> -->
                                    <!-- <th>Product</th> -->

                                    <th>Image</th>

                                    <th>Name</th>

                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $cart_query = executeResult("SELECT * FROM cart WHERE user_id = {$_SESSION['user']['user_id']}");
                                if ($cart_query != NULL) {
                                    foreach ($cart_query as $c) {
                                        $name = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['name'];
                                        $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['price'];
                                        $sale = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['sale'];
                                        $_pricee = isset($sale) ? $sale : $price;

                                        $subtotal = $c['quantity'] * $_pricee;
                                        $image = executeSingleResult("SELECT min(image_id) as image, image_path FROM image WHERE plant_id = {$c['plant_id']}")['image_path'];
                                        echo '
                                        
                                        <tr>
    
                                        <td hidden><input type="text" value="999999999999999999" readonly></td>
    
                                        <td><img src="' . $image . '" alt="" style="width:90px;height:90px;border-radius: 30px;"></td>
    
                                        <td><input hidden type="text" value="" name="petName" readonly>' . $name . '</td>
                                        <td><input hidden type="text" value="" name="price" readonly>' . $_pricee . '</td>
                                        <td><input type="number" value="' . $c['quantity'] . '" name="quantity[]"></td>
                                        <td><input hidden type="text" value="" name="subtotal" readonly>' . number_format($subtotal, 2) . '</td>
                                        <!-- delete -->
                                        <td class=\'product-remove\'><a href="cart.php?delete_item=' . $c['plant_id'] . '"><i class=\'bx bx-x-circle\'></i></a></td>
    
                                    </tr>
                                        
                                        ';
                                    }
                                } else {
                                    echo '
                                    
                                    <tr>
                                    <td colspan="5" style="font-size:23px">No products to display!</td>
                                </tr>
                                    
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" name="clear-cart" class="btn btn-outline-danger delete-update">
                            <i class='bx bxs-trash'></i>
                        </button>
                        <button type="submit" name="update-cart" class="btn btn-outline-success delete-update">Update Cart</button>
                        <input type="text" style="float: right;" maxlength="5" name="coupon_code" placeholder="enter the coupon code ...">

                    </form>


                </div>


                <br>
                <br><br>
                <br>


                <div class="col col-lg-12 col-md-12 mt-12 cart-wrap ftco-animate">
                    <div class="cart-total mb-12" style="width:100%;">
                        <h3 style="font-size: 50px;">ℂ𝕒𝕣𝕥 𝕋𝕠𝕥𝕒𝕝𝕤</h3>
                        <p>
                            <span style="font-size: 25px;">Subtotal : </span>

                            <span style="float: right;font-size: 25px;">
                                $<?php
                                    $subtotal = 0;
                                    foreach ($cart_query as $c) {
                                        $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['price'];
                                        $sale = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['sale'];
                                        $__price = isset($sale) ? $sale : $price;
                                        $subtotal += $c['quantity'] * $__price;
                                    }
                                    echo number_format($subtotal, 2);

                                    ?>
                            </span>


                        </p>
                        <p>
                            <span style="font-size: 25px;">Delivery : </span>
                            <span style="float: right;font-size: 25px;">
                                Free
                            </span>
                        </p>
                        <!-- LONG -->
                        <p>
                            <?php
                            $total = 0;
                            $discountAmount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
                            $total = $subtotal - $discountAmount;
                            $_SESSION['total-checkout'] = $total;
                            ?>
                            <span style="font-size: 25px;font-size: 25px;">Discount : </span>

                            <span style="float: right;font-size: 25px;">
                                $<?= number_format($discountAmount, 2); ?>
                            </span>
                        </p>
                        <!-- LONG -->
                        <hr>
                        <p class="total-price">
                            <span style="font-size: 25px;">Total : </span>
                            <span style="float: right;font-size: 25px;">
                                <?php
                                echo '$' . number_format($total, 2);
                                ?>
                            </span>


                        </p>
                    </div>
                    <p class="text-center" style="text-align: center;">
                        <a href="checkout.php" class="btn btn-outline-success" style="width:70%;">Pay</a>
                    </p>
                </div>
            </div>
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