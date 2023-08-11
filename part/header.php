<!-- navbar -->
<nav class="navbar navbar-expand-md" id="navbar" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php" id="logo">
        TechWiz
    </a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span>
            <i class='bx bx-expand' style="width: 30px; color: aliceblue;"></i>
        </span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">

        <ul class="navbar-nav">

            <!-- dropdown -->
            <!-- Default dropend button -->

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Shop
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#">mlem1</a></li>
                    <li><a class="dropdown-item" href="#">mlem1</a></li>
                    <li><a class="dropdown-item" href="shop.php">All</a></li>
                </ul>
            </div>
            <!-- dropdown -->

            <li class="nav-item">
                <a class="nav-link" href="login.php">login</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="contact.php">contact</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="Blog.php">Blog</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="aboutUs.php">About us</a>
            </li>

            <li class="nav-item">
                <!-- style="position: absolute; bottom:10px;right:10px;" -->


            </li>

        </ul>
    </div>

    <div class="icons">

        <i class='bx bx-user' style="width: 30px; color: aliceblue;"></i>
        <a href="lovelist.php"><i class='bx bx-heart' style="width: 30px; color: aliceblue;"></i></a>
        <a href="cart.php"><i class='bx bx-basket' style="width: 30px; color: aliceblue;"></i></a>
        <!-- HTML !-->


        <!-- <i class='bx bx-qr-scan' style="width: 30px; color: aliceblue;"></i> -->
    </div>
</nav>
<!-- navbar end -->


<div id="hiddenDiv" class="hidden">
    <div class="flexbox">
        <div class="chat-box">
            <div class="chat-box-header">
                <h3>Chat to contact customer
                    <button id="hideButton" class="button-48" role="button" style="float:right;margin-bottom:32%;"><span class="text">X</span></button>
                    <br /><small>Last active: 0 min ago</small>
                </h3>
            </div>
            <div id="chat_box_body" class="chat-box-body">
                <div id="chat_messages">


                    <div class="profile other-profile">
                        <img src="https://images.unsplash.com/photo-1537396123722-b93d0acd8848?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=efc6e85c24d3cfdd15cd36cb8a2471ed" width="30" height="30" />
                        <span>Other profile</span>
                    </div>
                    <div class="message other-message">
                        Hello!
                    </div>


                    <div class="profile my-profile">
                        <span>My profile</span>
                        <img src="https://images.unsplash.com/photo-1534135954997-e58fbd6dbbfc?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=02d536c38d9cfeb4f35f17fdfaa36619" width="30" height="30" />
                    </div>
                    <div class="message my-message">
                        Hi!
                    </div>
                    <div class="message my-message">
                        How are you!
                    </div>


                </div>
            </div>
            <div id="typing">
                <div><span></span> <span></span> <span></span> <span class="n">Someone</span> is typing...</div>
            </div>
            <div class="chat-box-footer">
                <textarea id="chat_input" placeholder="Enter your message here..."></textarea>
                <button id="send">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="#006ae3" d="M2,21L23,12L2,3V10L17,12L2,14V21Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>




<!-- chat -->

