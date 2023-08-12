<?php
require_once 'db/dbhelper.php';
session_start();

if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])) {
    header("Location: index.php");
    exit(); //
}

$pid = $_GET['pid'];
$product_result = executeSingleResult("SELECT * FROM accessory WHERE accessory_id = $pid");
$cate = executeSingleResult("SELECT * FROM categories_ac WHERE  category_id = {$product_result['category_id']}")['name'];
if (!$product_result) {
    header("Location: index.php");
    exit();
}
//review
$review_query = "SELECT * FROM review_acc WHERE accessory_id = $pid and status = 0 ORDER BY datetime desc";
$review_result = executeResult($review_query);
$forbidden_words = executeResult("SELECT * FROM forbidden_words");
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

    <!-- review -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        .progress-label-left {
            float: left;
            margin-right: 0.5em;
            line-height: 1em;
        }

        .progress-label-right {
            float: right;
            margin-left: 0.3em;
            line-height: 1em;
        }

        .star-light {
            color: #e9ecef;
        }

        .mlem {
            text-decoration: none;
            color: black;
            padding: 10px;
            text-align: center;
        }

        .mlem:hover {
            text-decoration: none;
            color: red;
            padding: 8px;

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

                                $image = executeResult("SELECT * FROM image2 WHERE acc_id = $pid");
                                foreach ($image as $i) {

                                    echo '
    
                                                <div class="carousel-item active" data-bs-interval="10000">
                                                    <img src="' . $i['image'] . '" class="d-block w-100" style="height: 70vh;" alt="...">
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

                            <b><span id="average_rating">0.0</span> / 5</b>
                            <div class="mb-3">
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i> (<span id="total_review">0</span> Review)
                            </div>

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

                                <input type="hidden" name="plant_id" value="<?php echo $pid ?>">
                                <button type="button" class="btn btn-seccess" data-bs-toggle="modal" data-bs-target="#myModal">
                                    + New review
                                </button>
                            </div>

                            <div class="col-lg-9 col-sm-12">



                                <div id="review_content">
                                    <hr style="margin: 15px 80px;">
                                    <?php
                                    // Định nghĩa số lượng đánh giá trên mỗi trang
                                    $reviewsPerPage = 5;

                                    // Tính toán tổng số trang
                                    $totalReviews = count($review_result);
                                    $totalPages = ceil($totalReviews / $reviewsPerPage);

                                    // Xác định trang hiện tại
                                    $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $offset = ($currentpage - 1) * $reviewsPerPage;

                                    // Lấy một phần danh sách đánh giá dựa trên trang hiện tại và số lượng đánh giá trên mỗi trang
                                    $reviewsOnPage = array_slice($review_result, $offset, $reviewsPerPage);

                                    $forbiddenWords = executeResult("SELECT list FROM forbidden_words");

                                    foreach ($reviewsOnPage as $review) {

                                        // ... Mã HTML để hiển thị đánh giá
                                        // Truy cập các trường dữ liệu của review bằng cách sử dụng $review['tên trường']
                                        $user_name = $review['user_name'];
                                        $rating = isset($review['user_rating']) ? $review['user_rating'] : 'N/A';
                                        $user_review = $review['user_review'];
                                        $timestamp = $review['datetime'];
                                        // $formatted_review = nl2br($user_review);
                                        $datetime = date('M d, Y', $timestamp);

                                        // tu cam 
                                        $formatted_review = nl2br($user_review);
                                        foreach ($forbiddenWords as $forbiddenWord) {
                                            $word = $forbiddenWord['list'];
                                            if (stripos($formatted_review, $word) !== false) {
                                                $formatted_review = str_ireplace($word, '***', $formatted_review);
                                            }
                                        }
                                    ?>
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <div class="card" style="border: none">
                                                    <div class="card-header">
                                                        <?php
                                                        for ($star = 1; $star <= 5; $star++) {
                                                            $class_name = ($rating >= $star) ? 'text-warning' : 'star-light';
                                                            echo '<i class="fas fa-star ' . $class_name . ' mr-1"></i>';
                                                        } ?>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="review-header">
                                                            <?php echo '<strong>' . $user_name . ' (</strong><small style="text-transform:lowercase;">cmt</small>)'; ?>
                                                        </div>
                                                        <?php echo '<p>' . $formatted_review . '</p>'; ?>
                                                    </div>

                                                    <?php echo '<div class="card-footer" style="font-size:13px;width:100%;"> ' . $datetime ?>

                                                    <div style="float: right;">
                                                        <a style="text-decoration: none;" href="delete-review.php?acc_review_id= <?= $review["review_id"] ?> &pid= <?= $pid ?>">
                                                            <button class="btn">
                                                                <i class='bx bxs-trash-alt'></i>
                                                            </button>
                                                        </a>

                                                        <!-- <a style="text-decoration: none;" href="">
                                                            <button class="btn" type="button" name="edit_review" id="edit_review">
                                                                <i class='bx bx-edit'></i>
                                                            </button>
                                                        </a> -->
                                                    </div>
                                                    <?php echo '</div>'; ?>


                                                </div>
                                            </div>
                                        </div>

                                    <?php }
                                    // Hiển thị phân trang
                                    echo '<div class="pagination">';
                                    if ($totalPages > 1) {
                                        if ($currentpage > 1) {
                                            echo '<a href="?pid=' . $pid . '&page=' . ($currentpage - 1) . '"  class="mlem">Previous</a>';
                                        }
                                        for ($i = 1; $i <= $totalPages; $i++) {

                                            echo '<a href="acc-detail.php?pid=' . $pid . '&page=' . $i . '" class="mlem">' . $i . '</a>';
                                        }
                                        if ($currentpage < $totalPages) {
                                            echo '<a href="acc-detail.php?pid=' . $pid . '&page=' . ($currentpage + 1) . '" class="mlem">Next</a> ';
                                        }
                                    }
                                    echo '</div>';
                                    ?>

                                </div>



                            </div>
                        </div>
                    </div>
















                    <!-- The Modal -->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <?php
                            if (isset($c_id)) {
                                $info = executeSingleResult("SELECT * FROM users WHERE user_id = $c_id");
                            }
                            ?>
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">𝓨𝓸𝓾𝓻 𝓻𝓮𝓿𝓲𝓮𝔀 ~</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <input type="hidden" name="plant_id" id="plant_id" class="form-control" value="<?php echo $pid ?>" />

                                    <h4 class="mt-2 mb-4">
                                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                                    </h4>

                                    <input type="hidden" name="c_id" id="c_id" value="<?php if (isset($info)) {
                                                                                            echo $info['id'];
                                                                                        } ?>">

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" <?php if (isset($_SESSION['user'])) {
                                                                                                                                                                                                    echo 'value="' . $_SESSION['user']['fullname'] . '" readonly';
                                                                                                                                                                                                } ?> />
                                    </div>


                                    <div class="input-group">
                                        <span class="input-group-text">With textarea</span>
                                        <textarea class="form-control" aria-label="With textarea" name="user_review" maxlength="255" id="user_review"></textarea>
                                    </div>

                                    <br>

                                    <div class="g-recaptcha" data-sitekey="6LfOCW0mAAAAAEFxgE1iG_mUt1rVdMQh5C9qP0DX"></div><br>

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

