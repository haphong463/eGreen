<?php
require_once("../db/dbhelper.php");
$categories = executeResult("SELECT * FROM categories");
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $cate_id = $_POST['cate_id'];
    $quantity = $_POST['quantity'];
    execute("INSERT INTO plants (name, description, price, category_id) VALUES ('$name', '$description', $price, $cate_id)");

    $max_id = executeSingleResult("SELECT max(plant_id) as max FROM plants")['max'];
    execute("INSERT INTO inventory (plant_id, quantity, created_at) VALUES ($max_id, $quantity, NOW())");
    $takeid = $max_id;
    include('uploadImage.php');
    // header('Location: plants.php');
}
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>    <title>Admin Dashboard Panel</title>
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

                <h1>Category Add</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="email">Category:</label>
                        <select name="cate_id">
                            <?php
                            foreach ($categories as $cate) {
                                echo '
                                
                                <option value=" ' . $cate['category_id'] . '">' . $cate['name'] . '</option>

                                ';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email">Plant's name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description">Plant's description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="price">Plant's price:</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter description" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Plant's quantity:</label>
                        <input type="text" class="form-control" id="quantity" placeholder="Enter description" name="quantity">
                    </div>
                    <div class="mb-3">
                        <label for="image">Plant's image:</label>
                        <input type="file" class="form-control" id="image" placeholder="Enter description" name="image[]" multiple>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Submit</button>
                </form>
        </table>
        </div>
    </section>

    <script src="script.js"></script>
</body>

</html>