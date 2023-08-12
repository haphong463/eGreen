<?php
require_once('../db/dbhelper.php');
$plants = executeResult("SELECT * FROM plants");
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
            <h1>Plants</h1>

            <div class="container">

                <h2 style="float: right;"><button type="button" class="btn btn-outline-info"><a href="plant-add.php">Add</a></button></h2>

                <thead>
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="myTable"> 
                    <?php
                    foreach ($plants as $plant) {
                        $cate_name = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plant['category_id']}")['name'];
                        $price = $plant['sale'] ?? $plant['price'];
                        echo '
                        
                        <tr>
                        <th scope="row">' . $cate_name . '</th>
                        <td>' . $plant['name'] . '</td>
                        <td>' . $plant['description'] . '</td>
                        <td>' . $price . '</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary"><a href="process/delete.php?delete_plant=' . $plant['plant_id'] . '">Delete</a></button>
                            <button type="button" class="btn btn-outline-secondary"><a href="plant-edit.php?id=' . $plant['plant_id'] . '">Edit</a></button>
                        </td>
                    </tr>

                        ';
                    }
                    ?>
                </tbody>
            </div>

        </table>
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