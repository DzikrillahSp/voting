<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'email/phpmailer/phpmailer/src/Exception.php';
require 'email/phpmailer/phpmailer/src/PHPMailer.php';
require 'email/phpmailer/phpmailer/src/SMTP.php';
include '../template/database.php'; 

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $voterId = $_POST['id'];

    $getSetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
    $setting = mysqli_fetch_array($getSetting);

    $getVoter = mysqli_query($koneksi,"SELECT * FROM voter WHERE id_voter='$voterId'");
    $voter = mysqli_fetch_array($getVoter);

    $emailVoter = $voter['voter_email'];
    $nameVoter = $voter['voter_name'];

    $usernameVoter = $voter['voter_nis'];
    $passwordVoter = $voter['voter_code'];

    $nameSchool = "Panitia E-Voting ".$setting['setting_school_name']."";
    $emailSchool = $setting['setting_email'];
    $urlSchool = $setting['setting_url'];

    if(empty($emailVoter) || empty($nameVoter) || empty($usernameVoter) || empty($passwordVoter) || empty($nameSchool) || empty($emailSchool) || empty($urlSchool)) {
        echo "error: Some data is missing";
    } else {
        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ganery231@gmail.com';
        $mail->Password = 'urgmobzniymdbtxj'; // Use app-specific password if 2FA is enabled
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
       // Link login : <a href='".$urlSchool."'>Click Here</a>
        $mail->setFrom($emailSchool, $nameSchool);
        $mail->addAddress($emailVoter, $nameVoter);
        $mail->isHTML(true);
        $mail->Subject = "Access E-Voting Login";
        $mail->Body = "
        Hello, I am the E-Voting committee and would like to provide login access to the website to conduct elections.
        <br><br>
        Username: <b>".$usernameVoter."</b> <br>
        Access Code : <b>".$passwordVoter."</b><br>
        
        <br><br>
        Use your voting rights as best as possible!";

        if (!$mail->send()) {
            echo "error: Failed to send email. Error: ".$mail->ErrorInfo;
        } else {
            echo "success";
        }
    }
} else {
    echo "error: No voter ID provided";
}
?>
