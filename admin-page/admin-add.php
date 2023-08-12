<?php
session_start();
require_once('../db/dbhelper.php');
require_once '../vendor/autoload.php'; // Import thư viện firebase/php-jwt

use \Firebase\JWT\JWT;

if (isset($_POST['add'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $err = [];
    

    if(empty($email)){
        $err['email']='email must be not empty';
        }else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $err['email'] ='Invalid email';
            }else {
                //kiem tra email có tồn tại trong db chưa
                $sql1 = "SELECT * FROM users WHERE email='$email'";
                $checkRegister = executeSingleResult($sql1);
                if ($checkRegister) {
                    $err['email'] = 'This email is already in use';
                }
            }
        }

     if (empty($phone)) {
        $err['phone'] = 'phone must be not empty';
    } else {
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $err['phone'] = 'phone must not be 10 numbers and not have characters';
        }
    }
    if(empty($password)){
        $err['password']='password must be not empty';
        }else{
            if(!preg_match("/^[a-zA-Z0-9]{5,20}$/",$password)){
                $err['password'] ='password must be from 5-10 characters and numbers';
            }
        }

        if(empty($err) ){
            $pass = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email,password,phone,role) VALUES ('$email','$pass','$phone','$role')";
            execute($sql);
            header('location:admin.php');
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
    <title>Admin Dashboard Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .has-error {
            color: red;
        }
    </style>
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
        <h1>Add Employee</h1>
        <div class="table-responsive">
            <div class="product-physical">
                <form action="" method="post">
                    <div class="form-group">
                    <div class="has-error">
                                        <span><?php echo (isset($err['email'])) ? $err['email'] : ''; ?></span>
                                    </div>
                        <label for="name">Email :</label>
                        <input id="name" class="form-control" type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>

                    <div class="form-group">
                    <div class="has-error">
                                        <span><?php echo (isset($err['password'])) ? $err['password'] : ''; ?></span>
                                    </div>
                        <label for="name">Password :</label>
                        <input id="name" class="form-control" type="password" name="password" value="<?php echo isset($password) ? $password : ''; ?>">
                    </div>
                    <div class="form-group">
                    <div class="has-error">
                                        <span><?php echo (isset($err['phone'])) ? $err['phone'] : ''; ?></span>
                                    </div>
                        <label for="name">Phone :</label>
                        <input id="name" class="form-control" type="text" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Role :</label>
                        <input id="name" class="form-control" type="number" name="role" value="2" readonly>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="add">add</button>
                </form>
            </div>
        </div>



        <script src="script.js"></script>
</body>

</html>