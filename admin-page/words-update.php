<?php
require_once("../db/dbhelper.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM forbidden_words where id = $id";
    $words = executeSingleResult($sql);
    $list = $words['list'];
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

                <h1>Update Words</h1>
                <form action="process/words-update-process.php" method="post" enctype="multipart/form-data" class="row" onsubmit="return validateForm()">
                    <input type="hidden" name="id" id="id" value="<?= $id ?>" value="<?php echo $id ?>">
                    <div class="mb-3 mt-3">
                        <label for="email">Forbidden Words:</label>
                        <input type="text" class="form-control" id="list" name="list" value="<?php echo $list ?>">
                        <span id="error-message" style="color: red;"></span>
                    </div>
                    <button type="submit" name="update-words" class="btn btn-primary mt-3">Update Words</button>
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