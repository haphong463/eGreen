<?php
session_start();
require_once('db/dbhelper.php');
if (isset($_GET['email'])) {
    $email =$_GET['email'];
    $sql = "SELECT * FROM users WHERE email ='$email'";
   $check = executeSingleResult($sql);
    if($check['status']==0){
        $sql="UPDATE users set status = 0 where email = '$email'";
execute($sql);
echo '<script>alert("Your account have been veryfied successfully!");
window.location.href="user-login.php";
</script>';
    }   

}

?>