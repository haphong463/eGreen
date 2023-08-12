<?php
session_start();
require_once('../db/dbhelper.php');
if (isset($_SESSION['admin'])) {
  $admin = $_SESSION['admin'];
  $admin_id = $admin['user_id'];
  $sql = "SELECT * FROM users where user_id = '$admin_id'";
  $Check_Role = executeSingleResult($sql);
} else {
  header("location:login.php");
}
$perPage = 3;

// Trang hiện tại, mặc định là 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính chỉ mục bắt đầu của dữ liệu trên trang hiện tại
$start = ($page - 1) * $perPage;

$sql = "SELECT * FROM categories ORDER BY created_at DESC LIMIT $start, $perPage";
$categories_list = executeResult($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="admin.css">
  <!-- iconscount link css -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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

      <div class="container-fluid">

        <h1>Categories</h1>
        <h2 style="float: right;"><button type="button" class="btn btn-outline-info"><a href="category-add.php">Add</a></button></h2>

        <thead>
          <tr>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <?php if ($Check_Role['role'] == 1) { ?>
            <th scope="col">Action</th>
            <?php } ?>
          </tr>
        </thead>

        <tbody>
          <?php
          foreach ($categories_list as $category) {
          ?>

            <tr>
              <td><img width="100px" height="100px" src=../<?php echo $category['image'] ?>></td>
              <td><?php echo $category['name'] ?></td>
              <td>
                <?php $cate = $category['description'];
                echo strlen($cate) > 30 ? substr($cate, 0, 30) . "..." : $cate; ?>
              </td>
            <?php  if ($Check_Role['role'] == 1) { ?>
              <td>
                <a href="category-edit.php?id=<?php echo $category['category_id'] ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                <a href="process/delete.php?delete_cat=<?php echo $category['category_id'] ?>"><button type="button" class="btn btn-danger">Delete</button></a>
              </td>
           <?php   } ?>
            </tr>

          <?php
          }
          ?>
        </tbody>
      </div>
    </table>
    <!-- hiển thị phân trang -->
    <div class="pagination">
      <?php
      // Câu truy vấn SQL để lấy tổng số dòng dữ liệu
      $sql_count = "SELECT COUNT(*) AS total FROM categories";
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