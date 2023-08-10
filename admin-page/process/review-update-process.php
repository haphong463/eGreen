<?php
require_once '../../db/dbhelper.php';


$id = $_POST['id'];
$active = isset($_POST['active']) ? 0 : 1;


$sql = "UPDATE review_table SET status = $active WHERE review_id = $id";
execute($sql);

header('location: ../review.php');
?>