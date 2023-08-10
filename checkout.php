


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

                <div id="payment">

                </div>

                <div class="row justify-content-center">
                    <div class="col-xl-10 ftco-animate">

                        <div class="row mt-5 pt-3 d-flex">
                            <div class="col-md-3 d-flex">
                                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                                    <h3 class="billing-heading mb-4">Cart Total</h3>

                                    <p class="d-flex">

                                        <span>Subtotal : </span>
                            <span>
                            100 $
                            </span>

                        </p>
                        <p class="d-flex">
                            <span>Delivery : </span>
                            <span>
                            100 $
                            </span>
                        </p>
                        <p class="d-flex">

                            <span>Discount :</span>
                            <span>
                            55 %
                            </span>

                        </p>

                                        <hr><br><br>

                                    <p class="d-flex total-price">

                                        <span>Total :</span>
                                        <span>
                                            1000 $
                                        </span>

                                    </p>

                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="cart-detail bg-light p-3 p-md-4">
                                    <h3 class="billing-heading mb-4">Payment Method</h3>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="" class="mr-2">After payment there will be no refund for any reason, please think carefully before paying</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        những phương thức thanh toán
                                    </div>
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