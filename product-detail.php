<?php
require_once 'db/dbhelper.php';
session_start();

if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])) {
    header("Location: index.php");
    exit(); //
}

$pid = $_GET['pid'];
$product_result = executeSingleResult("SELECT * FROM plants WHERE plant_id = $pid");
$cate = executeSingleResult("SELECT * FROM categories WHERE  category_id = {$product_result['category_id']}")['name'];
if (!$product_result) {
    header("Location: index.php");
    exit();
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
    <link rel="stylesheet" href="css/single.css">
    <!-- <link rel="stylesheet" href="css/login.css"> -->


    <!-- cacha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


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

                    <h1 class="shopName">Detail</h1>
                    <div class="header-row__button">
                        <a href="#" class="btn"></a>
                    </div>
                </div>
            </div>

        </div>
        <!-- home Section End-->
        <br><br><br><br>




        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <?php
                    //foreach($pet as $row){
                    ?>
                    <div class="col-lg-6 mb-5 ftco-animate">
                        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php

                                $image = executeResult("SELECT * FROM image WHERE plant_id = $pid");
                                foreach ($image as $i) {

                                    echo '
    
                                                <div class="carousel-item active" data-bs-interval="10000">
                                                    <img src="' . $i['image_path'] . '" class="d-block w-100" style="height: 70vh;" alt="...">
                                                </div>
                
                                         ';
                                }

                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>



                    </div>
                    <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                        <h3 style="font-size: 100px;"><?= $product_result['name'] ?></h3>
                        <div class="rating d-flex">
                            <p class="text-left mr-4">
                            <p class="mr-2">5.0</p>
                            <div class="star">
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star "></i>
                                <i class="bx bxs-star "></i>
                                <i class="bx bxs-star "></i>
                            </div>
                            </p>

                            <p class="text-left mr-4">
                            <p class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></p>
                            </p>
                            <p class="text-left mr-4">
                            <p class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></p>
                            </p>
                        </div>
                        <p class="price"><span>$<td><?= $product_result['price'] ?></td></span> <span style="float: right;">mlemmmmmmmm</span></p>
                        <p>
                            <?= $product_result['description']; ?>
                        </p>
                        <form method="post" action="cart.php">
                            <div class="row mt-4">


                                <div class="w-100"></div>
                                <div class="input-group col-md-6 d-flex mb-3">
                                    <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                        <i class="ion-ios-remove"></i>
                                    </button>

                                    <!-- đặt input ở đây -->
                                    <input type="hidden" name="pid" value="<?= $pid ?>">
                                    <input type="number" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">


                                    <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                        <i class="ion-ios-add"></i>
                                    </button>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-12">
                                    <p style="color: #000;padding-left:1%;">10 piece available</p>
                                </div>
                            </div>
                            <p>
                                <?php
                                if (isset($_SESSION['user'])) {
                                    echo '<button type="submit" class="btn btn-outline-success py-3 px-4" style="width:100%;" name="add-cart">Add to Cart</button>';
                                } else {
                                    echo '<a href="user-login.php" class="btn btn-outline-success py-3 px-4" style="width:100%;">Add to Cart</a>';
                                }

                                ?>
                            </p>
                        </form>

                    </div>





                    <div class="container">
                        <div class="row">
                            <div class="mt-3 col-lg-3 col-sm-12">
                                <h3>𝓡𝓮𝓿𝓲𝓮𝔀</h3>
                                <p>Reviews of previous people.</p>

                                <button type="button" class="btn btn-seccess" data-bs-toggle="modal" data-bs-target="#myModal">
                                    + New review
                                </button>
                            </div>

                            <div class="col-lg-9 col-sm-12">





                                <hr style="margin: 15px 80px;">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="card" style="border: none">
                                            <div class="card-header">
                                                <!-- <i class="fas fa-star mr-1"></i> -->

                                                <i class="bx bxs-star checked" id="submit_star_1" data-rating="1"></i>
                                                <i class="bx bxs-star checked" id="submit_star_2" data-rating="2"></i>
                                                <i class="bx bxs-star" id="submit_star_3" data-rating="3"></i>
                                                <i class="bx bxs-star" id="submit_star_4" data-rating="4"></i>
                                                <i class="bx bxs-star" id="submit_star_5" data-rating="5"></i>

                                            </div>
                                            <div class="card-body">
                                                <div class="review-header">
                                                    <strong>Name (</strong><small style="text-transform:lowercase;">cmt</small>)
                                                </div>
                                                <p>review. . . </p>
                                            </div>

                                            <div class="card-footer" style="font-size:13px;width:100%;">On 19/07/2003

                                                <div style="float: right;">
                                                    <a style="text-decoration: none;" href="">
                                                        <button class="btn">
                                                            <i class='bx bxs-trash-alt'></i>
                                                        </button>
                                                    </a> |

                                                    <a style="text-decoration: none;" href="">
                                                        <button class="btn" type="button" name="edit_review" id="edit_review">
                                                            <i class='bx bx-edit'></i>
                                                        </button>
                                                    </a>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>








                            </div>
                        </div>
                    </div>
















                    <!-- The Modal -->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">𝓨𝓸𝓾𝓻 𝓻𝓮𝓿𝓲𝓮𝔀 ~</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">


                                    <h4 class="mt-2 mb-4">
                                        <i class="bx bxs-star checked" id="submit_star_1" data-rating="1"></i>
                                        <i class="bx bxs-star checked" id="submit_star_2" data-rating="2"></i>
                                        <i class="bx bxs-star" id="submit_star_3" data-rating="3"></i>
                                        <i class="bx bxs-star" id="submit_star_4" data-rating="4"></i>
                                        <i class="bx bxs-star" id="submit_star_5" data-rating="5"></i>
                                    </h4>



                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>


                                    <div class="input-group">
                                        <span class="input-group-text">With textarea</span>
                                        <textarea class="form-control" aria-label="With textarea"></textarea>
                                    </div>

                                    <br>

                                    <div class="g-recaptcha" data-sitekey="6Le6YLAmAAAAADt-BWjqFOTkwFGnM38b-YAiCoW5"></div><br>

                                    <div class="form-group text-center mt-4">
                                        <button type="button" class="btn review-btn" id="save_review">Submit Review</button>
                                        <button type="button" class="btn review-btn" onclick="closeForm()">Cancel</button>

                                    </div>

                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <p style="text-align: l;">𝓣𝓱𝓪𝓷𝓴 𝔂𝓸𝓾 𝓯𝓸𝓻 𝔂𝓸𝓾𝓻 𝓻𝓮𝓿𝓲𝓮𝔀.</p>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </section>







        <br><br><br>
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