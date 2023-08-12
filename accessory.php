<?php
session_start();
require_once('db/dbhelper.php');
$sql_accessory = "SELECT * FROM accessory";

$cate = isset($_GET['cat_id']) ? $_GET['cat_id'] : null;
// $sqlSearchCate = '';
if (isset($_GET['keyword2'])) {
    $sql_accessory = "SELECT * FROM accessory WHERE name like '%{$_GET['keyword2']}'";
}

$accessory = executeResult($sql_accessory);
$totalProducts = count($accessory);
$limit = 6;
$totalPages = ceil($totalProducts / $limit);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $limit;

$sql_accessory .= " LIMIT $limit OFFSET $offset";
$accessory = array_slice($accessory, $offset, $limit);

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
    /* Add this CSS to your existing <style> section */
    .block-27 ul {
        padding: 0;
        /* Remove default padding */
        list-style-type: none;
        /* Remove bullet points */
        display: flex;
        /* Display the list items in a row */
        justify-content: center;
        /* Center the list items horizontally */
        align-items: center;
        /* Center the list items vertically */
    }

    .block-27 ul li {
        margin: 0 5px;
        /* Add some spacing between the list items */
    }

    .block-27 ul li a {
        text-decoration: none;
        color: white;
        /* Change the color of the links */
        padding: 8px;
    }

    .block-27 ul li a.active {
        font-weight: bold;
        /* Highlight the active link */
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

                    <h1 class="shopName">Accessory</h1>
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

                            <h3 class="mb-4 billing-heading" style="padding-top: 20%;font-size:40px;text-align:center ;">Search</h3>
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="firstname" style="font-size:23px;">Plant</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="keyword2" class="form-control" placeholder="search name here">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstname">ℕ𝕦𝕞𝕓𝕖𝕣</label>
                                        <input type="number" name="searchAge" class="form-control" placeholder="search from here on up">
                                    </div>
                                </div> -->

                            </div>
                            <br><br>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <h6 class="billing-heading" style="float: left;color: rgb(156, 255, 212);" for="maxPrice">Price </h6>
                                    <div style="float: right;" class="select-wrap">
                                        <select name="maxPrice" class="form-control">
                                            <option value="99999">ALL</option>
                                            <option value="100">100</option>
                                            <option value="300">300</option>
                                            <option value="500">500</option>
                                            <option value="700">700</option>
                                            <option value="900">900</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <br><br><br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h6 class="billing-heading" style="float: left;color: rgb(156, 255, 212);" for="cate_id">Category</h6>
                                    <div style="float: right;" class="select-wrap">
                                        <select name="cate_id" class="form-control">

                                            <option value="all">ALL</option>
                                            <?php
                                            //foreach ($cates as $cate) {
                                            ?>
                                                <option value="<?php //echo $cate['category_id']; 
                                                                ?>"><?php //echo $cate['name']; 
                                                                    ?></option>
                                            <?php
                                            //}
                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br><br><br><br> -->
                            <button type="submit" class="btn btn-outline-success" style="width:100%;font-size:13px;color: rgb(156, 255, 212);">S E A R C H</button>
                        </form>

                    </div>
                </div>

                <div class="col-9">
                    <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
                        <div class="container">
                            <h1>All Products In Store</h1>
                            <div class="row" style="margin-top: 50px;">
                                <?php
                                // Số sản phẩm trên mỗi trang
                                foreach ($accessory as $plant) {
                                    $image = executeSingleResult("SELECT min(id) as image2, image FROM image2 WHERE acc_id = {$plant['accessory_id']}")['image'];
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
                                                    <a href="acc-detail.php?pid=' . $plant['accessory_id'] . '"><img src="' . $image . '" alt=""></a>
                                                        <div class="card-body">
                                                        <h3>' . (strlen($plant['name']) > 17 ? substr($plant['name'], 0, 17) . "..." : $plant['name']) . ' </h3>
                                                        <div class="star">
                                                            <i class="bx bxs-star checked"></i>
                                                            <i class="bx bxs-star checked"></i>
                                                            <i class="bx bxs-star "></i>
                                                            <i class="bx bxs-star "></i>
                                                            <i class="bx bxs-star "></i>
                                                        </div>
                                                        <p>' . (strlen($plant['description']) > 50 ? substr($plant['description'], 0, 50) . "..." : $plant['description']) . '</p>
                                                     <h6>' . $plant['price'] . '<span><button>Add Cart</button></span></h6>
                                                        </div>
                                                </div>
                                            </div>
                            ';
                                }

                                ?>


                            </div>




                            <div class="row mt-5">

                                <div class="col text-center">
                                    <div class="block-27">
                                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                            <a href="?page=<?php echo $i; ?>&cate_id=<?php echo $cate; ?>" <?php if ($i == $currentPage) echo 'class="active mlem"'; ?>><?php echo $i; ?></a>
                                        <?php endfor; ?>
                                    </div>
                                </div>

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







    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>













<!-- 
<div class="col-9">
    <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
        <div class="container">
            <h1>All Accessory In Store</h1>
            <div class="row" style="margin-top: 50px;">
                <?php

                // foreach ($accessory as $plant) {
                //     $image = executeSingleResult("SELECT min(id) as image2, image FROM image2 WHERE acc_id = {$plant['accessory_id']}")['image'];

                //     echo '

                //             <div class="col-md-4 py-4 py-md-3">
                //             <div class="card">
                //                 <div class="overlay">
                //                     <button type="button" class="btn btn-secondary" title="Quick View">
                //                         <i class=\'bx bx-show\'></i>
                //                     </button>
                //                     <button type="button" class="btn btn-secondary" title="Add to Wishlish">
                //                         <i class=\'bx bxs-heart\></i>
                //                     </button>
                //                     <button type="button" class="btn btn-secondary" title="Add to Cart">
                //                         <i class=\bx bxs-shopping-bag\'></i>
                //                     </button>
                //                 </div>
                //                 <a href="product-detail.php?pid=' . $plant['accessory_id'] . '"><img src="' . $image . '" alt=""></a>
                //                     <div class="card-body">
                //                     <h3>' . (strlen($plant['name']) > 17 ? substr($plant['name'], 0, 17) . "..." : $plant['name']) . ' </h3>
                //                     <div class="star">
                //                         <i class="bx bxs-star checked"></i>
                //                         <i class="bx bxs-star checked"></i>
                //                         <i class="bx bxs-star "></i>
                //                         <i class="bx bxs-star "></i>
                //                         <i class="bx bxs-star "></i>
                //                     </div>
                //                     <p>' . (strlen($plant['description']) > 50 ? substr($plant['description'], 0, 50) . "..." : $plant['description']) . '</p>
                //                  <h6>' . $plant['price'] . '<span><button>Add Cart</button></span></h6>
                //                     </div>
                //             </div>
                //         </div>

                //             ';
                // }

                ?>


            </div> -->