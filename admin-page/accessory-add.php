<?php
require_once("../db/dbhelper.php");
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    execute("INSERT INTO accessory (name, description, price) VALUES ('$name', '$description', $price)");

    $max_id = executeSingleResult("SELECT max(accessory_id) as max FROM accessory")['max'];
  
    execute("INSERT INTO acc_inventory (acc_id, quantity, created_at) VALUES ($max_id, $quantity, NOW())");
    $takeid = $max_id;
    include('uploadImage2.php');
    header('Location: accessory.php');
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

                <h1>Accessory Add</h1>
                <form action="" method="post" enctype="multipart/form-data">
                
                    <div class="mb-3 mt-3">
                        <label for="email">Accessory name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description">Accessory description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="price">Accessory price:</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter description" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Accessory quantity:</label>
                        <input type="text" class="form-control" id="quantity" placeholder="Enter description" name="quantity">
                    </div>
                    <div class="mb-3">
                        <label for="image">Accessory image:</label>
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