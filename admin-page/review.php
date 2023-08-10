<?php
require_once('../db/dbhelper.php');

$perPage = 5;

// Trang hiện tại, mặc định là 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính chỉ mục bắt đầu của dữ liệu trên trang hiện tại
$start = ($page - 1) * $perPage;

$sql = "SELECT * FROM review_table ORDER BY datetime DESC LIMIT $start, $perPage";
$review = executeResult($sql);

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
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>


        <table class="table">

            <br><br><br>
            <h1>Review</h1>

            <div class="container">

                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Review</th>
                        <th scope="col">Datetime</th>
                        <th scope="col">Plant_id</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($review != null) {
                        foreach ($review as $r) {
                    ?>

                            <td><?php echo $r['user_name'] ?></td>
                            <td><?php echo $r['user_rating'] ?></td>
                            <td><?php $review = $r['user_review'];
                                echo strlen($review) > 50 ? substr($review, 0, 50) . "..." : $review; ?></td>
                            <td><?php $timestamp = $r['datetime'];
                                echo $datetime = date('Y-m-d ', $timestamp); ?></td>
                            <td><?php echo $r['plant_id'] ?></td>
                            <td>
                                <?php if ($r['status'] == 0) {
                                    echo 'Show';
                                } else {
                                    echo 'Hide';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="process/review-delete.php?review_id=<?php echo $r['review_id']; ?>">
                                    <button class="btn btn-danger"><i class="fas fa-times">delete</i></button>
                                </a>


                                <a href="review-update.php?review_id=<?php echo $r['review_id']; ?>">
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
                                            $sql_count = "SELECT COUNT(*) AS total FROM review_table";
                                            $result = executeSingleResult($sql_count);
                                            $totalRows = $result['total'];

                                            // Tính tổng số trang
                                            $totalPages = ceil($totalRows / $perPage);

                                            // Hiển thị các liên kết phân trang
                                            for ($i = 1; $i <= $totalPages; $i++) {
                                                echo '<a class="btn btn-info" href="?page=' . $i . '">' . $i . '</a>';
                                            }
                                            ?>
                                        </div>
    </section>

    <script src="script.js"></script>
</body>

</html>