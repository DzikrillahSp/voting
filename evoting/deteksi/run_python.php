<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../database.php';

    // Get the name from the form submission
    $nama = escapeshellarg($_POST['nama']); // Escaping for security
    $id = $nama;
    $nama2 = $_POST['nama'];
    $rekamScript = escapeshellarg('rekam.py'); // Update this path
    $trainingScript = escapeshellarg('training.py'); // Update this path

    // Use exec to run the rekam.py script and pass the name as an argument
    $rekamOutput = shell_exec("python $rekamScript $nama $id 2>&1");

    // Check for errors in the rekam.py output
    if (strpos($rekamOutput, 'Error:') !== false || strpos($rekamOutput, 'Traceback (most recent call last):') !== false) {
        $_SESSION['flash_message'] = 'Error occurred during face recording.';
        $_SESSION['flash_type'] = 'danger';
        header("Location: ../auth_pemilih.php");
        exit;
    }

    // Use exec to run the training.py script after rekam.py has completed
    $trainingOutput = shell_exec("python $trainingScript 2>&1");
    // print($trainingOutput);
    // Check for errors in the training.py output
    if (strpos($trainingOutput, 'Error:') !== false || strpos($trainingOutput, 'Traceback (most recent call last):') !== false) {
        $_SESSION['flash_message'] = 'Error occurred during training.';
        $_SESSION['flash_type'] = 'danger';
        header("Location: ../auth_pemilih.php");
        exit;
    }

    $updateQuery = "UPDATE voter SET verification = 1 WHERE id_voter='$nama2'";
    if (mysqli_query($koneksi, $updateQuery)) {
        $_SESSION['flash_message'] = 'Process completed successfully.';
        $_SESSION['flash_type'] = 'success';
        $_SESSION['verification'] = 1;
        
    } else {
        $_SESSION['flash_message'] = 'Database update failed.';
        $_SESSION['flash_type'] = 'danger';
    }

    header("Location: detect.php");
    exit;
} else {
    echo "Invalid request method.";
}
