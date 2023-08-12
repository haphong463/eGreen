<?php
require_once ("../db/dbhelper.php");
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    execute("INSERT INTO blog_category (name, description) VALUES ('$name', '$description')");
    header('Location: b-category.php');
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

                <h1>Blog Category Add</h1>
                <form action="" method="post">
                    <div class="mb-3 mt-3">
                        <label for="email">Category Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" name="description">
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Submit</button>
                </form>
        </table>
        </div>
    </section>

    <script src="../script.js"></script>
</body>

</html>