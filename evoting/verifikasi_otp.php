<?php
session_start();

// Periksa apakah OTP dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil OTP yang dimasukkan oleh pengguna
    $user_otp = $_POST['otp'];

    // Ambil OTP dari session
    $session_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;

    // Periksa apakah OTP sesuai
    if ($user_otp === $session_otp) {
        // OTP sesuai, arahkan pengguna ke halaman pemilih/bilik.php
        echo "<script>alert('Valid OTP. You will be directed to the voter page.');window.location='pemilih/bilik.php';</script>";
        exit();
    } else {
        // OTP tidak sesuai, tampilkan pesan kesalahan
        // echo "OTP tidak valid. Silakan coba lagi.";
        echo "<script>alert('Invalid OTP. Please try again.');
        window.location.href='./otp.php'
        </script>";
    }
} else {
    // Jika halaman diakses tanpa melalui form submission, arahkan kembali ke form OTP
    header("Location: /evoting/otp_detection.php");
    exit();
}
?>
