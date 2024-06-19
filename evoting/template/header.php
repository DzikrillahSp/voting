<?php 
include 'database.php';

$getsetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getsetting);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $judul; ?> - E-Voting Website <?php echo htmlspecialchars($setting['setting_school_name']); ?></title>

  <meta content="<?php echo htmlspecialchars($setting['setting_description']); ?>" name="description">
  <meta content="<?php echo htmlspecialchars($setting['setting_keyword']); ?>" name="keywords">


  <link href='assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>' rel='image_src'/>
  <meta content='general' name='rating'/>
  <meta content='id' name='geo.country'/>
  <!-- [ Social Media Meta Tag ] -->
  <meta content='Website E-Voting <?php echo htmlspecialchars($setting['setting_school_name']); ?>' property='og:title'/>
  <meta content='assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>' property='og:url'/>
  <meta content='article' property='og:type'/>
  <meta content='E-Voting' property='og:site_name'/>
  <meta content='<?php echo htmlspecialchars($setting['setting_description']); ?>' property='og:description'/>
  <meta content='assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>' property='og:image'/>

  <meta content="<?php echo htmlspecialchars($setting['setting_description']); ?>" name="description">
  <meta content="<?php echo htmlspecialchars($setting['setting_keyword']); ?>" name="keywords">

  <!-- Favicons -->
  <link href="assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" rel="icon">
  <link href="assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets_front/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets_front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets_front/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets_front/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets_front/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets_front/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets_front/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <h1><a href="index.php">E-Election</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto " href="quick_count.php">Quick Count</a></li>
          <li><a class="nav-link scrollto" href="auth_pemilih.php">Voter Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->