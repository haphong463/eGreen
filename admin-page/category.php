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

        <tbody id="myTable">
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