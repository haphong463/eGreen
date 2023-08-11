<?php
require_once('../db/dbhelper.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = 'DELETE FROM admin WHERE user_id = "'.$id.'"';
    execute($sql);
    header("Location:admin.php");
}

?>