<script>
        $(document).ready(function() {

            var rating_data = 0;
            var isRatingSelected = false;

            $('#add_review').click(function() {

                $('#review_modal').modal('show');

            });

            $(document).on('mouseenter', '.submit_star', function() {

                var rating = $(this).data('rating');
                isRatingSelected = true;

                reset_background();

                for (var count = 1; count <= rating; count++) {

                    $('#submit_star_' + count).addClass('text-warning');

                }

            });

            function reset_background() {
                for (var count = 1; count <= 5; count++) {

                    $('#submit_star_' + count).addClass('star-light');

                    $('#submit_star_' + count).removeClass('text-warning');

                }
            }

            $(document).on('mouseleave', '.submit_star', function() {

                reset_background();

                for (var count = 1; count <= rating_data; count++) {

                    $('#submit_star_' + count).removeClass('star-light');

                    $('#submit_star_' + count).addClass('text-warning');
                }

            });

            $(document).on('click', '.submit_star', function() {

                rating_data = $(this).data('rating');

            });

            $('#save_review').click(function() {
                var user_name = $('#user_name').val();
                var user_review = $('#user_review').val();
                var plant_id = $('#plant_id').val();
                var id = $('#c_id').val();

                if (user_name == '' || user_review == '') {
                    alert("Please Fill Both Fields");
                    return false;
                } else if ((!isRatingSelected)) {
                    alert("Please select a rating");
                    return false;
                } else {
                    var gRecaptchaResponse = $('#g-recaptcha-response').val(); // Lấy giá trị của g-recaptcha-response

                    $.ajax({
                        url: "acc_submit_rating.php",
                        method: "POST",
                        data: {
                            'g-recaptcha-response': gRecaptchaResponse,
                            'rating_data': rating_data,
                            'user_name': user_name,
                            'user_review': user_review,
                            'plant_id': plant_id,
                            'c_id': id
                        },
                        success: function(data) {
                            $('#review_modal').modal('hide');
                            load_rating_data();
                            // alert(data);
                            location.reload();
                        }
                    });
                }
            });

            load_rating_data();

            function load_rating_data() {
                $.ajax({
                    url: "acc_submit_rating.php",
                    method: "POST",
                    data: {
                        action: 'load_data',
                        pid: <?php echo $pid ?>
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#average_rating').text(data.average_rating);
                        $('#total_review').text(data.total_review);

                        var count_star = 0;

                        $('.main_star').each(function() {
                            count_star++;
                            if (Math.ceil(data.average_rating) >= count_star) {
                                $(this).addClass('text-warning');
                                $(this).addClass('star-light');
                            }
                        });

                        $('#total_five_star_review').text(data.five_star_review);

                        $('#total_four_star_review').text(data.four_star_review);

                        $('#total_three_star_review').text(data.three_star_review);

                        $('#total_two_star_review').text(data.two_star_review);

                        $('#total_one_star_review').text(data.one_star_review);

                        $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');

                        $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');

                        $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');

                        $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');

                        $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');


                    }
                })
            }

        });
    </script>
</body>

</html>