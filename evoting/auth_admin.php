<?php
session_start();
require 'database.php';
if (isset($_POST['button'])) {

  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $pass = mysqli_real_escape_string($koneksi, $_POST['password']);
  // Mengubah password menjadi MD5
  $password       = md5($pass);

  $query    = "SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
  $result     = mysqli_query($koneksi, $query);
  $num_row    = mysqli_num_rows($result);

  if ($num_row > 0) {

    $row    = mysqli_fetch_array($result);

    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['login'] = "login";
    header("location:admin/dashboard.php");
  } else {
    $error = "gagal";
  }
}
$getsetting = mysqli_query($koneksi, "SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getsetting);
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" rel="icon">
  <title>Admin Login - Organization Chair Election Website</title>
  <link href="assets_back/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets_back/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets_back/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                  </div>
                  <?php
                  if (isset($error)) {
                    if ($error == "gagal") {
                      echo '<div class="alert alert-danger" role="alert">
+                     Invalid username or password, try again
                      </div>';
                      unset($error);
                    }
                  }
                  ?>
                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <input class="btn btn-primary btn-block" type="submit" name="button" value="Login">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="assets_back/vendor/jquery/jquery.min.js"></script>
  <script src="assets_back/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets_back/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets_back/js/ruang-admin.min.js"></script>
</body>

</html>