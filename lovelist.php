<?php
session_start();
require_once('db/dbhelper.php');
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
}
if (isset($_POST['addtowishlist'])) {
    // $petId = $_POST['petId'];
    $p_id = $_POST['plant_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];





    $sql1 = "INSERT INTO cart (user_id,pet_id,price,quantity) VALUES('$user_id','$p_id','$price',1)";
    execute($sql1);
    header("location: cart.php");
}
$sql = "SELECT * FROM whistlish where user_id = '$user_id' ";
$wl = executeResult($sql);
if (isset($_GET['delete_item'])) {
    $item_id = $_GET['delete_item'];
    execute("DELETE FROM whistlish WHERE p_id = $item_id");
    header('Location: lovelist.php');
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

    <style>
        @media (max-width: 767.98px) {
            .border-sm-start-none {
                border-left: none !important;
            }
        }

        .desired_size img {
            height: 140px;
        }
    </style>
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

                    <h1 class="shopName">Lovelist</h1>
                    <div class="header-row__button">
                        <a href="#" class="btn"></a>
                    </div>
                </div>
            </div>

        </div>
        <!-- home Section End-->
        <br><br>


        <section>
            <div class="container py-5">

                <div class="row justify-content-center mb-3">
                    <div class="col-md-12 col-xl-10">
                        <div class="card shadow-0 border rounded-3">
                            <div class="card-body">
                                <div class="row">
                                    <?php
if ($wl != NULL) {
                                    foreach ($wl as $w) {
                                        $image = executeSingleResult("SELECT min(image_id) as image, image_path FROM image WHERE plant_id = {$w['p_id']}")['image_path'];
                                        $plant = executeSingleResult("SELECT * FROM plants WHERE plant_id = {$w['p_id']}");
                                        if ($plant['sale'] != null && $plant['sale'] > 0) {
                                            $price = '$' . '<del style="text-decoration:line-through;">' . $plant['price'] . '</del> $<span style="color:red">' . $plant['sale'] . '</span>';
                                        } else {
                                            $price = '$' . $plant['price'];
                                        }
                                        echo '
    
    <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
    <div class="bg-image hover-zoom ripple rounded ripple-surface desired_size">
        <a href="product-detail.php?pid=' . $w['p_id'] . '"><img src="' . $image . '" style="width:200px;" alt=""></a>
        <a href="#!">
            <div class="hover-overlay">
                <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-md-6 col-lg-6 col-xl-6">
    <h5>' . $plant['name'] . '<span class="text-danger" style="float: right;"><i class=\'bx bxs-heart\' ></i></span>
    <span class=\'product-remove\' style="float: right;"><a href="lovelist.php?delete_item=' . $w['p_id'] . '"><i class=\'bx bx-x-circle\'></i></a></span>
    </h5>
   

    <p class="text-truncate mb-4 mb-md-0">
    ' . $plant['description'] . '
    </p>
</div>
<div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
    <div class="d-flex flex-row align-items-center mb-1">
        <h4 class="mb-1 me-1"> ' . $price . '</h4>
    </div>
    <h6 class="text-success">Free shipping</h6>
    <div class="d-flex flex-column mt-4">
        <button class="btn btn-success btn-sm" type="button"><a href="product-detail.php">Details</a></button>
        <form action="cart.php" method="post" class="wishlist-form">
        <button class="btn btn-outline-success btn-sm" type="submit" name="add-cart">
            Add to cart
        </button>
        <input type="hidden" name="pid" value="' . $w['p_id'] . '">
    <input type="hidden" name="name" value="' . $plant['name'] . '">
    <input type="hidden" name="description" value="' . $plant['description'] . '">
    <input type="hidden" name="quantity" value="1">
        </form>
    </div>
</div>

    
    


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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>






        <?php
        include('part/footer.php');
        ?>



        <!-- Modal -->
        <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">How many plants you want to buy?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="quantity form-control input-number" value="1" min="1" max="100">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" style="color: rgb(0, 255, 166);">Add to cart</button>
                    </div>
                </div>
            </div>
        </div> -->





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