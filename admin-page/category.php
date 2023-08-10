<?php
require_once('../db/dbhelper.php');
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

      <div class="container">

        <h1>Categories</h1>
        <h2 style="float: right;"><button type="button" class="btn btn-outline-info">add</button></h2>

        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          foreach ($categories_list as $category) {
            echo '
              
              <tr>
            <td>' . $category['name'] . '</td>
            <td>' . $category['description'] . '</td>
            <td>
              <button type="button" class="btn btn-outline-primary">delete</button>
              <button type="button" class="btn btn-outline-secondary">edit</button>
            </td>
          </tr>

              ';
          }
          ?>
        </tbody>
    </table>
    </div>
  </section>

  <script src="script.js"></script>
</body>

</html>