<?php
error_reporting(0);
include '../template/database.php';

$nameFaculty = mysqli_real_escape_string($koneksi, $_POST['nama_sekolah']);
$decription = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$keyword = mysqli_real_escape_string($koneksi, $_POST['keyword']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$nowa = mysqli_real_escape_string($koneksi, $_POST['nowa']);
$status = mysqli_real_escape_string($koneksi, $_POST['status']);
$url = mysqli_real_escape_string($koneksi, $_POST['url']);

$fileName = $_FILES['logo']['name'];
$size = $_FILES['logo']['size'];

if ($fileName != "") {
	if ($size >= 2000000) {
		echo "ukuran";
	} else {
		$extensionAllow = array('png', 'jpg', 'jpeg');
		$x = explode('.', $fileName);
		$ekstensi = strtolower(end($x));
		$file_tmp = $_FILES['logo']['tmp_name'];
		$randNumber     = rand(1, 999);
		$newNameFile = $randNumber . '-' . $fileName;
		if (in_array($ekstensi, $extensionAllow) === true) {
			move_uploaded_file($file_tmp, '../../assets_back/' . $newNameFile);
			$result = mysqli_query($koneksi, "UPDATE settings SET setting_school_name='$nameFaculty', setting_description='$decription', setting_keyword='$keyword', setting_favicon='$newNameFile', setting_email='$email', setting_phone_number='$nowa', setting_schedule='$status', setting_url='$url' WHERE id_setting=1 ");
			if (!$result) {
				echo "error";
			} else {
				echo "success";
			}
		} else {
			echo "extentions";
		}
	}
} else {
	$result = mysqli_query($koneksi, "UPDATE settings SET setting_school_name='$nameFaculty', setting_description='$decription', setting_keyword='$keyword', setting_email='$email', setting_phone_number='$nowa', setting_schedule='$status', setting_url='$url' WHERE id_setting=1 ");
	if (!$result) {
		echo "error";
	} else {
		echo "success";
	}
}
