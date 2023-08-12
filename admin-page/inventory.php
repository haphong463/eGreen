<?php
require_once('../db/dbhelper.php');
$plants = executeResult("SELECT * FROM plants");
$check_date = executeResult("
    SELECT p.*
    FROM plants p
    LEFT JOIN order_details od ON p.plant_id = od.plant_id
    LEFT JOIN orders o ON od.order_id = o.order_id
    WHERE o.order_date IS NULL OR o.order_date <= DATE_SUB(NOW(), INTERVAL 7 DAY) LIMIT 5
");
$check_inventory = executeResult("SELECT * FROM plants as p INNER JOIN inventory as i ON p.plant_id = i.plant_id WHERE i.quantity < 5 LIMIT 5");
$check___inventory = executeResult("SELECT * FROM plants as p INNER JOIN inventory as i ON p.plant_id = i.plant_id WHERE i.quantity > 20 LIMIT 5");
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
    <style>
        .table-container {
            min-height: 20vh;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>
        <div class="container-fluid row">

            <div class="col-6">
                <div class="table-container">
                    <table class="table">

                        <br><br><br>
                        <h1>Plants</h1>
                        <thead>
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($check_date as $plant) {
                                $cate_name = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plant['category_id']}")['name'];
                                $inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = {$plant['plant_id']}")['quantity'];
                                echo '

            <tr>
                <th scope="row">' . $cate_name . '</th>
                <td>' . $plant['name'] . '</td>
                <td>' . $inventory . '</td>
                <td>' . $plant['price'] . '</td>

            </tr>
        ';
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="col-6">
                <table class="table">

                    <br><br><br>
                    <h1>Out of stock</h1>
                    <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($check_inventory as $plant) {
                            $cate_name = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plant['category_id']}")['name'];
                            $inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = {$plant['plant_id']}")['quantity'];
                            echo '
        
                        <tr>
                        <th scope="row">' . $cate_name . '</th>
                        <td>' . $plant['name'] . '</td>
                        <td>' . $inventory . '</td>
                        <td>' . $plant['price'] . '</td>

                    </tr>

                        ';
                        }
                        ?>
                    </tbody>

                </table>
            </div>
            <div class="col-6">
                <table class="table">

                    <br><br><br>
                    <h1>Out of stock</h1>
                    <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($check___inventory as $plant) {
                            $cate_name = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plant['category_id']}")['name'];
                            $inventory = executeSingleResult("SELECT * FROM inventory WHERE plant_id = {$plant['plant_id']}")['quantity'];
                            echo '
        
                        <tr>
                        <th scope="row">' . $cate_name . '</th>
                        <td>' . $plant['name'] . '</td>
                        <td>' . $inventory . '</td>
                        <td>' . $plant['price'] . '</td>

                    </tr>

                        ';
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>

    </section>

    <script src="script.js"></script>
</body>

</html>