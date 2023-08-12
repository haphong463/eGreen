<?php
require_once('../db/dbhelper.php');

$perPage = 6;

// Trang hiện tại, mặc định là 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính chỉ mục bắt đầu của dữ liệu trên trang hiện tại
$start = ($page - 1) * $perPage;

$sql = "SELECT * FROM blog_category ORDER BY blog_category_id DESC LIMIT $start, $perPage";
$blogCate = executeResult($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin Dashboard Panel</title>

    <!-- search -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <div class="top">
            <i class="uil uil-bars slidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for words ..">
            </div>

            <img src="image/logo.png" alt="">
        </div>

        <table class="table">

            <br><br><br>
            <h1>Blog Category</h1>

            <div class="container">

                <h2 style="float: right;"><button type="button" class="btn btn-outline-info"><a style="text-decoration: none;" href="b-category-add.php">Add</a></button></h2>

                <thead>
                    <tr>
                        <th scope="col">Blog Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="myTable">
                    <?php
                    if ($blogCate != null) {
                        foreach ($blogCate as $b) {
                    ?>
                            <tr>
                                <td><?php echo $b['name'] ?></td>
                                <td><?php $content = $b['description'];
                                    echo strlen($content) > 30 ? substr($content, 0, 30) . "..." : $content; ?></td>
                                <!-- echo strlen($content) > 30 ? substr($content, 0, 30) . "..." : $content; -->
                                <td>
                                    <a href="b-category-delete.php?id=<?php echo $b['blog_category_id']; ?>">
                                        <button class="btn btn-danger"><i class="fas fa-times">delete</i></button>
                                    </a>


                                    <a href="b-category-update.php?blog_category_id=<?php echo $b['blog_category_id']; ?>">
                                        <button class="btn btn-info"><i class="fas fa-eye">edit</i></button>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </div>

        </table>

        <!-- hiển thị phân trang -->
        <div class="pagination">
            <?php
            // Câu truy vấn SQL để lấy tổng số dòng dữ liệu
            $sql_count = "SELECT COUNT(*) AS total FROM blog";
            $result = executeSingleResult($sql_count);
            $totalRows = $result['total'];

            // Tính tổng số trang
            $totalPages = ceil($totalRows / $perPage);

            // Hiển thị các liên kết phân trang
            for ($i = 1; $i < $totalPages; $i++) {
                echo '<a class="btn btn-info" href="?page=' . $i . '">' . $i . '</a>';
            }
            ?>
        </div>
    </section>

    <script src="script.js"></script>

    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>