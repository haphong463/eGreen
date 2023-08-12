<?php
require_once("../db/dbhelper.php");
$categories = executeResult("SELECT * FROM blog_category");
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
    <script src="https://cdn.tiny.cloud/1/nb4vev3lun09knzucwhj47n7cmn1y7l4j5w4jhq249xu7j66/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


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

            <div class="container-fluid">

                <h1>Blog Add</h1>
                <form action="process/blog-add-process.php" class="row" method="post" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="type">Type:</label>
                        <select id="type" name="type">
                            <?php
                            foreach ($categories as $cate) {
                                echo '
                                
                                <option value=" ' . $cate['blog_category_id'] . '">' . $cate['name'] . '</option>

                                ';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3 col-md-8">
                        <label for="title">Title:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="title" placeholder="Enter blog title" name="title">
                            <div class="input-group-append">
                                <a class="btn btn-secondary auto-generated-button" onclick="createTitle()">Auto generated</a>
                            </div>
                        </div>
                        <span id="titleError" class="error" style="color: red;"></span> <!-- Error message for title field -->
                    </div>
                    <div class="mb-3 col-md-8">
                        <label for="blog">Blog image:</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="blog" placeholder="Enter description" name="blog">
                            <div class="input-group-append">
                                <a class="btn btn-secondary auto-generated-button" id="imageBtn" onclick="createImage()" disabled>Auto generated</a>
                            </div>
                        </div>
                        <span id="blogError" class="error" style="color: red;"></span> <!-- Error message for blog image field -->
                        <img src="" id="imageAI">
                    </div>
                    <div class="mb-3 col-md-8">
                        <div class="d-flex justify-content-between">
                            <label for="content">Content:</label>
                            <a class="btn btn-secondary auto-generated-button" id="contentBtn" onclick="createContent()" disabled>Auto generated</a>
                        </div>
                        <textarea id="content" name="content" class="form-control" placeholder="Enter content"></textarea>
                        <span id="contentError" class="error" style="color: red;"></span> <!-- Error message for description field -->
                    </div>


                    <div class="col-md-8 offset-md-4">
                        <button type="submit" name="create-blog" class="btn btn-primary">Submit</button>
                    </div>
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
            var type = document.getElementById("type").value;
            var blog = document.getElementById("blog").value;

            if (title === "") {
                document.getElementById("titleError").innerText = "Please enter a title.";
                return false;
            } else {
                document.getElementById("titleError").innerText = ""; // Clear the error message
            }

            if (content === "") {
                document.getElementById("contentError").innerText = "Please enter the content.";
                return false;
            } else {
                document.getElementById("contentError").innerText = ""; // Clear the error message
            }

            if (type === "") {
                document.getElementById("typeError").innerText = "Please enter the type.";
                return false;
            } else {
                document.getElementById("typeError").innerText = ""; // Clear the error message
            }

            if (blog === "") {
                document.getElementById("blogError").innerText = "Please select a blog image.";
                return false;
            } else {
                document.getElementById("blogError").innerText = ""; // Clear the error message
            }

            return true; // Submit the form if all the validations pass
        }
    </script>

    <script>
        function createTitle() {

            $.ajax({
                url: "AI.php",
                method: "POST",
                data: {
                    action: 'create_title'
                },
                success: function(data) {
                    document.getElementById("title").value = data;
                    //location.reload();
                    var autoGeneratedButtons = document.querySelectorAll(".auto-generated-button");
                    autoGeneratedButtons.forEach(button => {
                        button.classList.remove("btn-secondary");
                        button.classList.add("btn-primary");
                        button.removeAttribute("disabled");
                    });
                }
            });

        }

        function createImage() {

            var title = document.getElementById("title").value;
            if (!title) {
                alert("Please enter a title before generating image.");
                return;
            }
            $.ajax({
                url: "AI.php",
                method: "POST",
                data: {
                    action: 'create_image',
                    title: title
                },
                success: function(data) {

                    document.getElementById("imageAI").src = data;
                    //location.reload();
                }
            });
        }

        function createContent() {

            var title = document.getElementById("title").value;
            if (!title) {
                alert("Please enter a title before generating content.");
                return;
            }
            $.ajax({
                url: "AI.php",
                method: "POST",
                data: {
                    action: 'create_content',
                    title: title
                },
                success: function(data) {
                    // alert(data);
                    tinymce.get("content").setContent(data);
                    //document.getElementById("content").innerHTML = data;
                }
            });
        }
    </script>
</body>

</html>