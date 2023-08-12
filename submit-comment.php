<?php
require_once('db/dbhelper.php');
// Kết nối đến cơ sở dữ liệu

// Lấy dữ liệu từ form
$blogId = $_POST['blog-id'];
$commentName = $_POST['comment-name'];
$commentContent = trim($_POST['comment-content']);
$parentId = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
$c_id = $_POST['email-user'];
echo $blogId;
// Thêm comment vào cơ sở dữ liệu
// Validate input
if (!empty($commentName) && !empty($commentContent)) {
    // Thêm comment vào cơ sở dữ liệu
    $sql = "INSERT INTO comments (name, content, c_id, parent_id, blog_id) VALUES ('$commentName', '$commentContent', $c_id, $parentId, $blogId)";
    execute($sql);
    // execute("UPDATE blog SET date = NOW()");
    //header('Location: blog-detail.php?blog_id=' . $blogId);
}
