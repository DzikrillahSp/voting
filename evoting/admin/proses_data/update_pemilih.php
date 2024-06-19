<?php
error_reporting(0);

include '../template/database.php';
$id_voter = mysqli_real_escape_string($koneksi, $_POST['id_voter']);
$nis = mysqli_real_escape_string($koneksi, $_POST['nis_update']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama_update']);
$kelas = mysqli_real_escape_string($koneksi, $_POST['kelas_update']);
$nowa = mysqli_real_escape_string($koneksi, $_POST['nowa_update']);
$email = mysqli_real_escape_string($koneksi, $_POST['email_update']);

$fileName = $_FILES['file_foto_update']['name'];
$size = $_FILES['file_foto_update']['size'];

if ($size >= 2000000) {

	echo "size";
} else {

	if ($fileName != "") {
		$extensionAllow = array('png', 'jpg', 'jpeg');
		$x = explode('.', $fileName);
		$ekstensi = strtolower(end($x));
		$file_tmp = $_FILES['file_foto_update']['tmp_name'];
		$randNumber     = rand(1, 999);
		$newNameFile = $randNumber . '-' . $fileName;
		if (in_array($ekstensi, $extensionAllow) === true) {
			move_uploaded_file($file_tmp, '../../assets_back/verify_pemilih/' . $newNameFile);
			$query = mysqli_query($koneksi, "UPDATE voter SET voter_nis='$nis', voter_name='$nama', voter_faculty='$kelas', voter_phone_number='$nowa', voter_email='$email', verification='$newNameFile' WHERE id_voter='$id_voter'");
			if ($query) {
				echo "success";
			} else {
				echo "error";
			}
		} else {
			echo "extentions";
		}
		
	} else {
		$query = mysqli_query($koneksi, "UPDATE voter SET voter_nis='$nis', voter_name='$nama', voter_faculty='$kelas', voter_phone_number='$nowa', voter_email='$email' WHERE id_voter='$id_voter'");
		if ($query) {
			echo "success";
		} else {
			echo "error";
		}
	}
}
