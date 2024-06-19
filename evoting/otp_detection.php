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
        // $mail->SMTPDebug = 2; // Enable verbose debug output
        // $mail->Debugoutput = 'html'; // Output format for debug

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Organization Chair Election Website</title>
    <!-- Bootstrap CSS -->
    <link href="assets_back/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="assets_back/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        background-color: #f8f9fa;
    }

    .container-login {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card-login {
        max-width: 500px;
        border-radius: 10px;
    }

    .login-form {
        padding: 20px;
    }

    /* Updated button alignment */
    .btn {
        float: right; /* Align buttons to the right */
        margin-left: 200px; /* Add some space between buttons */
    }
</style>

</head>

<?php
session_start();
?>
<body>
    <!-- Login Content -->
    <div class="container-login">
        <div class="card shadow-sm my-5 p-4 card-login">
            <div class="card-body p-5">
                <div class="login-form">
                    <button class="btn btn-primary btn-block" type="button" onclick="window.location.href='deteksi/index.php'">DETECTION</button>
                    <form id="contact-form" action="" method="POST">
                        <label>
                            <input type="email" name="email" value="<?php echo $_SESSION['voter_email'] ?>" hidden>
                        </label>
                        <label>
                            <input name="message" value="<?php echo $_SESSION['otp'] ?>" hidden></input>
                        </label>
                        <input type="text" name="subject" value="KODE OTP" hidden>
                        <!-- your other form fields go here -->
                        <button class="btn btn-primary btn-block" type="submit" name="send" value="Send">OTP SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets_back/vendor/jquery/jquery.min.js"></script>
    <script src="assets_back/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>