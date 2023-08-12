<?php
require_once("../db/dbhelper.php");
$id = $_GET['id'];
$plants = executeSingleResult("SELECT * FROM plants WHERE plant_id = $id");
$plant_id = $plants['plant_id'];
$category = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plants['category_id']}")['name'];
$image = executeResult("SELECT * FROM image WHERE plant_id = $plant_id");
$inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = $plant_id")['quantity'];
if (isset($_POST['edit'])) {
    $cate_id = $_POST['cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    execute("UPDATE plants SET category_id = $cate_id, name = '$name', description = '$description', price = $price WHERE plant_id = $plant_id");
    execute("UPDATE inventory SET quantity = $quantity WHERE plant_id = $plant_id");
    header('Location: ../plants.php');
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

            <div class="">

                <h1>Category Edit</h1>
                <form action="" method="post" enctype="multipart/form-data" class="row">
                    <input type="hidden" name="cate_id" value="<?= $id ?>">
                    <div class="mb-3 mt-3">
                        <label for="email">Category:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" value="<?= $plants['name'] ?>" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description">Name:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" value="<?= $plants['name'] ?>" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" value="<?= $plants['description'] ?>" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="description">Price:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" value="<?= $plants['price'] ?>" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Plant's quantity:</label>
                        <input type="text" class="form-control" id="quantity" placeholder="Enter description" name="quantity" value="<?= $inventory ?>">
                    </div>
                    <div class="mb-3">
                        <label for="image">Images:</label>
                        <input type="file" class="form-control" id="image" placeholder="Enter description" name="image[]" multiple>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="row">
                            <?php
                            $count = 0;
                            foreach ($image as $r) {
                                if ($count % 3 == 0) {
                                    echo '</div><div class="row">';
                                }
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <img src="../<?php echo $r['image_path'] ?>" alt="Product Image" class="img-fluid">
                                </div>
                            <?php
                                $count++;
                            }
                            ?>
                        </div>
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary mt-3">Edit</button>
                </form>
        </table>
        </div>
    </section>

    <script src="script.js"></script>
</body>

</html>