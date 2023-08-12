<?php
session_start();
require_once('db/dbhelper.php');
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "SELECT * FROM users WHERE email ='$email' and type='user'";
    $check = executeSingleResult($sql);
    if ($check['status'] == 2) {
        $sql = "UPDATE users set status = 0 where email = '$email' and type='user'";
        execute($sql);
        echo '<script>alert("Your account have been veryfied successfully!");
window.location.href="user-login.php";
</script>';
    }
}
