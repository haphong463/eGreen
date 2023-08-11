<?php
session_start();
include_once('db/dbhelper.php');

$user = (isset($_SESSION['user'])) ? $_SESSION['user']: [];
$user_id=$user['user_id'];

if(isset($_POST['newpass'])){
$curpass = $_POST['curpass'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$err = [];

if(empty($curpass)){
    $err['curpass'] = 'curpass is required';
}
else{
$sql = "SELECT * FROM users where user_id = '$user_id'";
$checkPassNow=executeSingleResult($sql);
$checkpassmahoa= $checkPassNow['password'];
if(password_verify($curpass, $checkpassmahoa)){
}else{
    $err['curpass'] = 'curpass is not correctly';
}
}
if(empty($password)){
    $err['password'] = 'password is required';
}else{
    if(!preg_match("/^[a-zA-Z0-9]{5,20}$/",$password)){
        $err['password'] ='passwordnew must be from 5-10 characters and numbers';
    }
}
if(empty($cpassword)){
    $err['cpassword'] = 'cpassword is required';
}else{
    if($cpassword!==$password){
        $err['cpassword'] = "Your passwordnew and cpasswordnew not as same";
    }
}
if(empty($err)){
        $pass = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password ='$pass' WHERE user_id = '$user_id'";
        execute($sql);

      $sql1 = " UPDATE users  SET token_create_at ='' WHERE user_id = '$user_id'  " ;
execute($sql1);
header('location:user-login.php');
unset($_SESSION['user']);
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sigh up</title>

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
                    <span><?php echo (isset($err['curpass'])) ? $err['curpass'] : ''; ?></span>
                </div>
                <input type="password" placeholder="Current Password" name="curpass" value="<?php echo isset($curpass) ? $curpass : ''; ?>">
                <i class='bx bxs-lock-alt' ></i>
            </div>

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
            <button type="submit" class="btn" name="newpass">Change Password</button>

        </form>
    </div>
</body>
</html>