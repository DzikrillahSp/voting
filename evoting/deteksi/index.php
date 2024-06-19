<?php
session_start();

// Check if $_SESSION['verification'] is set and equals 1
if (isset($_SESSION['verification']) && $_SESSION['verification'] == 1) {
    // Redirect to detect.php if verification is successful
    header("Location: detect.php");
    exit; // Make sure to exit after redirecting
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Face</title>
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

        .card {
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Styling for the caution message */
        .caution {
            font-size: 14px;
            color: #ff0000;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="card">
        <form action="run_python.php" method="post">
            <!-- Input field for name -->
            <input type="text" id="nama" name="nama" value="<?php echo isset($_SESSION['id_voter']) ? $_SESSION['id_voter'] : ''; ?>" hidden required>
            
            <!-- Caution message -->
            <div class="caution" style="margin-bottom: 20px;">Please make sure you are ready before pressing the "Register Face" button.</div>
            
            <!-- Button to trigger the form submission -->
            <button type="submit">Register Face</button>
        </form>
    </div>
</body>

</html>
