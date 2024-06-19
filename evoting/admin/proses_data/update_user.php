<?php 
include '../template/database.php';
$userID = mysqli_real_escape_string($koneksi,$_POST['id_user']);
$name = mysqli_real_escape_string($koneksi,$_POST['nama_lengkap_update']);
$username = mysqli_real_escape_string($koneksi,$_POST['username_update']);
$user = str_replace(" ", "", $username);
$password = mysqli_real_escape_string($koneksi,$_POST['password_update']);

$role = mysqli_real_escape_string($koneksi,$_POST['role_update']);

if ($password == "") {

	$query = mysqli_query($koneksi,"UPDATE user SET user_nama='$name', user_username='$user', user_role='$role' WHERE id_user='$userID' ");
	if ($query) {
		echo "success";
	}else{
		echo "error";
	}

}else{
	$pass = md5($password);
	$query = mysqli_query($koneksi,"UPDATE user SET user_nama='$name', user_username='$user', user_password='$pass', user_role='$role' WHERE id_user='$userID' ");
	if ($query) {
		echo "success";
	}else{
		echo "error";
	}
}
?>