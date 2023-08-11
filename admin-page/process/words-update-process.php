<?php
require_once ('../../db/dbhelper.php');

if(isset($_POST['update-words'])){
    $id = $_POST['id'];
    $list = $_POST['list'];
}

// Sử dụng hàm addslashes để tránh xảy ra lỗi khi nhập dấu chấm
// $description = addslashes($description);

$sql = "UPDATE forbidden_words SET list = '$list' WHERE id = $id";
execute($sql);
header('Location: ../words.php');
?>