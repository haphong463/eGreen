<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sigh in</title>

    <!-- BStrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BStrap link -->

    <!-- cacha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- link Icon https://boxicons.com -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/contact.css">

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .backToIndex {
        position: absolute;
        top: 10px;
        left: 20px;
    }
</style>

<body>
    <?php
    include('part/header.php');
    ?>
    <div class="register-link">
        <p><a class="backToIndex" href="index.php"><i class='bx bxs-chevrons-left'></i></a></p>
    </div>
    <div class="Wap">
        <div class="wrapper">
            <form action="">
                <div class="row">
                    <div class="col-lg-7">
                        <h2 class="text-center">Feedback</h2>
                        <hr>

                        <div class="input-box">
                            <input type="text" placeholder="Your name">
                            <i class='bx bxs-user'></i>
                        </div>

                        <div class="input-box">
                            <input type="text" placeholder="Email">
                            <i class='bx bxs-envelope'></i>
                        </div>

                        <div class="input-box">
                            <input type="text" placeholder="Subject">
                            <i class='bx bx-mail-send'></i>
                        </div>

                        <div class="input-box Message">
                            <input type="text" placeholder="Message">
                            <i class='bx bxs-chat'></i>
                        </div>

                        <div class="g-recaptcha" data-sitekey="6Le6YLAmAAAAADt-BWjqFOTkwFGnM38b-YAiCoW5" style="float: left;"></div>

                        <br><br>

                        <button type="submit" class="btn" style="margin-top: 10px;">Send</button>
                    </div>




                    <div class="col-lg-5">
                        <div class="register-link" style="float: right; text-align:left;padding-right:10%;">
                            <h1>Contact Us</h1>
                            <hr>

                            <p><span>Address:</span><br> 198 West 21th Street, Suite 721 New York NY 10016</p>
                            <p><span>Phone:</span> <a href="tel://1234567920"><br>+1235 2355 98</a></p>
                            <p><span>Email:</span> <a href="mailto:davidphuc91@gmail.com"><br>davidphuc91@gmail.com</a></p>
                            <p><span>Website</span> <a href="#"><br>yoursite.com</a></p>

                        </div>
                    </div>


                </div>

            </form>
        </div>
    </div>
</body>

</html>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>