<?php
require_once 'db/dbhelper.php';
session_start();
$bid = $_GET['blog_id'];


$sql = "SELECT * FROM blog WHERE blog_id = $bid ";
$blog_result =  executeSingleResult($sql);
$b_id = $blog_result['blog_id'];
$type = $blog_result['blog_category_id'];
$title = $blog_result['title'];
$content = $blog_result['content'];
$img = $blog_result['img'];
$date = 'On ' . date('F d, Y', strtotime($blog_result['created_at'])); // Convert the date format
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['user_id'];
    $info = executeSingleResult("SELECT * FROM users WHERE user_id = $user_id and type = 'user");
} elseif (isset($_SESSION['user_token'])) {
    $user_token = $_SESSION['user_token'];
    $user = executeSingleResult("SELECT * FROM users WHERE token = '$user_token'");
    $user_id = $user['user_id'];
    $info = executeSingleResult("SELECT * FROM users WHERE user_id = $user_id and type = 'google'");
}



$query = "SELECT * FROM blog ORDER BY RAND() LIMIT 3";
$post_resutl = executeResult($query);

$sql2 = "SELECT * FROM comments WHERE blog_id = $bid ORDER BY id desc";
$cmt_result = executeResult($sql2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>techWiz</title>
    <link rel="shortcut icon" type="image" href="img/meo.jpg">
    <!-- BStrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BStrap link -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    /* CSS */
    a {
        text-decoration: none;
    }

    .contact-form textarea {
        outline: none;
    }

    .button-81 {
        background-color: #fff;
        border: 0 solid #e2e8f0;
        border-radius: 1.5rem;
        box-sizing: border-box;
        color: #0d172a;
        cursor: pointer;
        display: inline-block;
        font-family: "Basier circle", -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1.1rem;
        font-weight: 600;
        line-height: 1;
        padding: 1rem 1.6rem;
        text-align: center;
        text-decoration: none #0d172a solid;
        text-decoration-thickness: auto;
        transition: all .1s cubic-bezier(.4, 0, .2, 1);
        box-shadow: 0px 1px 2px rgba(166, 175, 195, 0.25);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
    }

    .button-81:hover {
        background-color: #1e293b;
        color: #fff;
    }

    .options {
        top: 5px;
        right: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .comment-options {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 5px;
    }

    .comment-options span {
        cursor: pointer;
        display: block;
        margin-bottom: 5px;
    }

    .comment-area {
        text-align: left;
    }

    @media (min-width: 768px) {
        .button-81 {
            font-size: 1.125rem;
            padding: 1rem 2rem;
        }
    }

    .mb-3 {
        border-style: none;
        border-color: Transparent;
        overflow: auto;
        border-bottom: solid black;
    }

    .contact-form input {
        width: 100%;
        font-size: 12px;
        font-weight: 600;
        color: #838383;
        border: 0;
        padding-bottom: 14px;
        border-bottom: 2px solid #E7EBED;
        margin-bottom: 25px;
    }

    .contact-form textarea {
        width: 100%;
        border-bottom: 2px solid #E7EBED;
        font-size: 12px;
        font-weight: 600;
        color: #838383;
        border-left: 0;
        height: 215px;
        border-right: 0;
        border-top: 0;
        resize: none;
        margin-bottom: 40px;
    }

    .contact-form button {
        color: #1e1e1e;
        background: transparent;
        border: none;
        font-size: 14px;
        font-weight: 600;
        padding: 16px 50px;
        border: 2px solid #1e1e1e;
        border-radius: 50px;
        cursor: pointer;
        text-transform: uppercase;
    }

    .comment {
        margin-bottom: 20px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .comment .author {
        font-weight: bold;
    }

    .comment .content {
        margin-top: 5px;
    }

    .comment .reply-link {
        color: #888;
        cursor: pointer;
    }

    .comment .reply-form {
        margin-top: 10px;
    }

    .comment .reply-form textarea {
        width: 100%;
        height: 70px;
        margin-bottom: 5px;
    }

    .comment-form textarea {
        width: 100%;
        height: 70px;
        margin-bottom: 5px;
    }
</style>

<body>






    <?php
    include('part/header.php');
    ?>
    <!-- home Section -->
    <div class="home">

        <div class="header-row">
            <div class="header-row-inside">

                <h1 class="shopName">Blog</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <!-- home Section End-->



    <section>
        <div class="text-center container py-5">
            <h4 class="mt-4 mb-5"><strong>N . E . W</strong></h4>

            <div class="row">

                <div class="col-lg-8">

                    <?php
                    $sql = "SELECT * FROM blog";
                    $products = executeResult($sql);
                    $current_pid = isset($_GET['blog_id']) ? $_GET['blog_id'] : null; // Lấy pid hiện tại

                    $previous_pid = null; // Pid của sản phẩm trước đó
                    $next_pid = null; // Pid của sản phẩm tiếp theo

                    // Tìm vị trí của pid hiện tại trong danh sách sản phẩm
                    $current_product_index = -1;
                    foreach ($products as $index => $product) {
                        if ($product['blog_id'] == $current_pid) {
                            $current_product_index = $index;
                            break;
                        }
                    }

                    // Lấy pid của sản phẩm trước đó và tiếp theo
                    if ($current_product_index !== -1) {
                        $previous_pid = ($current_product_index > 0) ? $products[$current_product_index - 1]['blog_id'] : null;
                        $next_pid = ($current_product_index < count($products) - 1) ? $products[$current_product_index + 1]['blog_id'] : null;
                    }
                    ?>
                    <!-- hiển thị phân trang -->
                    <div class="col-lg-12 mb-5">
                        <div class="posts-nav  d-flex justify-content-between ">
                            <div class="posts-prev-item mb-4 mb-lg-0">
                                <?php if ($previous_pid !== null) { ?>
                                    <span class="nav-posts-desc text-color"><a href="blog-detail.php?blog_id=<?php echo $previous_pid ?>">- Previous Post</a></span>
                                <?php } ?>
                            </div>
                            <div class="posts-next-item pt-6 pt-lg-0">
                                <?php if ($next_pid !== null) { ?>
                                    <span class="nav-posts-desc text-lg-right text-md-right text-color d-block"><a href="blog-detail.php?blog_id=<?php echo $next_pid ?>">- Next Post</a></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <img src="<?php echo $img ?>" style="width: 100%;height:60vh;" alt="">

                    <p style="width: 100%;text-align:left;">
                        <i class='bx bxs-comment'></i>
                        <?php
                        $query1 = "SELECT COUNT(*) AS total FROM comments WHERE blog_id = $b_id";
                        $result1 = executeSingleResult($query1);
                        if ($result1 != NULL) {
                            $total = $result1["total"];
                            echo $total . " Comments";
                        }
                        ?>
                        <span style="float:right;"><i class='bx bxs-watch'></i> <?php echo $date ?></span>
                    </p>

                    <h1><?php echo $title ?></h1>
                    <h6 style="text-align:left;">
                        <?php echo $content ?>
                    </h6>

                    <br><br><br>

                    <!-- cmt -->
                    <form id="comment-form" class="contact-form" action="submit-comment.php" method="post" onsubmit="return validateCommentForm()">
                        <h2 style="text-align:left;">Write a comment</h2>

                        <div class="form-group">
                            <input type="hidden" class="form-control" name="blog-id" value="<?php echo $bid ?>" />
                            <input type="hidden" name="email-user" value="<?php echo $info['user_id'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="comment-name" value="<?php echo isset($info) ? $info['fullname'] : NULL ?>">
                        </div>

                        <div>
                            <textarea class="mb-3" maxlength="255" style="width: 100%;" rows="9" name="comment-content" id="comment-content" placeholder="Comment"></textarea>
                            <span id="commentContentError" class="error" style="color: red;"></span> <!-- Error message for comment content -->
                        </div>

                        <div style="text-align: left;">
                            <?php
                            if (isset($info)) {
                                echo '<button class="button-81" role="button" type="submit">Send</button>';
                            } else {
                                echo '<a href="user-login.php"><button class="button-81" role="button" type="button">Send</button></a>';
                            }
                            ?>
                        </div>
                    </form>


                    <hr style=" width:100%;">


                    <!--show cmt -->
                    <?php
                    function displayComments($parent_id = 0)
                    {
                        global $bid;
                        global $info;
                        $sql = "SELECT * FROM comments WHERE parent_id = " . $parent_id . ' and blog_id = ' . $bid . ' ORDER BY id DESC';
                        $result = executeResult($sql);

                    ?>
                        <div class="col-lg-12">
                            <div class="comment-area card border-0 m-5">
                                <?php if (count($result) > 0) { ?>
                                    <ul class="comment-tree list-unstyled ">
                                        <?php
                                        $forbiddenWords = executeResult("SELECT list FROM forbidden_words");

                                        foreach ($result as $row) {
                                            // tu cam 
                                            $formatted_review = nl2br($row['content']);
                                            foreach ($forbiddenWords as $forbiddenWord) {
                                                $word = $forbiddenWord['list'];
                                                if (stripos($formatted_review, $word) !== false) {
                                                    $formatted_review = str_ireplace($word, '***', $formatted_review);
                                                }
                                            }
                                        ?>
                                            <li class="">
                                                <div class="comment-area-box">

                                                    <h5 class=""><?php echo $row['name'] ?></h5>

                                                    <div class="comment-content mt-2" id="comment-content-<?php echo $row['id'] ?>">
                                                        <?php echo $formatted_review ?>
                                                    </div>

                                                    <span><?php echo date('F d, Y', strtotime($row['datetime'])); ?></span>
                                                    <a style="cursor:pointer" class="reply-link" onclick="showReplyForm(<?php echo $row['id'] ?>)"><i class="icofont-reply mr-2 text-muted"></i>| Reply </a>
                                                    <?php
                                                    if (isset($info) && $info['user_id'] == $row['c_id']) {
                                                    ?>
                                                        <div class="options" onclick="toggleOptions(this)">&#8230;</div>
                                                        <div class="comment-options">
                                                            <span class="delete-option" onclick="deleteComment(<?php echo $row['id'] ?>)">Delete</span>
                                                            <span class="edit-option" id="edit-option-<?php echo $row['id'] ?>" onclick="editComment(<?php echo $row['id'] ?>)">Edit</span>
                                                        </div>
                                                    <?php
                                                    }

                                                    ?>

                                                </div>
                                                <div class="contact-form">
                                                    <div id="reply-form-<?php echo $row['id'] ?>" class="reply-form" style="display: none;">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="hidden" id="reply-blog-<?php echo $row['id'] ?>" value="<?php echo $bid ?>">
                                                                <input type="hidden" id="reply-email-<?php echo $row['id'] ?>" value="<?php echo isset($info) ? $info['user_id'] : NULL ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" id="reply-name-<?php echo $row['id'] ?>" value="<?php echo isset($info) ? $info['fullname'] : NULL ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea cols="50" rows="5" id="reply-content-<?php echo $row['id'] ?>" placeholder=" Reply Comment"></textarea><br>
                                                            </div>
                                                            <?php if (isset($info)) {
                                                                echo '<button class="button-81" role="button" class="btn review-btn" onclick="submitReply(' . $row['id'] . ')">Post</button>';
                                                            } else {
                                                                echo '<a href="user-login.php"><button class="button-81" role="button">Post</button></a>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                // Hiển thị reply
                                                displayComments($row['id']);
                                                ?>
                                            </li>
                                        <?php   } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                    }

                    // Hiển thị comment
                    displayComments();
                    ?>

                </div>

                <div class="col-lg-4">

                    <?php
                    include('part/blog.php');
                    ?>

                </div>


            </div>

        </div>
    </section>



    <?php
    include('part/footer.php');
    ?>


    <a href="#" class="arrow">
        <i class='bx bx-up-arrow-alt'></i>
    </a>








    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- scr for cmt -->
    <script>
        // Hiển thị form reply
        function showReplyForm(commentId) {
            var replyForm = document.getElementById('reply-form-' + commentId);
            if (replyForm.style.display === 'none') {
                replyForm.style.display = 'block';
            } else {
                replyForm.style.display = 'none';
            }
        }

        // Gửi reply bằng Ajax
        function submitReply(commentId) {
            var replyContent = $('#reply-content-' + commentId).val();
            var replyBlog = $('#reply-blog-' + commentId).val();
            var replyName = $('#reply-name-' + commentId).val();
            var replyEmail = $('#reply-email-' + commentId).val();
            $.ajax({
                url: 'submit-comment.php',
                type: 'POST',
                data: {
                    'email-user': replyEmail,
                    'blog-id': replyBlog,
                    'comment-name': replyName,
                    'comment-content': replyContent,
                    'parent_id': commentId
                },
                success: function(response) {
                    console.log(response);
                    // Refresh lại trang để hiển thị comment và reply mới
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi: ' + error);
                }
            });
        }

        // Gửi comment gốc bằng Ajax
        function submitComment() {

            var commentContent = $('textarea[name="comment-content"]').val();
            var nameContent = $('input[name="comment-name"]').val();
            var blogId = $('input[name="blog-id"]').val();
            var emailContent = $('input[name="email-user"]').val();

            $.ajax({
                url: 'submit-comment.php',
                type: 'POST',
                data: {
                    'blog-id': blogId,
                    'comment-name': nameContent,
                    'comment-content': commentContent,
                    'email-user': emailContent,
                    'parent_id': 0
                },
                success: function(response) {
                    console.log(response);
                    // Refresh lại trang để hiển thị comment mới
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi: ' + error);
                }
            });
        }

        function toggleOptions(element) {
            var options = element.nextElementSibling;
            options.style.display = (options.style.display === 'block') ? 'none' : 'block';
        }

        // Ngăn chặn sự kiện mặc định khi submit form
        $('#comment-form').submit(function(event) {
            event.preventDefault();
            submitComment();
        });

        function deleteComment(commentId) {
            if (confirm("Are you sure you want to delete this comment?")) {
                $.ajax({
                    url: 'delete_comment.php',
                    type: 'POST',
                    data: {
                        'comment-id': commentId
                    },
                    success: function(response) {
                        console.log(response);
                        // Refresh lại trang để hiển thị comment và reply mới
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                    }
                });
            }
        }

        function editComment(commentId) {

            var commentContent = $('#comment-content-' + commentId).text().trim();

            // Thay thế nội dung comment bằng một textarea để người dùng có thể chỉnh sửa
            $('#comment-content-' + commentId).replaceWith('<div class="contact-form"><textarea id="edit-comment-content-' + commentId + '">' + commentContent + '</textarea></div>');

            // Thay đổi nút "Edit" thành nút "Save"
            $('#edit-option-' + commentId).text('Save');
            $('#edit-option-' + commentId).attr('onclick', 'saveComment(' + commentId + ')');
        }

        function saveComment(commentId) {
            var commentContent = $('#edit-comment-content-' + commentId).val();

            // Thực hiện lưu comment bằng Ajax
            $.ajax({
                url: 'save_comment.php',
                type: 'POST',
                data: {
                    'comment-id': commentId,
                    'comment-content': commentContent
                },
                success: function(response) {
                    console.log(response);
                    // Hiển thị lại nội dung comment đã chỉnh sửa
                    $('#edit-comment-content-' + commentId).replaceWith('<div class="comment-content mt-3" id="comment-content-' + commentId + '">' + commentContent + '</div>');

                    // Thay đổi nút "Save" thành "Edit"
                    $('#edit-option-' + commentId).text('Edit');
                    $('#edit-option-' + commentId).attr('onclick', 'editComment(' + commentId + ')');
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi: ' + error);
                }
            });
        }
    </script>

    <!-- check validate for comment -->
    <script>
        function validateCommentForm() {
            var commentContent = document.getElementById("comment-content").value;

            if (commentContent.trim() === "") {
                document.getElementById("commentContentError").innerText = "Please enter a comment.";
                return false;
            }

            return true; // Submit the form if all the validations pass
        }
    </script>
</body>

</html>