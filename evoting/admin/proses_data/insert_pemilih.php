<?php
include '../template/database.php';

$nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);

$nowa = mysqli_real_escape_string($koneksi, $_POST['nowa']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);

$status = 0;

$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
$kode = substr(str_shuffle($karakter), 0, 5);

$getuser = mysqli_query($koneksi, "SELECT * FROM voter WHERE voter_nis='$nis'");
$user = mysqli_num_rows($getuser);
if ($user > 0) {
	echo "available";
} else {
	$fileName = $_FILES['file_foto']['name'];
	$size = $_FILES['file_foto']['size'];

	if ($size >= 2000000) {
		echo "size";
	} else {

		$extensionAllow = array('png', 'jpg', 'jpeg');
		$x = explode('.', $fileName);
		$ekstensi = strtolower(end($x));
		$file_tmp = $_FILES['file_foto']['tmp_name'];
		$randNumber     = rand(1, 999);
		$newNameFile = $randNumber . '-' . $fileName;
		if (in_array($ekstensi, $extensionAllow) === true) {
			move_uploaded_file($file_tmp, '../../assets_back/verify_pemilih/'.$newNameFile); 
			$query = mysqli_query($koneksi, "INSERT INTO voter VALUES(NULL, '$nis', '$nama', '$kelas','$nowa', '$email', '$status', '$kode', '$newNameFile') ");
			if ($query) {
				echo "success";
			} else {
				echo "error";
			}
		} else {
			echo "extentions";
		}
	}
}
