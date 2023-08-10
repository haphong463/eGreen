<?php
require_once 'db/dbhelper.php';
session_start();
if (isset($_POST['add-cart'])) {
    $id = $_POST['pid'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user']['user_id'];
    $inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = $id");
    $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = $id")['price'];
    $insert_cart_query = execute("INSERT INTO cart (user_id, plant_id, quantity, price) VALUES ($user_id, $id, $quantity, $price)");
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

                    <form action="update-cart.php" method="post">
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
                                // $cart_query = executeResult("SELECT * FROM cart WHERE user_id = {$_SESSION['user']['user_id']}");
                                // foreach ($cart_query as $c) {
                                //     $name = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['name'];
                                //     $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['price'];
                                //     $subtotal = $c['quantity'] * $price;
                                //     $image = executeSingleResult("SELECT min(image_id) as image, image_path FROM image WHERE plant_id = {$c['plant_id']}")['image_path'];
                                //     echo '

                                //     <tr>

                                //     <td hidden><input type="text" value="999999999999999999" readonly></td>

                                //     <td><img src="' . $image . '" alt="" style="width:90px;height:90px;border-radius: 30px;"></td>

                                //     <td><input hidden type="text" value="" name="petName" readonly>' . $name . '</td>
                                //     <td><input hidden type="text" value="" name="price" readonly>' . $price . '</td>
                                //     <td><input type="number" value="1" name="quantity[]"></td>
                                //     <td><input hidden type="text" value="" name="subtotal" readonly>' . $subtotal . '</td>
                                //     <!-- delete -->
                                //     <td class=\'product-remove\'><a href="delete-cart.php?id="><i class=\'bx bx-x-circle\'></i></a></td>

                                // </tr>

                                //     ';
                                // }
                                ?>

                            </tbody>
                        </table>
                        <button type="submit" name="updatecart" class="btn btn-outline-danger delete-update">
                            <i class='bx bxs-trash'></i>
                        </button>
                        <button type="submit" name="updatecart" class="btn btn-outline-success delete-update">UpdateCart</button>

                        <input type="text" style="float: right;" placeholder="Enter the cappon">
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
                                    // $subtotal = 0;
                                    // foreach ($cart_query as $c) {
                                    //     $price = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['price'];
                                    //     $sale = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$c['plant_id']}")['sale'];
                                    //     $__price = isset($sale) ? $sale : $price;
                                    //     $subtotal += $c['quantity'] * $__price;
                                    // }
                                    // echo number_format($subtotal, 2);

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
                            <span style="font-size: 25px;font-size: 25px;">Discount : </span>

                            <span style="float: right;font-size: 25px;">
                                2%
                            </span>
                        </p>
                        <!-- LONG -->
                        <hr>
                        <p class="total-price">
                            <span style="font-size: 25px;">Total : </span>
                            <span style="float: right;font-size: 25px;">
                                <?php
                                // $total = $subtotal;
                                // echo '$' . number_format($total, 2);
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