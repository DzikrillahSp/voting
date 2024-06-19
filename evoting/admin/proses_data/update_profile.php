<?php 
session_start();
include '../template/database.php'; 
$userID = $_SESSION['id_user'];
$name = mysqli_real_escape_string($koneksi,$_POST['nama_lengkap']);
$username = mysqli_real_escape_string($koneksi,$_POST['username']);
$user = str_replace(" ", "", $username);
$password = mysqli_real_escape_string($koneksi,$_POST['password']);

if ($password == "") {

	$query = mysqli_query($koneksi,"UPDATE user SET user_nama='$name', user_username='$user' WHERE id_user='$userID' ");
	if ($query) {
		echo "success";
	}else{
		echo "error";
	}

}else{
	$pass = md5($password);
	$query = mysqli_query($koneksi,"UPDATE user SET user_nama='$name', user_username='$user', user_password='$pass' WHERE id_user='$userID' ");
	if ($query) {
		echo "success";
	}else{
		echo "error";
	}
}
?>