<?php
require_once("../db/dbhelper.php");

$categories = executeResult("SELECT * FROM blog_category");

if (isset($_GET['blog_id'])) {
    $id = $_GET['blog_id'];
    $sql = "SELECT * FROM blog where blog_id = $id";
    $info = executeSingleResult($sql);
    $title = $info['title'];
    $content = $info['content'];
    $type = $info['blog_category_id'];
    $image = $info['img'];
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

    <!-- for format content blog -->
    <script src="https://cdn.tiny.cloud/1/nb4vev3lun09knzucwhj47n7cmn1y7l4j5w4jhq249xu7j66/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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

                <h1>Blog Update</h1>
                <form action="process/blog-update-process.php" method="post" enctype="multipart/form-data" class="row" onsubmit="return validateForm()">
                    <input type="hidden" name="blog_id" value="<?= $id ?>">
                    <div class="mb-3 mt-3">
                        <label for="type">Type:</label>
                        <select name="cate_id">
                            <?php
                            foreach ($categories as $cate) {
                                echo '
                                
                                <option value=" ' . $cate['blog_category_id'] . '">' . $cate['name'] . '</option>

                                ';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter blog title" value="<?php echo $title ?>" name="title">
                        <span id="titleError" class="error" style="color: red;"></span> <!-- Error message for title field -->
                    </div>
                    <div class="mb-3">
                        <label for="content">Content:</label>
                        <textarea id="content" name="content"><?php echo $content ?></textarea>
                        <span id="contentError" class="error" style="color: red;"></span> <!-- Error message for content field -->
                    </div>
                    <div class="mb-3">
                        <label for="image">Images:</label>
                        <input type="file" class="form-control" id="blog" name="blog">
                        <img src="../<?php echo $image ?>" alt="" width="200px" height="200px">
                    </div>
                    <button type="submit" name="update-blog" class="btn btn-primary mt-3">Update</button>
                </form>
        </table>
        </div>
    </section>

    <script src="script.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'lists',
            toolbar: 'undo redo | blocks fontsize | bold italic underline | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap',
        });
    </script>

    <script>
        function validateForm() {
            var title = document.getElementById("title").value;
            var content = document.getElementById("content").value;
            var blog = document.getElementById("blog").value;

            if (title === "") {
                document.getElementById("titleError").innerText = "Please enter a title.";
                return false;
            } else {
                document.getElementById("titleError").innerText = ""; // Clear the error message
            }

            if (content == "") {
                document.getElementById("contentError").innerText = "Please enter the content.";
                return false;
            } else {
                document.getElementById("contentError").innerText = ""; // Clear the error message
            }

            return true; // Submit the form if all the validations pass
        }
    </script>
</body>

</html>