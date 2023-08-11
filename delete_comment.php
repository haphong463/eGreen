<?php
// delete_comment.php
require_once('db/dbhelper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment-id'])) {
    $commentId = $_POST['comment-id'];
    execute("DELETE FROM comments WHERE id = $commentId");
    // Thực hiện xóa comment từ cơ sở dữ liệu dựa trên $commentId
    // ...
    // Code xóa comment ở đây

    // Trả về thông báo thành công hoặc lỗi
    echo 'Comment deleted successfully.';
} else {
    // Trả về lỗi nếu không tìm thấy comment ID
    echo 'Invalid request.';
}
?>
