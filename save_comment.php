<?php
require_once('db/dbhelper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment-id'];
    $commentContent = $_POST['comment-content'];

    // Thực hiện lưu comment đã chỉnh sửa vào cơ sở dữ liệu
    $sql = "UPDATE comments SET content = '$commentContent' WHERE id = $commentId";
    execute($sql);

    // Trả về thông báo thành công
    echo 'Comment updated successfully!';
}
