<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {
    try {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->Debugoutput = 'html'; // Output format for debug

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ganery231@gmail.com';
        $mail->Password = 'urgmobzniymdbtxj'; // Use app-specific password if 2FA is enabled
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        //Recipients
        $mail->setFrom('ganery231@gmail.com', 'Mailer');
        $mail->addAddress($_POST['email']); // Add a recipient

        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $_POST['subject'];
        $mail->Body    = $_POST['message'];
        $mail->AltBody = strip_tags($_POST['message']); // Alternative plain text body

        if ($mail->send()) {
            echo "
            <script>
            alert('Sent Successfully');
            document.location.href = 'otp.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Failed to send email. Error: {$mail->ErrorInfo}');
            </script>
            ";
        }
    } catch (Exception $e) {
        echo "
        <script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMTPJS TUT</title>
</head>
<body>
    <form id="submit" action="" method="post">
        Email <input type="email" name="email" required>
        Subject <input type="text" name="subject" required>
        Message <input type="text" name="message" required>
        <input type="submit" name="send" value="Send">
    </form>
</body>
</html>
