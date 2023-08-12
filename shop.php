    <?php
    session_start();
    require_once('db/dbhelper.php');

    // Trang hiện tại, mặc định là 1
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';


    $sql_transaction = "SELECT * FROM plants";

    $minPrice = isset($_GET['min']) ? $_GET['min'] : null;
    $maxPrice = isset($_GET['max']) ? $_GET['max'] : null;
    $cate = isset($_GET['cate_id']) ? $_GET['cate_id'] : null;
    $most_view = isset($_GET['most_view']) ? $_GET['most_view'] : null;
    if ($cate) {
        $sql_transaction .= " WHERE category_id = $cate";
        if (($minPrice) && ($maxPrice)) {
            $sql_transaction .= " and (price between $minPrice and $maxPrice)";
        }
    }

    if ($most_view) {
        $sql_transaction = "
        SELECT p.*, COUNT(r.review_id) AS review_count
        FROM plants AS p
        LEFT JOIN review_table AS r ON p.plant_id = r.plant_id
        GROUP BY p.plant_id HAVING review_count > 0
        ORDER BY review_count DESC
        ";
    }

    $plants = executeResult($sql_transaction);
    $totalProducts = count($plants);
    $limit = 6;
    $totalPages = ceil($totalProducts / $limit);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $limit;

    $sql_transaction .= " LIMIT $limit OFFSET $offset";
    $plants = array_slice($plants, $offset, $limit);
    /// min price, max price
    $sql_min_price = "SELECT MIN(CASE WHEN sale > 0 THEN sale ELSE price END) AS min_price FROM plants";
    $result_min_price = executeSingleResult($sql_min_price);
    $min_price = $result_min_price['min_price'];
    $sql_max_price = "SELECT MAX(CASE WHEN sale > 0 THEN sale ELSE price END) AS max_price FROM plants";
    $result_max_price = executeSingleResult($sql_max_price);
    $max_price = $result_max_price['max_price'];

    echo '<script>
        var minPrice = ' . $min_price . ';
        var maxPrice = ' . $max_price . ';
    </script>';

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            #minprice,
            #maxprice {
                font-size: 24px;
            }

            .mlem {
                text-decoration: none;
                font-size: 19px;
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

                        <h1 class="shopName">Shop</h1>
                        <div class="header-row__button">
                            <a href="#" class="btn"></a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- home Section End-->
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="sidebar">


                            <!-- search name -->
                            <form action="" method="get" class="search-form">

                                <h3 class="mb-4 billing-heading" style="padding-top: 20%; color: #333;font-size:40px;text-align:center ;">Search</h3>


                        </div>
                        <br><br>

                        <div class="col-md-12">
                            <div class="form-group">
                                <h6 class="billing-heading" style="float: left;" for="cate_id">Category</h6>
                                <div style="float: right;" class="select-wrap">
                                    <select name="cate_id" class="form-control">
                                        <?php
                                        $cates = executeResult("SELECT * FROM categories");
                                        foreach ($cates as $catess) {
                                        ?>
                                            <option <?php if ($cate == $catess['category_id']) {
                                                        echo 'selected ';
                                                    } ?> value="<?php echo $catess['category_id']; ?>"><?php echo $catess['name']; ?></option>
                                        <?php
                                        }
                                        ?>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br><br><br>
                        <input type="hidden" name="min" id="minPrice" value="<?php echo isset($_GET['min']) ? $_GET['min'] : ''; ?>">
                        <input type="hidden" name="max" id="maxPrice" value="<?php echo isset($_GET['max']) ? $_GET['max'] : ''; ?>">
                        <div id="slider" class="mt-5 mb-5"></div>
                        <div class="text-center mb-3">
                            <span id="minprice"></span> - <span id="maxprice"></span>
                        </div>

                        <button type="submit" class="btn btn-outline-success" style="width:100%;font-size:13px;">Search</button>

                        </form>

                        <button id="mostViewButton" class="btn btn-primary mt-3 mb-3">Most Reviewed Products</button>


                    </div>
                    <div class="col-9">
                        <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
                            <div class="container">
                                <h1>All Products In Store</h1>
                                <div class="row" style="margin-top: 50px;">
                                    <?php

                                    if ($plants != null) {
                                        foreach ($plants as $plant) {
                                            $image = executeSingleResult("SELECT min(image_id) as image, image_path FROM image WHERE plant_id = {$plant['plant_id']}")['image_path'];
                                            $__price = ''; // Khởi tạo $__price
                                            if ($plant['sale'] != NULL && $plant['sale'] > 0) {
                                                $__price = '<del>' . $plant['price'] . '</del> ' . $plant['sale'] . '';
                                            } else {
                                                $__price = $plant['price'];
                                            }
                                            echo '
                                    
                                    <div class="col-md-4 py-4 py-md-3">
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
                                        <a href="product-detail.php?pid=' . $plant['plant_id'] . '"><img src="' . $image . '" alt=""></a><div class="card-body">
                                        <h3>' . $plant['name'] . '</h3>
                                        <div class="star">
                                            <i class="bx bxs-star checked"></i>
                                            <i class="bx bxs-star checked"></i>
                                            <i class="bx bxs-star "></i>
                                            <i class="bx bxs-star "></i>
                                            <i class="bx bxs-star "></i>
                                        </div>
                                        <h6>' . $__price . '<span><button>Add Cart</button></span></h6>
                                    </div>
                            </div>
                        </div>
    
                            ';
                                        }
                                    }

                                    ?>


                                </div>
                            </div>

                            <div class="col text-center">
                                <div class="block-27">
                                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                        <a href="?page=<?php echo $i; ?>&cate_id=<?php echo $cate; ?>&min=<?php echo $minPrice; ?>&max=<?php echo $maxPrice; ?>" <?php if ($i == $currentPage) echo 'class="active mlem"'; ?>><?php echo $i; ?></a>
                                    <?php endfor; ?>
                                </div>
                            </div>


                        </section>
                    </div>

                </div>
            </div>






            <br><br><br><br><br>



            <?php
            include('part/footer.php');
            ?>


            <a href="#" class="arrow">
                <i class='bx bx-up-arrow-alt'></i>
            </a>
        </div>





        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>

        <script>
            document.getElementById('mostViewButton').addEventListener('click', function() {
                // Redirect to the same page with the 'most_view' parameter set to 'true'
                window.location.href = '?most_view=true';
            });
        </script>

        <script>
            // Khởi tạo thanh slider
            var slider = document.getElementById('slider');
            var minPriceInput = document.getElementById('minPrice');
            var maxPriceInput = document.getElementById('maxPrice');
            var minPriceDisplay = document.getElementById('minprice');
            var maxPriceDisplay = document.getElementById('maxprice');
            var minPriceValue = parseFloat(minPriceInput.value); // Sử dụng parseFloat thay vì parseInt
            var maxPriceValue = parseFloat(maxPriceInput.value); // Sử dụng parseFloat thay vì parseInt
            
            noUiSlider.create(slider, {
                start: [<?= isset($_GET['min']) ? $_GET['min'] : "minPrice" ?>, <?= isset($_GET['max']) ? $_GET['max'] : "maxPrice" ?>],
                connect: true,
                range: {
                    'min': minPrice,
                    'max': maxPrice
                }
            });
            // Cập nhật giá trị hiển thị ban đầu
            minPriceDisplay.innerText = "$" + minPriceValue.toFixed(2); // Sử dụng toFixed(2) để hiển thị 2 chữ số sau dấu phẩy
            maxPriceDisplay.innerText = "$" + maxPriceValue.toFixed(2); // Sử dụng toFixed(2) để hiển thị 2 chữ số sau dấu phẩy

            // Xử lý sự kiện khi giá trị slider thay đổi
            slider.noUiSlider.on('change', function(values, handle) {
                // Lấy giá trị từ slider
                var min = parseFloat(values[0]); // Sử dụng parseFloat thay vì parseInt
                var max = parseFloat(values[1]); // Sử dụng parseFloat thay vì parseInt

                // Cập nhật giá trị trong input hidden
                minPriceInput.value = min;
                maxPriceInput.value = max;
                minPriceValue = min;
                maxPriceValue = max;

                // Cập nhật giá trị hiển thị
                minPriceDisplay.innerText = "$" + minPriceValue.toFixed(2); // Sử dụng toFixed(2) để hiển thị 2 chữ số sau dấu phẩy
                maxPriceDisplay.innerText = "$" + maxPriceValue.toFixed(2); // Sử dụng toFixed(2) để hiển thị 2 chữ số sau dấu phẩy
            });
        </script>


        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

    </body>

    </html>