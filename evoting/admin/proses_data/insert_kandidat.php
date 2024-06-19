<?php
include '../template/database.php';

$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$link = mysqli_real_escape_string($koneksi, $_POST['link']);
$ckeditor = mysqli_real_escape_string($koneksi, $_POST['ckeditor']);

$fileName = $_FILES['file_foto']['name'];
$size = $_FILES['file_foto']['size'];

if ($size >= 2000000) {
	echo "ukuran";
} else {

	if ($fileName != "") {
		$extensionAllow = array('png', 'jpg', 'jpeg');
		$x = explode('.', $fileName);
		$ekstensi = strtolower(end($x));
		$file_tmp = $_FILES['file_foto']['tmp_name'];
		$randNumber     = rand(1, 999);
		$newNameFile = $randNumber . '-' . $fileName;
		if (in_array($ekstensi, $extensionAllow) === true) {
			move_uploaded_file($file_tmp, '../../assets_back/foto_kandidat/' . $newNameFile);
			$result = mysqli_query($koneksi, "INSERT INTO candidates VALUES(NULL, '$nama', '$ckeditor', '$newNameFile', '$link')");
			if (!$result) {
				echo "error";
			} else {
				echo "success";
			}
		} else {
			echo "extentions";
		}
	} else {
		$result = mysqli_query($koneksi, "INSERT INTO candidates VALUES(NULL, '$nama', '$ckeditor', null, '$link')");
		if (!$result) {
			echo "error";
		} else {
			echo "success";
		}
	}
}
