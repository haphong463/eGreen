<?php
require_once '../../db/dbhelper.php';
require_once '../../sendmail.php';

$order_id = isset($_GET['return_order']) ? $_GET['return_order'] : header('Location: ../orders.php');

$sql = "UPDATE returns SET isAccept = 1 WHERE order_id = '$order_id'";
execute($sql);

$sql = "UPDATE orders SET status = 'Returned', updated_at = NOW() WHERE order_id = '$order_id'";
execute($sql);
header('Location: ../orders.php');
