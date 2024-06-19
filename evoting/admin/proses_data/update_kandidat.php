<?php
error_reporting(0);
include '../template/database.php';

$candidateId = mysqli_real_escape_string($koneksi, $_POST['candidate_id']);
$nama_update = mysqli_real_escape_string($koneksi, $_POST['nama_update']);
$lin_update = mysqli_real_escape_string($koneksi, $_POST['link_update']);
$ckeditor_update = mysqli_real_escape_string($koneksi, $_POST['ckeditor_update']);

$fileName = $_FILES['file_foto_update']['name'];
$size = $_FILES['file_foto_update']['size'];

if ($size >= 2000000) {
	echo "ukuran";
} else {

	if ($fileName != "") {


		$extensionAllow = array('png', 'jpg', 'jpeg');
		$x = explode('.', $fileName);
		$ekstensi = strtolower(end($x));
		$file_tmp = $_FILES['file_foto_update']['tmp_name'];
		$randNumber     = rand(1, 999);
		$newNameFile = $randNumber . '-' . $fileName;
		if (in_array($ekstensi, $extensionAllow) === true) {

			$quer = "SELECT candidate_photo FROM candidates WHERE candidate_id='$candidateId'";
			$sq = mysqli_query($koneksi, $quer); // Eksekusi/Jalankan query dari variabel $query
			$dta = mysqli_fetch_array($sq); // Ambil data dari hasil eksekusi $sql
			unlink("../../assets_back/foto_kandidat/" . $dta['candidate_photo']);
			move_uploaded_file($file_tmp, '../../assets_back/foto_kandidat/' . $newNameFile);
			$result = mysqli_query($koneksi, "UPDATE candidates SET candidate_name='$nama_update', candidate_description='$ckeditor_update', candidate_photo='$newNameFile', candidate_video='$lin_update' WHERE candidate_id='$candidateId' ");
			if (!$result) {
				echo "error";
			} else {
				echo "success";
			}
		} else {
			echo "extentions";
		}
	} else {
		$result = mysqli_query($koneksi, "UPDATE candidates SET candidate_name='$nama_update', candidate_description='$ckeditor_update', candidate_video='$lin_update' WHERE candidate_id='$candidateId' ");
		if (!$result) {
			echo "error";
		} else {
			echo "success";
		}
	}
}
