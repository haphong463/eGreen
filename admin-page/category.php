<?php
session_start();
require_once('../db/dbhelper.php');
//đăng nhập mới vô dc index adminpage!!!!!
if (isset($_SESSION['admin'])) {
  $admin = $_SESSION['admin'];
  $admin_id = $admin['user_id'];
  $sql = "SELECT * FROM users where user_id = '$admin_id'";
  $Check_Role = executeSingleResult($sql);
} else {
  header("location:../login.php");
}
$categories_list = executeResult("SELECT * FROM categories");
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

            echo '
              
              <tr>
              <td><img width="100px" height="100px" src=../' . $category['image'] . '></td>
            <td>' . $category['name'] . '</td>
            <td>' . $category['description'] . '</td> ';
            if ($Check_Role['role'] == 1) {
              echo ' <td>  <a href="category-edit.php?id=' . $category['category_id'] . '"><button type="button" class="btn btn-primary">Edit</button></a>
              <a href="process/delete.php?delete_cat=' . $category['category_id'] . '"><button type="button" class="btn btn-danger">Delete</button></a>
            </td>
          </tr>

              ';
            }
          }
          ?>
        </tbody>
    </table>
    </div>
  </section>

  <script src="script.js"></script>
</body>

</html>