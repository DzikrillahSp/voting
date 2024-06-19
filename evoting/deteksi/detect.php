<?php
session_start();
// if (isset($_SESSION['verification']) && $_SESSION['verification'] == 1) {
//     // Redirect to detect.php if verification is successful
//     header("Location: detect.php");
//     exit; // Make sure to exit after redirecting
// } 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $names = escapeshellarg($_SESSION['id_voter']);
    $pythonScript = escapeshellarg('scan.py'); // Update this path
    
    // Use exec to run the Python script
    $output = shell_exec("python $pythonScript $names 2>&1");
    
    // Check the output for error messages
    if (strpos($output, 'get detect') !== false) {
        // $_SESSION['flash_message'] = 'Face not recognized for 20 seconds. Please try again.';
        // $_SESSION['flash_type'] = 'danger';
        header("Location: ../pemilih/bilik.php");
        exit;
    }
    if (strpos($output, 'undetect') !== false) {
        // $_SESSION['flash_message'] = 'Face not recognized for 20 seconds. Please try again.';
        // $_SESSION['flash_type'] = 'danger';
        header("Location: ../otp_detection.php");
        exit;
    }
    // echo "<pre>$trainingOutput</pre>";
    // Session_destroy();
    header("Location: detect.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Face</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            text-align: center;
        }

        button {
            padding: 15px 30px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php if (isset($_SESSION['flash_message'])) : ?>
            <div class="alert alert-<?= $_SESSION['flash_type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash_message'] ?>
            </div>
            <?php
            // Unset flash message after displaying
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>
        <form action="detect.php" method="post">
            <button type="submit">Face Verification</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>