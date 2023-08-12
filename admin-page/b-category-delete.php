<?php
require('../../db/dbhelper.php');
$id = '';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    //xoa trong db
    $sql = 'DELETE FROM `blog_category` where blog_category_id ="'.$id.'"';
    execute($sql);

    header('Location:../b-category.php');
}
?>