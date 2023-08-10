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
    <link rel="stylesheet" href="css/box.css">


    <!-- icon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- icon link end -->

    <!-- animation link -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation link -->


</head>
<style>
    .comment-form textarea {
        width: 100%;
        height: 70px;
        margin-bottom: 5px;
    }

    .open-button {
        background-color: #555;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 23px;
        right: 28px;
        width: 280px;
    }



    /* Add styles to the form container */
    .form-container {
        max-width: 300px;
        padding: 10px;
        background-color: white;
    }

    /* Full-width input fields */
    .form-container input[type=text],
    .form-container input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        border: none;
        background: #f1f1f1;
    }

    /* When the inputs get focus, do something */
    .form-container input[type=text]:focus,
    .form-container input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Set a style for the submit/login button */
    .form-container .btn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
        background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover,
    .open-button:hover {
        opacity: 1;
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

    ::selection {
        background-color: #333;
        color: #fff;
    }

    #review,
    #description {
        margin-top: 30px;
    }

    #review {
        border: 1px solid #333;
    }

    .review-btn {
        font-family: var(--ft1);
        font-weight: 700;
        display: inline-block;
        width: auto;
        text-decoration: none;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        border: 2px solid #111;
        background-color: #111;
        color: #fff;
        text-transform: uppercase;
        line-height: 1;
        transition: all .3s ease-in-out;
        font-size: 13px;
        padding: 10px 24px;
        white-space: nowrap;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-user-select: none;
        user-select: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0;
    }

    .review-btn:hover {
        color: #111;
        background-color: #fff;
        border-color: #111;
        opacity: 1;
    }

    button#add_review {
        float: right;
    }

    .review-header {
        font-size: 13px;
        font-weight: 700;
        font-style: italic;
        text-transform: capitalize;

    }

    .review-option {
        display: none;
    }



    .card-body {
        padding: 0 1.25rem !important;
    }

    .text-warning {
        color: #000000 !important;
    }

    .pagination {
        margin: 10px;
    }

    .pagination a {
        border: 1px solid #333;
        background-color: #333;
        color: #fff;
        margin: 0 5px;
    }

    .pagination a:hover {
        transition: .5s;
        background-color: transparent;
        color: #333;
    }

    /* css for rating */
    .progress-label-left {
        float: left;
        margin-right: 0.5em;
        line-height: 1em;
    }

    .progress-label-right {
        float: right;
        margin-left: 0.3em;
        line-height: 1em;
    }

    .star-light {
        color: #e9ecef;
    }

    .error {
        color: red;
    }

    .inner-header .header-right {
        float: right;
        line-height: 42px;
    }


    .inner-header .header-right a {
        display: inline-block;
        position: relative;
        color: #333;
        letter-spacing: 4px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    button.tab-button {
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        position: relative;
        letter-spacing: .02em;
        display: block;
        padding: 10px 25px;
        outline: none;
        background: #eee;
        color: #333;
        border: none;
    }

    button.tab-button.active,
    button.tab-button:hover {
        transition: .5s;
        opacity: 1;
        text-decoration: none;
        background-color: #fff;
        color: #000;
    }

    .product-tabs {
        display: flex;
        justify-content: center;
    }

    .hero-items .owl-nav button[type=button].owl-next {
        left: auto;
        right: 60px;
        display: inline-block;
    }

    button.add-to-cart {
        height: 56px;
        width: 173px;
        border: 2px solid #EEF1F2;
        border-radius: 50px;
        cursor: pointer;
        color: white;
        background-color: black;
        font-weight: 600
    }

    .hero-items .owl-nav button[type=button] {
        background-color: transparent !important;
    }


    .pro-quantity {
        display: flex;
    }

    .pro-quantity input[type=number] {
        border: 1px solid #333;
        width: 40px;
        height: 40px;
        text-align: center;

    }


    .pro-quantity input[type="number"]::-webkit-inner-spin-button,
    .pro-quantity input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .pro-quantity input[type="number"] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    button.quantity {
        border: 1px solid #333;
        background-color: #fff;
        padding: 2px 4px;
        width: 40px;
        height: 40px;
        cursor: pointer;
    }

    button.add,
    button.add a {
        color: #fff;
        background-color: #333;
        cursor: pointer;
        width: 150px;
        padding: 8px 12px;
        margin: 15px 0;
    }



    .pd-size-choose {
        margin-bottom: 30px;
    }

    .pd-size-choose .sc-item {
        display: inline-block;
        margin-right: 5px;
    }

    .pd-size-choose .sc-item:last-child {
        margin-right: 0;
    }

    .pd-size-choose .sc-item input {
        position: absolute;
        visibility: hidden;
    }

    .pd-size-choose .sc-item label {
        font-size: 16px;
        color: #252525;
        font-weight: 700;
        height: 40px;
        width: 47px;
        border: 1px solid #ebebeb;
        text-align: center;
        line-height: 40px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .pd-size-choose .sc-item input[type="radio"]:checked+label {
        background-color: #333;
        color: #ffffff;
    }

    .square-radio {
        display: inline-block;
        position: relative;
        width: 40px;
        height: 40px;
        border: 2px solid #e6e6e6;
        border-radius: 50%;
        cursor: pointer;
    }

    .square-radio input[type="radio"] {
        display: none;
    }

    .square-radio span {
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    /* Thay đổi màu nền của hình tròn bên trong */
    .square-radio input[type="radio"]:checked+span {
        background-color: var(--color);
    }

    .register-login-section {
        padding-top: 72px;
        padding-bottom: 80px;
    }

    .register-form h2,
    .login-form h2 {
        color: #252525;
        font-weight: 700;
        text-align: center;
        margin-bottom: 35px;
    }

    .register-form form .group-input,
    .login-form form .group-input {
        margin-bottom: 25px;
    }

    .register-form form .group-input label,
    .login-form form .group-input label {
        display: block;
        font-size: 18px;
        color: #252525;
        margin-bottom: 13px;
    }

    .register-form form .group-input input,
    .login-form form .group-input input {
        border: 1px solid #ebebeb;
        height: 50px;
        width: 100%;
        padding-left: 20px;
        padding-right: 15px;
    }

    .register-form form .register-btn,
    .register-form form .login-btn,
    .login-form form .register-btn,
    .login-form form .login-btn {
        width: 100%;
        letter-spacing: 2px;
        margin-top: 5px;
    }

    .register-form .switch-login,
    .login-form .switch-login {
        text-align: center;
        margin-top: 22px;
    }

    .register-form .switch-login .or-login,
    .login-form .switch-login .or-login {
        color: #252525;
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
        position: relative;
    }

    .register-form .switch-login .or-login:before,
    .login-form .switch-login .or-login:before {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 2px;
        width: 100%;
        background: #9f9f9f;
        content: "";
    }





    input.site-btn.cupone {
        background-color: #333;
        color: #fff;
        margin-top: 15px;
        font-weight: 700;
        border: 0;
    }

    input.site-btn.cupone:hover {
        transition: .5s;
        background-color: transparent;
        color: #333;
    }

    .select-more {
        border: 1px solid #333;
        padding: 10px;
    }

    a.select-more {
        color: #333;
    }

    .sc-item.out-of-stock label {
        color: red;
        position: relative;
    }

    .sc-item.out-of-stock label .stock-status {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: black;
        opacity: 0.3;
        border-radius: 50%;
        height: 16px;
        font-size: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .product-details {
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: bold;
    }

    .product-info p {
        margin: 0;
        font-weight: 600;
    }

    .btn--small {
        padding: 0 10px;
        font-size: .92308em;
        border-width: 2px;
        line-height: 25px;
    }

    .btn--secondary {
        color: #fff;
        background-color: #e55151;
        border-color: #e55151;
    }

    .btn--secondary:hover {
        color: #fff;
        background-color: #111;
        border-color: #111;

    }

    span#quantities {
        display: block;
        font-weight: 600;
    }

    .vertical-line {
        border-left: 2px solid #ccc;
        height: 11vh;
        position: absolute;
    }

    .payment-method ul li {
        margin-left: 30px;
    }

    input#momoButton {
        width: 50px;
        height: 50px;
    }

    span.amount-cart {
        font-size: 12px;
        color: #1e1e1e;
        width: 18px;
        height: 18px;
        border: 2px solid #d0d7db;
        background: #fff;
        display: inline-block;
        line-height: 15px;
        text-align: center;
        border-radius: 50%;
        font-weight: 600;
        position: absolute;
        left: -9px;
        top: 14px;
    }

    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .popup.show {
        opacity: 1;
        visibility: visible;
    }

    .popup-content {
        display: flex;
        flex-direction: column;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        width: 400px;
        height: 500px;
        text-align: center;
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        justify-content: center;
    }

    .popup-buttons {
        margin-top: 15px;
        display: flex;
        justify-content: center;
    }

    .popup.show .popup-content {
        opacity: 1;
        transform: translateY(0);
    }

    .confirm-btn,
    .cancel-btn {
        margin: 0 8px;
        border: 1px solid #333;
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.5s, color 0.5s, border 0.5s;
        /* Thêm hiệu ứng chuyển đổi màu nền, màu chữ và viền */
    }

    .confirm-btn:hover,
    .cancel-btn:hover {
        background-color: transparent;
        color: #333;
        border: 1px solid #333;
    }

    .lookbok-section {
        margin-bottom: 150px;
    }

    .popup-2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }


    .popup-content-2 {
        display: flex;
        flex-direction: column;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        width: 400px;
        height: 300px;
        text-align: center;
        transform: translateY(50px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        justify-content: center;
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

                <h1 class="shopName">Order Details</h1>
                <div class="header-row__button">
                    <a href="#" class="btn"></a>
                </div>
            </div>
        </div>

    </div>
    <!-- home Section End-->

<br><br><br>
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Information</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                </thead>
                <tbody>


                    <tr>

                        <td>
                            <div class="product-info">
                                <div class="product-image">
                                    <img src="img/Daisies.jpg" width="250px" height="250px" alt="Product Image">
                                </div>
                                <div class="product-details">
                                    <h4 class="product-name">Hoa cuc</h4>
                                    <p class="product-info">Color: Vang</p>
                                    <p class="product-info">Gender: mlem mlem</p>
                                </div>
                            </div>
                        </td>

                        <td>$999</td>
                        <td>10</td>
                        <td>$9990</td>
                    </tr>

                </tbody>

                <tfoot>

                    <tr>
                        <td colspan="3"><b>Sub Total :</b></td>
                        <td>$999</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Discount $%$%@%^^# :</b></td>
                        <td>50%</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Shipping Fee :</b></td>
                        <td>$99</td>
                    </tr>

                    <tr>
                        <td colspan="3"><b>Total :</b></td>
                        <td><b>$99</b></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Button to open the pop-up -->
            <a class="order_back review-btn pull-right" href="#" onclick="openPopup()">CANCEL ORDER</a>

            <!-- The pop-up -->
            <div class="popup" id="popup">
                <div class="popup-content">
                    <h4>Are you sure you want to cancel this order?</h4>
                    <p>Please select a reason:</p>
                    <ul style="
                            text-align: left;
                            margin-left: 30px;
                            list-style: none;
                        ">
                        <li><input type="radio" name="cancelReason" value="out_of_stock"> Item is out of stock</li>
                        <li><input type="radio" name="cancelReason" value="decision"> Changed my purchase decision</li>
                        <li><input type="radio" name="cancelReason" value="changed_mind"> Changed my mind</li>
                        <li><input type="radio" name="cancelReason" value="other"> Other reason</li>

                    </ul>
                    <div class="popup-buttons">
                        <a href="cancel-order-process.php?order_id=' . $order_id . '&reason=" class="confirm-btn" id="confirmBtn" onclick="updateLink(event)">Yes</a>
                        <button onclick="closePopup()" class="cancel-btn">No</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function openPopup() {
            document.getElementById('popup').classList.add('show');
        }

        // Close the pop-up
        function closePopup() {
            document.getElementById('popup').classList.remove('show');
        }
    </script>


    <?php
    include('part/footer.php');
    ?>


    <a href="#" class="arrow">
        <i class='bx bx-up-arrow-alt'></i>
    </a>








    <script>
        // Open the pop-up




        function updateLink(reason) {
            var link = document.getElementById('confirmBtn');
            var order_id = <?php echo $order_id; ?>;
            link.href = "cancel-order-process.php?order_id=" + order_id + "&reason=" + reason;
        }

        // Add event listeners to the radio buttons
        function updateLink(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
            var link = event.target;
            var order_id = '<?php echo $order_id; ?>';
            var reason = document.querySelector('input[name="cancelReason"]:checked').value;
            link.href = "cancel-order-process.php?order_id=" + order_id + "&reason=" + reason;
            window.location.href = link.href; // Chuyển hướng trang đến đường dẫn đã cập nhật
        }
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>



</body>

</html>