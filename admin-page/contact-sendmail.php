<?php
require_once("../db/dbhelper.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM contacts_list where id = $id";
    $contact = executeSingleResult($sql);
    $sj = $contact['subject'];
    $mes = $contact['message'];
    $email = $contact['email'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin Dashboard Panel</title>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>


        <table class="table">

            <br><br><br>

            <div class="container">

                <h1>Reply Contact</h1>
                <form action="process/contact-sendmail-process.php" method="post" id="form" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" id="id" name="id" hidden value="<?php echo $id ?>">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="email" name="email" hidden value="<?php echo $email ?>">
                    </div>
                    <div class="mb-3">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="<?php $sj ?>" placeholder="subject">
                        <span id="error-subject" style="color: red;"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message">Message:</label>
                        <input type="text" class="form-control" name="message" value="<?php $mes ?>" id="message" placeholder="message here..">
                        <span id="error-message" style="color: red;"></span>
                    </div>
                    <button type="submit" name="send-mail" class="btn btn-primary">Send Mail</button>
                </form>
        </table>
        </div>
    </section>

    <script src="script.js"></script>

    <script>
        document.getElementById("form").addEventListener("submit", function(event) {
            // Kiểm tra tính hợp lệ trên phía máy khách (client-side)
            if (!validateForm()) {
                event.preventDefault(); // Ngăn chặn gửi form nếu không hợp lệ
            }
        });

        function validateForm() {
            var subjectInput = document.getElementById("subject");
            var messageInput = document.getElementById("message");
            var errorMessage = document.getElementById("error-message");
            var errorSubject = document.getElementById("error-subject");

            // Kiểm tra logic kiểm tra của bạn ở đây
            // Ví dụ: kiểm tra các trường, định dạng, điều kiện,...

            // Kiểm tra trường subject có giá trị
            if (subjectInput.value.trim() === "") {
                errorSubject.textContent = "Please enter the subject.";
                return false;
            }

            // Kiểm tra trường message có giá trị
            if (messageInput.value.trim() === "") {
                errorMessage.textContent = "Please enter the message.";
                return false;
            }

            // Các kiểm tra khác tùy theo yêu cầu của bạn

            // Nếu tất cả kiểm tra thành công, cho phép gửi form
            return true;
        }
    </script>
</body>

</html>