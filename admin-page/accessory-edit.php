<?php
require_once("../db/dbhelper.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = 'select * from accessory where accessory_id =' . $id;
    $accessory = executeSingleResult($sql);

    $accessory_id = $accessory['accessory_id'];

    
}




 $image2 = executeResult("SELECT * FROM image2 WHERE acc_id = $accessory_id");
 $inventory = executeSingleResult("SELECT * FROM acc_inventory WHERE acc_id = $accessory_id")['quantity'];

if (isset($_POST['edit'])) {
  
    $acc_id = $_POST['acc_id'];
    $name = $_POST['name'];
    $description = addslashes($_POST['description']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    execute("UPDATE accessory SET name = '$name', description = '$description', price = $price WHERE accessory_id = $acc_id");
    execute("UPDATE acc_inventory SET quantity = $quantity WHERE acc_id = $acc_id");
    if (!empty($_FILES['image']['name'][0])) {
        // Lấy các đường dẫn hình ảnh cũ từ cơ sở dữ liệu
        $sql_image_old = "SELECT pi.image, pt.thumbnail_path FROM image2 AS pi INNER JOIN thumbnail2 AS pt ON pi.acc_id = pt.acc_id WHERE pi.acc_id = $acc_id";
        $result_image_old = executeResult($sql_image_old);

        // Tạo một mảng lưu trữ các đường dẫn của các hình ảnh cũ
        $old_image_paths = array();
        foreach ($result_image_old as $image_old) {
            $old_image_paths[] = ($image_old['image']);
            $old_image_paths[] = ($image_old['thumbnail_path']);
        }

        // Xóa các hình ảnh cũ trong thư mục và cơ sở dữ liệu
        foreach ($old_image_paths as $old_image_path) {
            $file_path = '../' . $old_image_path;
            if (file_exists($file_path)) {
                unlink($file_path); // Xóa ảnh thực tế trong thư mục
            }
            $sql_delete_image = "DELETE FROM image2 WHERE image = '$old_image_path'";
            execute($sql_delete_image); // Xóa ảnh trong cơ sở dữ liệu

            $sql_delete_thumbnail = "DELETE FROM thumbnail2 WHERE thumbnail_path = '$old_image_path'";
            execute($sql_delete_thumbnail); // Xóa ảnh trong cơ sở dữ liệu
        }
    }
    $takeid = $acc_id;
    include('uploadImage2.php');
    // header('Location: accessory.php');
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


                <h1>Accessory Edit</h1>
                <form action="" method="post" enctype="multipart/form-data" class="row">
                    <input type="hidden" name="acc_id" value="<?= $id ?>">
                    
                    <div class="mb-3">
                        <label for="description">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter description" value="<?= $accessory['name'] ?>" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" value="<?= $accessory['description'] ?>" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="description">Price:</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter description" value="<?= $accessory['price'] ?>" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Access quantity:</label>
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
                            foreach ($image2 as $r) {
                                if ($count % 3 == 0) {
                                    echo '</div><div class="row">';
                                }
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <img src="../<?php echo $r['image'] ?>" alt="Product Image" class="img-fluid">
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