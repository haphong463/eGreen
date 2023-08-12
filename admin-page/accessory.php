<?php
require_once('../db/dbhelper.php');
$acc = executeResult("SELECT * FROM accessory");
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
            <h1>Accessory</h1>

            <div class="container">

                <h2 style="float: right;"><button type="button" class="btn btn-outline-info"><a href="accessory-add.php">Add</a></button></h2>

                <thead>
                    <tr>
                        
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($acc as $accs) {
                        //$cate_name = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plant['category_id']}")['name'];
                        $price = $accs['price'];
                        echo '
                        
                        <tr>
                       
                        <td>' . $accs['name'] . '</td>
                        <td>' . $price . '</td>
                        <td>
                             <button type="button" class="btn btn-outline-primary"><a href="process/delete.php?delete_acc=' . $accs['accessory_id'] . '">Delete</a></button>
                             <button type="button" class="btn btn-outline-secondary"><a href="accessory-edit.php?id=' . $accs['accessory_id'] . '">Edit</a></button>
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
</body>

</html>