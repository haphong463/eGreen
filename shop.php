    <?php
    session_start();
    require_once('db/dbhelper.php');

    // Trang hiện tại, mặc định là 1
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    $sql_transaction = "SELECT * FROM plants";

    $minPrice = isset($_GET['min']) ? $_GET['min'] : null;
    $maxPrice = isset($_GET['max']) ? $_GET['max'] : null;
    $cate = isset($_GET['cate_id']) ? $_GET['cate_id'] : null;

    if ($cate) {
        $sql_transaction .= " WHERE category_id = $cate";
        if (($minPrice) && ($maxPrice)) {
            $sql_transaction .= " and (price between $minPrice and $maxPrice)";
        }
    }






    // switch ($sort) {
    //     case 'price_asc':
    //         $sql_transaction .= " ORDER BY CASE WHEN sale > 0 THEN sale ELSE price END ASC";
    //         break;
    //     case 'price_desc':
    //         $sql_transaction .= " ORDER BY CASE WHEN sale > 0 THEN sale ELSE price END DESC";
    //         break;
    //     case 'name_asc':
    //         $sql_transaction .= " ORDER BY name ASC";
    //         break;
    //     case 'name_desc':
    //         $sql_transaction .= " ORDER BY name DESC";
    //         break;
    //         // Thêm các trường hợp sắp xếp khác ở đây (nếu cần)
    //     default:
    //         // Sắp xếp mặc định nếu không có yêu cầu
    //         $sql_transaction .= " ORDER BY plant_id DESC";
    // }

    // Thêm các điều kiện lọc khác vào câu truy vấn tương tự

    // Tính chỉ mục bắt đầu của dữ liệu trên trang hiện tại
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
                                <!-- <div class="row align-items-end">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="firstname" style="color: rgb(156, 255, 212);">Plant</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" name="keyword" class="form-control" placeholder="search name here">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->




                                <!-- <div class="col-md-12"><div class="form-group">
                                            <label for="firstname">ℕ𝕦𝕞𝕓𝕖𝕣</label>
                                            <input type="number" name="searchAge" class="form-control" placeholder="search from here on up">
                                        </div>
                                    </div> -->

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
                            <span id="minprice">0</span> - <span id="maxprice"></span>
                        </div>

                        <button type="submit" class="btn btn-outline-success" style="width:100%;font-size:13px;color: rgb(156, 255, 212);">S E A R C H</button>

                        </form>


                        <form id="sortForm" action="" method="get">
                            <select name="sort" class="form-control">
                                <option value="price_asc">Price Low to High</option>
                                <option value="price_desc">Price High to Low</option>
                                <option value="name_asc">Name A-Z</option>
                                <option value="name_desc">Name Z-A</option>
                            </select>
                        </form>

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
            // Lắng nghe sự kiện thay đổi lựa chọn trong dropdown
            document.querySelector('select[name="sort"]').addEventListener('change', function() {
                // Gọi hàm submit() của form khi có sự thay đổi
                document.getElementById('sortForm').submit();
            });
        </script>

        <script>
            // Khởi tạo thanh slider
            var slider = document.getElementById('slider');
            var minPriceInput = document.getElementById('minPrice');
            var maxPriceInput = document.getElementById('maxPrice');
            var minPriceDisplay = document.getElementById('minprice');
            var maxPriceDisplay = document.getElementById('maxprice');
            var minPriceValue = parseInt(minPriceInput.value); // ParseInt để chuyển đổi chuỗi thành số nguyên
            var maxPriceValue = parseInt(maxPriceInput.value); // ParseInt để chuyển đổi chuỗi thành số nguyên
            noUiSlider.create(slider, {
                start: [<?= isset($_GET['min']) ? $_GET['min'] : "minPrice" ?>, <?= isset($_GET['max']) ? $_GET['max'] : "maxPrice" ?>],
                connect: true,
                range: {
                    'min': minPrice,
                    'max': maxPrice
                }
            });
            // Cập nhật giá trị hiển thị ban đầu
            minPriceDisplay.innerText = "$" + minPriceValue;
            maxPriceDisplay.innerText = "$" + maxPriceValue;

            // Xử lý sự kiện khi giá trị slider thay đổi
            slider.noUiSlider.on('change', function(values, handle) {
                // Lấy giá trị từ slider
                var min = parseInt(values[0]);
                var max = parseInt(values[1]);

                // Cập nhật giá trị trong input hidden
                minPriceInput.value = min;
                maxPriceInput.value = max;
                minPriceValue = min;
                maxPriceValue = max;

                // Cập nhật giá trị hiển thị
                minPriceDisplay.innerText = "$" + minPriceValue;
                maxPriceDisplay.innerText = "$" + maxPriceValue;
            });
        </script>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

    </body>

    </html>