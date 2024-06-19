<?php
error_reporting(0);
session_start();
include '../database.php';

$nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
$kode = mysqli_real_escape_string($koneksi, $_POST['kode']);

$getkandidat = mysqli_query($koneksi, "SELECT * FROM candidates");
$count = mysqli_num_rows($getkandidat);

$get_pemilih = mysqli_query($koneksi, "SELECT * FROM voter WHERE voter_nis='$nis' AND voter_code='$kode'");
$pemilih = mysqli_fetch_array($get_pemilih);

$id_pemilih = $pemilih['id_voter'];
$cek_sudah = mysqli_query($koneksi, "SELECT * FROM voter_votes WHERE vote_voter_id='$id_pemilih'");
$sudah = mysqli_num_rows($cek_sudah);

if ($count > 0) {
	if ($sudah > 0) {
		echo "sudah";
	} else {
		$cek_login = mysqli_query($koneksi, "SELECT * FROM voter WHERE voter_nis='$nis' AND voter_code='$kode' AND voter_status='0'");
		$login_cek = mysqli_num_rows($cek_login);

		if ($login_cek > 0) {
			// Generate OTP
			$otp_length = 6;
			// Karakter yang diizinkan dalam kode OTP
			$characters = '0123456789';
			$otp = '';
			// Generate kode OTP secara acak
			for ($i = 0; $i < $otp_length; $i++) {
				$otp .= $characters[rand(0, strlen($characters) - 1)];
			}
			// Simpan OTP di sesi
			$_SESSION['otp'] = $otp;
			$_SESSION['otp_time'] = time(); // Waktu saat OTP dibuat
			// Simpan id voter
			$login = mysqli_fetch_array($cek_login);
			$_SESSION['id_voter'] = $login['id_voter'];
			$_SESSION['verification'] = $login['verification'];
			$_SESSION['auth'] = "auth";
			$_SESSION['voter_email'] =  $login['voter_email'];
			echo "success";
		} else {
			echo "error";
		}
	}
} else {
	echo "tidak_ada_kandidat";
}
