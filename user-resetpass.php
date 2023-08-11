<?php
session_start();
include_once('db/dbhelper.php');




if(isset($_GET['user_id'])&&isset($_GET['token'])){

$user_id = $_GET['user_id'];
$token = $_GET['token'];

//KIỂM TRA XEM CÓ PHẢI LINK CỦA GMAIL MỚI NHẤT KHÔNG
$sql = "SELECT * FROM forget_pass WHERE user_id = '$user_id' ORDER BY create_at DESC LIMIT 1";
$result = executeSingleResult($sql);
$checkToken = $result['token'];
$checkActive = $result['isActive'];
}


if(isset($_POST['reset'])){
    if($checkToken==$token && $checkActive=='false'){
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$err = [];
if(empty($password)){
    $err['password'] = 'password is required';
}else{
    if(!preg_match("/^[a-zA-Z0-9]{5,20}$/",$password)){
        $err['password'] ='password must be from 5-10 characters and numbers';
    }
}
if(empty($cpassword)){
    $err['cpassword'] = 'cpassword is required';
}else{
    if($password!==$cpassword){
        $err['cpassword'] = "Your password and confirmpassword not as same";
        }
}

// var_dump($err);
if(empty($err)){

    $sql = "UPDATE forget_pass set timesToforget = timesToforget+1, isActive = 'true' WHERE token  = '$checkToken'";
    execute($sql);

        $pass = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password ='$pass' WHERE user_id = '$user_id'";
        execute($sql);
        echo "<script>alert('set newpassword successfully')</script>";
        header('location:user-login.php');
        exit();
}
}
else{
    echo "<script>alert('please use the newest link in your mail,or you have been use this link')</script>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <!-- link Icon https://boxicons.com -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/login.css">
    <style>
        .has-error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>ChangePassword</h1>        
            <div class="input-box">
            <div class="has-error">
                    <span><?php echo (isset($err['password'])) ? $err['password'] : ''; ?></span>
                </div>
                <input type="password" placeholder="New Password" name="password" value="<?php echo isset($password) ? $password : ''; ?>">
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <div class="input-box">
            <div class="has-error">
                    <span><?php echo (isset($err['cpassword'])) ? $err['cpassword'] : ''; ?></span>
                </div>
                <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo isset($cpassword) ? $cpassword : ''; ?>">
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <!-- <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forgot password</a>
            </div> -->
<br><br>
            <button type="submit" class="btn" name="reset">Change Password</button>

        </form>
    </div>
</body>
</html>