<!DOCTYPE html>
<html>

<head>
    <title>OTP Verification</title>
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS kustom jika diperlukan */
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin: 100px auto;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">OTP Verification</h5>
                <form id="otpForm" action="verifikasi_otp.php" method="POST">
                    <div class="form-group">
                        <label for="otp" class="form-label">Enter OTP:</label>
                        <input type="text" class="form-control" name="otp" id="otp" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Verification</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Load Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
