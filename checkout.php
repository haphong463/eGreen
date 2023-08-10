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

            <form action="successPayment.php?code=<?php echo $code ?>&id=<?php echo $id ?>" id="theForm" method="post">

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
                                                                <input type="text" value="" class="mr-2" style="float: right;" placeholder="Enter the recipient's name">
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
                                                                <input type="text" value="" class="mr-2" style="float: right;" placeholder="Enter the recipient phone">
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
                                                        <input type="text" value="" class="mr-2" style="float: right;" placeholder="Enter the recipient's address">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
<br>
                                <div class="row-lg-12">
                                    <div class="cart-detail bg-light p-3 p-md-4">
                                        <h2 class="billing-heading mb-4">Shipping Infomation <span style="float:right;"><button type="button" class="btn btn-outline-primary">Place Order</button></span></h2>
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
                                                                bobu
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
                                            100 $
                                        </span>

                                    </p>
                                    <p>
                                        <span>Delivery : </span>
                                        <span style="float: right;">
                                            100 $
                                        </span>
                                    </p>
                                    <p>

                                        <span>Discount :</span>
                                        <span style="float: right;">
                                            98.00 $
                                        </span>

                                    </p>

                                    <hr><br><br>

                                    <p class="total-price">

                                        <span>Total :</span>
                                        <span style="float: right;">
                                            1000 $
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