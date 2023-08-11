<?php 
session_start();
require_once('db/dbhelper.php');
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
}
// else{
//     header('location:user-login.php');
// }
$plants = executeResult("SELECT * FROM plants");
if(isset($_POST['addtowishlist'])){
    $p_id = $_POST['plant_id'];
    $sql = "INSERT INTO whistlish (p_id,user_id) VALUES ('$p_id','$user_id')";
    execute($sql);
}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bao gồm tệp JavaScript -->
    
<!-- AJAX -->


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

<body style="background-color: #000000;">






    <?php
    include('part/header.php');
    ?>
    <!-- home Section -->
    <div class="home">

        <div class="header-row">
            <div class="header-row-inside">

                <h1 class="shopName">𝓦𝓮𝓵𝓬𝓸𝓶𝓮</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <!-- home Section End-->









    <!-- <div class="page-content">
            <div id="bigbox">
                <div id="box">
                <img id="imgBox" src="img/header/download.jpg">
                <span style = "font-family:courier,arial,helvetica;">Hard</span>
                </div>
                <div id="box">
                <img id="imgBox" src="img/header/download.jpg">
                <span style = "font-family:courier,arial,helvetica;">Medium</span>
                </div>
            </div>
        </div> -->


    <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
        <div class="container">
            <h1>ℙ 𝕃 𝔸 ℕ 𝕋 𝕊</h1>
            <div class="row" style="margin-top: 50px;">
                                <?php

                                foreach ($plants as $plant) {
                                    $image = executeSingleResult("SELECT min(image_id) as image, image_path FROM image WHERE plant_id = {$plant['plant_id']}")['image_path'];
                                    echo '
                            
                            <div class="col-md-4 py-4 py-md-0">
                            <div class="card">
                                <div class="overlay">
                                    <button type="button" class="btn btn-secondary" title="Quick View">
                                        <i class=\'bx bx-show\'></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary" title="Add to Wishlish">
                                        <i class=\'bx bxs-heart\></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary" title="Add to Cart">
                                        <i class=\bx bxs-shopping-bag\'></i>
                                    </button>
                                </div>
                                <a href="product-detail.php?pid=' . $plant['plant_id'] . '"><img src="' . $image . '" alt=""></a>
                                    <div class="card-body">
                                        <h3>con két</h3>
                                        <div class="star">
                                            <i class="bx bxs-star checked"></i>
                                            <i class="bx bxs-star checked"></i>
                                            <i class="bx bxs-star "></i>
                                            <i class="bx bxs-star "></i>
                                            <i class="bx bxs-star "></i>
                                        </div>
                                        <p>' . $plant['description'] . '</p>
                                        <h6>' . $plant['price'] . '<span><button>Add Cart</button></span></h6>
                                    </div>
                            </div>
                        </div>  
                        <form action="" method="post" class="wishlist-form">
    <input type="hidden" name="plant_id" value="' . $plant['plant_id'] . '">
    <button type="submit" class="btn btn-secondary" title="Add to Wishlist" name="addtowishlist">
        <i class=\'bx bxs-heart\'></i> Add to Wishlist
    </button>
</form>
                            ';
                                }

                                ?>


                            </div>
        </div>
    </section>

    <br><br><br>



    <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
        <div class="container">
            <h1>ℍ 𝕆 𝕋</h1>
            <section class="section-products">
            <div class="container">
                            <h1>All Products In Store</h1>
                            <div class="row" style="margin-top: 50px;">
                                <?php

                                foreach ($plants as $plant) {
                                    $image = executeSingleResult("SELECT min(image_id) as image, image_path FROM image WHERE plant_id = {$plant['plant_id']}")['image_path'];
                                    echo '
                            
                            <div class="col-md-4 py-4 py-md-0">
                            <div class="card">
                                <div class="overlay">
                                    <button type="button" class="btn btn-secondary" title="Quick View">
                                        <i class=\'bx bx-show\'></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary" title="Add to Wishlish">
                                        <i class=\'bx bxs-heart\></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary" title="Add to Cart">
                                        <i class=\bx bxs-shopping-bag\'></i>
                                    </button>
                                </div>
                                <a href="product-detail.php?pid=' . $plant['plant_id'] . '"><img src="' . $image . '" alt=""></a>
                                    <div class="card-body">
                                        <h3>con két</h3>
                                        <div class="star">
                                            <i class="bx bxs-star checked"></i>
                                            <i class="bx bxs-star checked"></i>
                                            <i class="bx bxs-star "></i>
                                            <i class="bx bxs-star "></i>
                                            <i class="bx bxs-star "></i>
                                        </div>
                                        <p>' . $plant['description'] . '</p>
                                        <h6>' . $plant['price'] . '<span><button>Add Cart</button></span></h6>
                                    </div>
                            </div>
                        </div>  
                        <form action="" method="post" class="wishlist-form">
    <input type="hidden" name="plant_id" value="' . $plant['plant_id'] . '">
    <button type="button" class="btn btn-secondary add-to-wishlist-btn" title="Add to Wishlist">
        <i class=\'bx bxs-heart\'></i> Add to Wishlist
    </button>
</form>
                            ';
                                }

                                ?>


                            </div>
                        </div>
            </section>
        </div>
    </section>





    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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