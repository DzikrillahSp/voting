<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require'email/phpmailer/phpmailer/src/Exception.php';
require'email/phpmailer/phpmailer/src/PHPMailer.php';
require'email/phpmailer/phpmailer/src/SMTP.php';
require '../template/database.php';

if (isset($_POST['generate'])) {

	$id = $_POST['id'];
	$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
	$code = substr(str_shuffle($karakter), 0, 5);

	$update = mysqli_query($koneksi,"UPDATE voter SET voter_code='$code' WHERE id_voter='$id'");
	if ($update) {
		echo "success";
	}else{
		echo "error";
	}

}

if (isset($_POST['status'])) {
	$status = "0";
	$voterId = array();

	// $get_pemilih = mysqli_query($koneksi,"SELECT id_pemilih FROM pemilih");
	// while ($pemilih = mysqli_fetch_array($get_pemilih)) {
	// 	array_push($id_pemilih, $pemilih['id_pemilih']);
	// }

	$getVoted = mysqli_query($koneksi,"SELECT vote_voter_id FROM voter_votes");
	while($voted = mysqli_fetch_array($getVoted)){
		array_push($voterId, $voted['vote_voter_id']);
	}

	$delete = mysqli_query($koneksi,"DELETE FROM voter_votes");
	if ($delete) {
		for ($i=0; $i < count($voterId); $i++) { 
			mysqli_query($koneksi,"UPDATE voter SET voter_status='$status' WHERE id_voter='$voterId[$i]'");
		}

		echo "success";
	}else{
		echo "error";
	}
}

if (isset($_POST['generate_all'])) {

	$voterId = array();

	$getVoter = mysqli_query($koneksi,"SELECT id_voter FROM voter");
	while ($voter = mysqli_fetch_array($getVoter)) {
		array_push($voterId, $voter['id_voter']);
	}

	for ($i=0; $i < count($voterId); $i++) { 
		$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
		$code = substr(str_shuffle($karakter), 0, 5);
		mysqli_query($koneksi,"UPDATE voter SET voter_code='$code' WHERE id_voter='$voterId[$i]'");
	}

	echo "success";
}

if (isset($_POST['send_email'])) {

	$data_user = array();
	$output = "";

	$getSetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
	$setting = mysqli_fetch_array($getSetting);

	$nameSchool = "Panitia E-Voting ".$setting['setting_school_name']."";
	$emailSchool = $setting['setting_email'];
	$urlSchool = $setting['setting_url'];

	$get_user = mysqli_query($koneksi,"SELECT * FROM voter");
	while ($user = mysqli_fetch_array($get_user)) {
		if($user['voter_email'] == ""){
			continue;
		}
		array_push($data_user, array(
			'nama' => $user['voter_name'],
			'email' => $user['voter_email'],
			'username' => $user['voter_nis'],
			'password' => $user['voter_code']
		));
	}

	foreach ($data_user as $key) {
		
		$mail = new PHPMailer;
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;

		//ganti dengan email dan password yang akan di gunakan sebagai email pengirim
		$mail->Username = 'emailkamu@gmail.com';
		$mail->Password = 'passwordgmailmu';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;

		//ganti dengan email yg akan di gunakan sebagai email pengirim
		$mail->setFrom($emailSchool, $nameSchool);
		$mail->addAddress($key['email'], $key['nama']);
		$mail->isHTML(true);
		$mail->Subject = "Access E-Voting Login";
		$mail->Body = "
		Hello, I am the E-Voting committee and would like to provide login access to the website to conduct elections. 
		<br><br>
		Username: <b>".$key['username']."</b> <br>
		Access Code : <b>".$key['password']."</b><br>
		Link login : <a href='".$urlSchool."'>Click Here</a>
		<br><br>
		Use your voting rights as best as possible!";

		$result = $mail->Send();

		if($result['code'] == '400'){
			$output .= html_entity_decode($result['full_error']);
		}
	}

	if($output == ''){
		echo 'success';
	}else{
		echo $output;
	}

}

?>