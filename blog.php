<?php
require_once 'db/dbhelper.php';

$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$tags = isset($_GET['tag']) ? $_GET['tag'] : '';
// Câu truy vấn SQL
if (!empty($searchKeyword)) {
    $sql = "SELECT * FROM blog 
    WHERE title LIKE '%$searchKeyword%' 
    OR blog_category_id LIKE '%$searchKeyword%' 
    OR content LIKE '%$searchKeyword%' ORDER BY created_at DESC";
} elseif (!empty($tags)) {
    $sql = "SELECT * FROM blog 
    WHERE blog_category_id = $tags ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM blog ORDER BY created_at DESC";
}
// $sql = "SELECT * FROM blog ORDER BY created_at DESC";

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'date_asc':
            $sql = "SELECT * FROM blog ORDER BY created_at ASC";
            break;
        case 'date_desc':
            $sql = "SELECT * FROM blog ORDER BY created_at DESC";
            break;
        case 'most_comment':
            $sql = "SELECT p.*, COUNT(r.blog_id) AS review_count
            FROM blog AS p
            LEFT JOIN comments AS r ON p.blog_id = r.blog_id
            GROUP BY p.blog_id HAVING review_count > 0
            ORDER BY review_count DESC
            ";
            break;
    }
}

$blog_result =  executeResult($sql);

$query = "SELECT * FROM blog ORDER BY RAND() LIMIT 3";
$post_resutl = executeResult($query);

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


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->


</head>
<style>
    /* CSS */
    a {
        text-decoration: none;
    }

    .button-81 {
        background-color: #fff;
        border: 0 solid #e2e8f0;
        border-radius: 1.5rem;
        box-sizing: border-box;
        color: #0d172a;
        cursor: pointer;
        display: inline-block;
        font-family: "Basier circle", -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1.1rem;
        font-weight: 600;
        line-height: 1;
        padding: 1rem 1.6rem;
        text-align: center;
        text-decoration: none #0d172a solid;
        text-decoration-thickness: auto;
        transition: all .1s cubic-bezier(.4, 0, .2, 1);
        box-shadow: 0px 1px 2px rgba(166, 175, 195, 0.25);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
    }

    .button-81:hover {
        background-color: #1e293b;
        color: #fff;
    }

    @media (min-width: 768px) {
        .button-81 {
            font-size: 1.125rem;
            padding: 1rem 2rem;
        }
    }
</style>

<body>






    <?php
    include('part/header.php');
    ?><!-- home Section -->
    <div class="home">

        <div class="header-row">
            <div class="header-row-inside">

                <h1 class="shopName">Blog</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <!-- home Section End-->



    <section>
        <div class="text-center container py-5">
            <h4 class="mt-4 mb-5"><strong>N . E . W</strong></h4>

            <div class="row">

                <div class="col-lg-8">
                    <div class="row">
                        <?php
                        // Định nghĩa số lượng đánh giá trên mỗi trang
                        $blogsPerPage = 4;

                        // Tính toán tổng số trang
                        $totalBlogs = count($blog_result);
                        $totalPages = ceil($totalBlogs / $blogsPerPage);

                        // Xác định trang hiện tại
                        $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($currentpage - 1) * $blogsPerPage;

                        // Lấy một phần danh sách đánh giá dựa trên trang hiện tại và số lượng đánh giá trên mỗi trang
                        $blogsOnPage = array_slice($blog_result, $offset, $blogsPerPage);
                        if ($blogsOnPage != NULL) {

                            foreach ($blogsOnPage as $b) {
                                $bid = $b['blog_id'];
                                // $type = $b['type'];
                                $type = executeSingleResult("SELECT * FROM blog_category WHERE blog_category_id = {$b['blog_category_id']}")['name'];
                                $title = $b['title'];
                                $content = $b['content'];
                                $img = $b['img'];
                        ?>
                                <div class="col-lg-6 col-md-6 mb-5">
                                    <div class="card">

                                        <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                                            <img src="<?php echo $img ?>" style="height: 350px;" class="w-100" />
                                            <a href="#!">
                                                <div class="mask">
                                                    <div class="d-flex justify-content-start align-items-end h-100">
                                                        <h5><span class="badge bg-primary ms-2"><?php echo $type ?></span></h5>
                                                    </div>
                                                </div>
                                                <div class="hover-overlay">
                                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                                </div>
                                            </a>
                                        </div>


                                        <div class="card-body">
                                            <a style="text-decoration: none;" href="blog-detail.php?blog_id=<?php echo $bid ?>" class="text-reset">

                                                <h4 class="card-title mb-3"><?php echo strlen($title) > 35 ? substr($title, 0, 30) . "..." : $title; ?></h4>

                                                <p><?php echo strlen($content) > 70 ? substr($content, 0, 50) . "..." : $content; ?></p>
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            <?php }
                        } else {
                            ?>
                            <div class="col-lg-6 col-md-6 mb-5">
                                <div class="blog-item">
                                    <div class="blog-item-content bg-white p-4">
                                        <h4 class="mt-3 mb-3">No blogs to display</h4>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-4">

                    <?php
                    include('part/blog.php');
                    ?>

                </div>


            </div>

            <div class="row mt-5">
                <div class="col-lg-8">
                    <div class="nav-links">
                        <?php // Hiển thị phân trang
                        echo '<div>';
                        if ($totalPages > 1) {
                            if ($currentpage > 1) {
                                echo '<a href="blog.php?page=' . ($currentpage - 1) . '"><button class="btn review-btn"> Previous </button></a>';
                            }
                            for ($i = 1; $i <= $totalPages; $i++) {

                                echo '<a href="blog.php?page=' . $i . '"><button class="btn review-btn">' . $i . '</button></a>';
                            }
                            if ($currentpage < $totalPages) {
                                echo '<a href="blog.php?page=' . ($currentpage + 1) . '"><button class="btn review-btn"> Next </button></a> ';
                            }
                        }
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php
    include('part/footer.php');
    ?>


    <a href="#" class="arrow">
        <i class='bx bx-up-arrow-alt'></i>
    </a>



    <script>
        // Lắng nghe sự kiện thay đổi lựa chọn trong dropdown
        document.querySelector('select[name="sort"]').addEventListener('change', function() {
            // Gọi hàm submit() của form khi có sự thay đổi
            document.getElementById('sortForm').submit();
        });
    </script>




    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>