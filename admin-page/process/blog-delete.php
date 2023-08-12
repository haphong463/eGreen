<?php
require('../../db/dbhelper.php');
$id = '';
if (isset($_GET['blog_id'])) {
    $id = $_GET['blog_id'];
}

$sql2 = "SELECT * FROM blog where blog_id = $id";
$blog = executeSingleResult($sql2);
unlink('../../' . $blog['img']);

$sql = "DELETE FROM blog where blog_id = $id";
execute($sql);
header('Location: ../blog.php');
?>