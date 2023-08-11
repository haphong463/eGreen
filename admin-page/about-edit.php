<?php
require_once('../db/dbhelper.php');

if (isset($_GET['sid'])) {
    $id = $_GET['sid'];

    $sql = 'select * from about where id =' . $id;
    $about = executeSingleResult($sql);

    $content = $about['content'];
    $phone = $about['phone'];
    $image = $about['image'];
    $discription = $about['discription'];
    $email = $about['email'];
}


$err = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['sid'];
    $content = $_POST['content'];
    $discription = $_POST['discription'];

    $phone = $_POST['phone'];
    $email = $_POST['email'];


    $image = isset($_POST['image']) ? $_POST['image'] : '';

    if (empty($content)) {
        $err['content'] = 'content must not be empty!';
    } else {
        if (!preg_match("/^[a-zA-Z0-9 ]{3,70}$/", $content)) {
            $err['content'] = 'content must be from 3 to 70 characters and number!';
        }
    }

    if (empty($discription)) {
        $err['discription'] = 'Description must not be empty!';
    } else {
        if (!preg_match("/^[a-zA-Z0-9,.!\- ]{1,500}$/", $discription)) {
            $err['discription'] = 'The length of description must not exceed 500 characters, numbers, and special characters (, . ! -) are allowed!';
        }
    }

    if (empty($phone)) {
        $err['phone'] = 'Phone must not be empty!';
    } else {
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $err['phone'] = 'Phone number must be a valid number with 10 digits!';
        }
    }

    if (empty($email)) {
        $err['email'] = 'Email must not be empty!';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err['email'] = 'Invalid email format!';
        }
    }

    if (isset($_FILES["image"]) && $_FILES['image']['name'] != '') {
        $sql = "SELECT image FROM about WHERE id = $id";
        $about = executeSingleResult($sql);
        $oldimage = $about['image'];
        if (!empty($oldimage) && file_exists($oldimage)) {
            unlink($oldimage);
        }

        $target_dir = "imgAbout/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $upload_ok = 1;
        $image_file_type =
            strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($image_file_type, array("png", "jpg", "jpeg", "gif"))) {
            $err['image'] = 'Only PNG, JPG, JPEG, and GIF files are allowed!';
            $upload_ok = 0;
        }


        //kiem tra trung ten anh     
        if (file_exists($target_file)) {
            $err['image'] = 'The file name already exists. Please change your file name !';
            $upload_ok = 0;
        }

        //lay file anh
        if ($upload_ok == 1) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            //echo 'upload successfully!';
            $image = 'imgAbout/' . $_FILES["image"]["name"];
        }
    } else {
        $sql = "SELECT image FROM about WHERE id = $id";
        $about = executeSingleResult($sql);
        $oldimage = $about['image'];
        $image = $oldimage;
    }

    if (empty($err)) {

        $sql = "UPDATE about SET content='" . $content . "',image='" . $image . "',discription='" . $discription . "',email='" . $email . "',phone='" . $phone . "' WHERE id=" . $id;

        execute($sql);

        header("Location: about.php");
        exit();
    }
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

<style>
    .has-error{
        color: red;
    }
</style>
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

                <h1>update about</h1>
                <!-- process/slider-update-process.php -->
                <form action="" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="sid" value="<?php echo $id; ?>">

                    <div style="float:left; width: 49%;">
                        <div class="form-group">

                            <div class="has-error">
                                <span><?php echo (isset($err['content'])) ? $err['content'] : ''; ?></span>
                            </div>

                            <label for="content">content :</label>
                            <input id="content" class="form-control" type="text" name="content" value="<?php echo isset($content) ? $content : ''; ?>">
                        </div>
                        <div class="form-group">

                            <div class="has-error">
                                <span><?php echo (isset($err['email'])) ? $err['email'] : ''; ?></span>
                            </div>

                            <label for="email">email :</label>
                            <input id="email" class="form-control" type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                        </div>
                        <div class="form-group">

                            <div class="has-error">
                                <span><?php echo (isset($err['phone'])) ? $err['phone'] : ''; ?></span>
                            </div>

                            <label for="phone">phone :</label>
                            <input id="phone" class="form-control" type="text" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
                        </div>
                        <div class="form-group">

                            <div class="has-error">
                                <span><?php echo (isset($err['discription'])) ? $err['discription'] : ''; ?></span>
                            </div>

                            <label for="discription">description :</label>
                            <textarea name="discription" id="discription" class="form-control" style="width:100%;" rows="15"><?php echo isset($discription) ? $discription : ''; ?></textarea>
                        </div>
                    </div>
                    <div style="float:right; width: 49%;">
                        <div class="form-group">

                            <div class="has-error">
                                <span><?php echo (isset($err['image'])) ? $err['image'] : ''; ?></span>
                            </div>

                            <label for="image">image :</label>
                            <input type="file" name="image" class="form-control" id="image" value="<?php echo isset($image) ? $image : ''; ?>">

                            <img src="<?php echo ($image) ? $image : ''; ?>" alt="" style="width:100%;">

                        </div>

                        <button type="submit" class="btn btn-primary" name="edit" style="width:100%;">update</button>
                    </div>



                </form>

            </div>


        </table>

    </section>

    <script src="script.js"></script>
</body>

</html>