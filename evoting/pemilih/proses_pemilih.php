<?php 
session_start();
date_default_timezone_set("Asia/Jakarta");
include '../database.php';

$id_kandidat = $_POST['id'];
$id_voter = $_SESSION['id_voter'];
$waktu = date("Y-m-d h:i:sa");

$query = mysqli_query($koneksi,"INSERT INTO voter_votes VALUES(NULL, '$id_kandidat','$id_voter', NOW())");
if ($query) {
	mysqli_query($koneksi,"UPDATE voter SET voter_status='1' WHERE id_voter='$id_voter'");
	echo "success";
}else{
	echo "error";
}
?>