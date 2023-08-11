<?php
    require_once '../../db/dbhelper.php';
    if (isset($_POST['create-words'])) {
        $list = $_POST['list'];
        // $description = $_POST['description'];
    }
    // $description = addslashes($description);


    $sql = "INSERT INTO forbidden_words (list) VALUES ('$list')";
    execute($sql);
    header('Location: ../words.php');
?> 