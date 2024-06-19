<?php
include '../template/database.php';

$name = mysqli_real_escape_string($koneksi,$_POST['nama_lengkap']);
$username = mysqli_real_escape_string($koneksi,$_POST['username']);
$user = str_replace(" ", "", $username);
$password = mysqli_real_escape_string($koneksi,$_POST['password']);
$pass = md5($password);
$role = mysqli_real_escape_string($koneksi,$_POST['role']);

$query = mysqli_query($koneksi,"INSERT INTO user(user_username, user_password, user_nama, user_role) VALUES('$user', '$pass', '$name', '$role') ");
if ($query) {
   echo "success";
}else{
    echo "error";
}

?>