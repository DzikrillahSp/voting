<?php
session_start();
include '../template/database.php';
$password = mysqli_real_escape_string($koneksi,$_POST['password']);
$pass = md5($password);
$id = $_SESSION['id_user'];
$id_pemilih = array();

$cek_password = mysqli_query($koneksi,"SELECT * FROM user WHERE user_password='$pass' AND id_user='$id' ");
$cek = mysqli_num_rows($cek_password);

if ($cek > 0) {

	// DIBAWAH MERUPAKAN CODE APABILA KAMU CUMAN MENGHAPUS DATA SUARA PEMILIHAN SAJA TANPA PERLU MENGHAPUS DATA PEMILIH DAN KANDIDAT

	// $get_suara = mysqli_query($koneksi,"SELECT * FROM suara_pemilih");
	// while($suara = mysqli_fetch_array($get_suara)){
	// 	array_push($id_pemilih, $suara['suara_id_pemilih']);
	// }
	// $hapus = mysqli_query($koneksi,"DELETE FROM suara_pemilih");
	// if($hapus){
	// 	for ($i=0; $i < count($id_pemilih); $i++) { 
	// 		mysqli_query($koneksi,"UPDATE pemilih SET pemilih_status='0' WHERE id_pemilih='$id_pemilih[$i]'");
	// 	}
	// 	echo "sukses";
	// }else{
	// 	echo "gagal";
	// }


	// DIBAWAH MERUPAKAN CODE APABILA KAMU INGIN MENGHAPUS DATA PEMILIH, KANDIDAT DAN SUARA PEMILIH
	$hapus = mysqli_query($koneksi,"DELETE FROM voter");
	if($hapus){
		mysqli_query($koneksi,"DELETE FROM voter_votes");
		mysqli_query($koneksi,"DELETE FROM candidates");
		echo "success";
	}else{
		echo "failed";
	}

}else{
	echo "password_salah";
}


?>
