<?php
require_once("../db/dbhelper.php");
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

                <h1>Add Forbidden Words</h1>
                <form action="process/words-add-process.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

                    <div class="mb-3 mt-3">
                        <label for="name">Forbidden Words:</label>
                        <input type="text" class="form-control" id="list" name="list" placeholder="Enter words">
                        <span id="error-message" style="color: red;"></span>
                    </div>

                    <button type="submit" name="create-words" class="btn btn-primary">Add Words</button>
                </form>
        </table>
        </div>
    </section>

    <script src="script.js"></script>

    <script>
        function validateForm() {
            var forbiddenWords = document.getElementById("list").value;
            var errorMessage = document.getElementById("error-message");

            // Kiểm tra nếu không có từ nào được nhập
            if (forbiddenWords.trim() === "") {
                errorMessage.textContent = "Please enter forbidden words.";
                return false;
            }

            // Nếu tất cả kiểm tra thành công, cho phép gửi form
            return true;
        }
    </script>
</body>

</html>