<?php
require_once ('../../db/dbhelper.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once '../../phpMailer/Exception.php';
require_once '../../phpMailer/PHPMailer.php';
require_once '../../phpMailer/SMTP.php';

$mail = new PHPMailer(true);

if(isset($_POST['send-mail'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $name = 'Clothing Store';
   

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'diepcamlee09@gmail.com';
    $mail->Password = 'wddadahiyequypui';
    $mail->SMTPSecure = "tls";
    $mail->Port = '587';

    $mail->setFrom('diepcamlee09@gmail.com');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Message received from Contact: ' . $name;
    $mail->Body = "Name: $name <br>Subject: $subject <br>Message: $message";

    $mail->send();
};

$sql = "UPDATE contacts_list SET reply = (reply + 1) WHERE id = $id";
execute($sql);
header('Location: ../contact.php');

?>