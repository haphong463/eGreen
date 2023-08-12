<?php
session_start();
require_once('../db/dbhelper.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = 'select * from users where user_id =' . $id;
    $adminn = executeSingleResult($sql);

    $email = $adminn['email'];
    $password = $adminn['password'];
    $phone = $adminn['phone'];
}


if (isset($_POST['edit']) && $_GET['id']) {
    $id = $_GET['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $sql = "UPDATE users SET email='" . $email . "',password='" . $password . "',phone='" . $phone . "' WHERE id=" . $id;
    execute($sql);
    header("Location:admin.php");
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
    <title>Admin Dashboard Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>
        <br><br><br><br><br><br>
        <h1>Edit Employee</h1>
        <div class="table-responsive">
            <div class="product-physical">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Email :</label>
                        <input id="name" class="form-control" type="text" name="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Password :</label>
                        <input id="name" class="form-control" type="text" name="password" value="<?php echo $password; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Phone :</label>
                        <input id="name" class="form-control" type="text" name="phone" value="<?php echo $phone; ?>">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="edit">edit</button>
                </form>
            </div>
        </div>



        <script src="script.js"></script>
</body>

</html>