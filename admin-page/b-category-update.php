<?php
require_once("../db/dbhelper.php");
$id = $_GET['blog_category_id'];
$categories = executeSingleResult("SELECT * FROM blog_category WHERE blog_category_id = $id");
if (isset($_POST['edit'])) {
    $cate_id = $_POST['cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    execute("UPDATE blog_category SET name = '$name', description = '$description' WHERE blog_category_id = $cate_id");
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

            <div class="container">

                <h1>Blog Category Edit</h1>
                <form action="" method="post" onsubmit="return validateForm()">
                    <input type="hidden" name="cate_id" value="<?= $id ?>">
                    <div class="mb-3 mt-3">
                        <label for="name">Category Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter category name" value="<?= $categories['name'] ?>" name="name">
                        <span id="nameError" class="error" style="color: red;"></span> <!-- Error message for title field -->
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" value="<?= $categories['description'] ?>" name="description">
                        <span id="descError" class="error" style="color: red;"></span> <!-- Error message for title field -->
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                </form>
        </table>
        </div>
    </section>

    <script src="../script.js"></script>

    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var description = document.getElementById("description").value;

            if (name === "") {
                document.getElementById("nameError").innerText = "Please enter a name.";
                return false;
            } else {
                document.getElementById("nameError").innerText = ""; // Clear the error message
            }

            if (description == "") {
                document.getElementById("descError").innerText = "Please enter the description.";
                return false;
            } else {
                document.getElementById("descError").innerText = ""; // Clear the error message
            }

            return true; // Submit the form if all the validations pass
        }
    </script>
</body>

</html>