<style>
    /* .flexbox {
        background-color: black;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    } */


    /* CSS */


    .button-48 {
        appearance: none;
        background-color: #FFFFFF;
        border-width: 0;
        box-sizing: border-box;
        color: #000000;
        cursor: pointer;
        display: inline-block;
        font-family: Clarkson, Helvetica, sans-serif;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0;
        line-height: 1em;
        margin: 0;
        opacity: 1;
        outline: 0;
        padding: 1.5em 2.2em;
        position: relative;
        text-align: center;
        text-decoration: none;
        text-rendering: geometricprecision;
        text-transform: uppercase;
        transition: opacity 300ms cubic-bezier(.694, 0, 0.335, 1), background-color 100ms cubic-bezier(.694, 0, 0.335, 1), color 100ms cubic-bezier(.694, 0, 0.335, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: baseline;
        white-space: nowrap;

        position: fixed;
        right: 2%;
        bottom: 5%;
        z-index: 1;
        border-radius: 50px;
    }

    .button-48:before {
        animation: opacityFallbackOut .5s step-end forwards;
        backface-visibility: hidden;
        background-color: #EBEBEB;
        clip-path: polygon(-1% 0, 0 0, -25% 100%, -1% 100%);
        content: "";
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        transform: translateZ(0);
        transition: clip-path .5s cubic-bezier(.165, 0.84, 0.44, 1), -webkit-clip-path .5s cubic-bezier(.165, 0.84, 0.44, 1);
        width: 100%;

        border-radius: 50px;
    }

    .button-48:hover:before {
        animation: opacityFallbackIn 0s step-start forwards;
        clip-path: polygon(0 0, 101% 0, 101% 101%, 0 101%);
    }

    .button-48:after {
        background-color: #FFFFFF;
    }

    .button-48 span {
        z-index: 1;
        position: relative;
    }

    /* nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn */
    .hidden {
        display: none;
    }

    .chat-box {
        background-color: #fff;
        margin: 20px;
        width: 100%;
        height: 60%;
        max-height: calc(100% - 40px);
        display: flex;
        flex-direction: column;
        border-radius: 13px;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.3);

        position: fixed;
        bottom: 13%;
        right: 0;
        z-index: 1;
    }

    .chat-box>.chat-box-header {
        width: 100%;
        padding: 20px 15px;
        border-bottom: solid 1px #cfcfcf;
        box-sizing: border-box;
    }

    .chat-box>.chat-box-body {
        height: 100%;
        display: flex;
        overflow: auto;
        display: flex;
        flex-direction: column;
    }

    .chat-box>.chat-box-body #chat_messages {
        width: 100%;
        padding: 20px 15px;
        margin-top: auto;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .chat-box>.chat-box-body #chat_messages .message {
        width: 80%;
        padding: 20px 15px;
        margin: 2px 0;
        overflow: hidden;
        border-radius: 13px;
        transition: height 0.3s ease-in-out;
    }

    .chat-box>.chat-box-body #chat_messages .message.hide {
        height: 0;
    }

    .chat-box>.chat-box-body #chat_messages .my-message {
        color: #fff;
        background-color: #006ae3;
        align-self: flex-end;
    }

    .chat-box>.chat-box-body #chat_messages .other-message {
        background-color: #e2e2e2;
    }

    .chat-box>.chat-box-body #chat_messages .profile {
        margin: 2px 0;
        overflow: hidden;
        transition: height 0.3s ease-in-out;
    }

    .chat-box>.chat-box-body #chat_messages .profile.hide {
        height: 0;
    }

    .chat-box>.chat-box-body #chat_messages .profile img {
        display: inline-block;
        margin: 0;
        padding: 0;
        vertical-align: middle;
        border-radius: 50%;
    }

    .chat-box>.chat-box-body #chat_messages .my-profile {
        color: #afafaf;
        align-self: flex-end;
    }

    .chat-box>.chat-box-body #chat_messages .other-profile {
        color: #afafaf;
    }

    .chat-box #typing {
        color: #afafaf;
        width: 100%;
        height: 0;
        padding: 0 15px;
        overflow: hidden;
        box-sizing: border-box;
        opacity: 0;
        transition: 0.3s height ease-in-out, 0.3s opacity ease-in-out;
    }

    .chat-box #typing.active {
        height: 80px;
        opacity: 1;
    }

    .chat-box #typing span:not(.n) {
        background-color: #afafaf;
        width: 10px;
        height: 10px;
        margin-top: 20px;
        display: inline-block;
        border-radius: 50%;
    }

    .chat-box #typing span:not(.n):nth-child(1) {
        animation: typing 1.2s infinite;
    }

    .chat-box #typing span:not(.n):nth-child(2) {
        animation: typing 1.2s infinite 0.1s;
    }

    .chat-box #typing span:not(.n):nth-child(3) {
        animation: typing 1.2s infinite 0.2s;
    }

    .chat-box>.chat-box-footer {
        width: 100%;
        padding: 20px 15px;
        border-top: solid 1px #cfcfcf;
        box-sizing: border-box;
        display: flex;
    }

    .chat-box>.chat-box-footer>#chat_input {
        color: #2f2f2f;
        font-family: Raleway, sans-serif;
        font-size: 16px;
        background-color: #d2d2d2;
        width: 100%;
        height: 40px;
        max-height: 120px;
        border: none;
        padding: 10px 15px;
        resize: none;
        box-sizing: border-box;
        border-radius: 13px;
        transition: 0.3s background-color;
    }

    .chat-box>.chat-box-footer>#chat_input:focus {
        background-color: #efefef;
    }

    .chat-box>.chat-box-footer>#send {
        background: none;
        border: none;
        margin-left: 10px;
        padding: 5px;
        cursor: pointer;
        border-radius: 50%;
    }

    @media (min-width: 480px) {
        .chat-box {
            width: 480px;
        }
    }

    @keyframes typing {
        0% {
            transform: translateY(0px);
        }

        33.3333% {
            transform: translateY(-5px);
        }

        66.6667% {
            transform: translateY(5px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    button::-moz-focus-inner {
        border-style: none;
        padding: 0;
    }

    button {
        outline: none;
    }

    h3>small {
        color: #afafaf;
        font-weight: normal;
    }
</style>