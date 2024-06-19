<?php 
session_start();
$judul = "Voting Complete";
include '../database.php';

if ($_SESSION['auth'] != "auth") {

  session_destroy();
  header("location:../auth_pemilih.php?pesan=belum");

}else{

 $getsetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
 $setting = mysqli_fetch_array($getsetting);

 $getkandidat = mysqli_query($koneksi,"SELECT * FROM candidates");

 $id_voter = $_SESSION['id_voter'];
 $getpemilih = mysqli_query($koneksi,"SELECT * FROM voter WHERE id_voter='$id_voter'");
 $cekpemilih = mysqli_num_rows($getpemilih);

 if ($cekpemilih > 0) {
    $pemilih = mysqli_fetch_array($getpemilih);
  }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $judul; ?> - E-Voting Website <?php echo htmlspecialchars($setting['setting_school_name']); ?></title>

  <meta content="<?php echo htmlspecialchars($setting['setting_description']); ?>" name="description">
  <meta content="<?php echo htmlspecialchars($setting['setting_keyword']); ?>" name="keywords">


  <link href='assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>' rel='image_src' />
  <meta content='general' name='rating' />
  <meta content='id' name='geo.country' />
  <!-- [ Social Media Meta Tag ] -->
  <meta content='Website E-Voting <?php echo htmlspecialchars($setting['setting_school_name']); ?>' property='og:title' />
  <meta content='../assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>' property='og:url' />
  <meta content='article' property='og:type' />
  <meta content='E-Voting' property='og:site_name' />
  <meta content='<?php echo htmlspecialchars($setting['setting_description']); ?>' property='og:description' />
  <meta content='../assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>' property='og:image' />

  <meta content="<?php echo htmlspecialchars($setting['setting_description']); ?>" name="description">
  <meta content="<?php echo htmlspecialchars($setting['setting_keyword']); ?>" name="keywords">

  <!-- Favicons -->
  <link href="../assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" rel="icon">
  <link href="../assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="../assets_front/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets_front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets_front/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets_front/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets_front/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets_front/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets_front/css/style.css" rel="stylesheet">
  
  <link href="../assets_back/alert/sweetalert2.min.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center mb-5">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <h1><a href="../index.php">E-Election</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto" href="../index.php">Home</a></li>
          <li><a class="nav-link scrollto " href="#"><?php echo htmlspecialchars($pemilih['voter_name']); ?></a></li>
          <li><a class="nav-link scrollto" href="logout.php">Logout</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
  <main id="main" class="mt-5 mb-5">

<!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container mt-5">

        <div class="row">
          <div class="col-md-6">
            <img src="../assets_front/svg/selesai.svg" class="img-fluid" alt="">
          </div>
          <div class="col-md-6 d-flex flex-column justify-contents-center">
            <div class="content pt-4 pt-lg-0 text-center">
              <h3 class="text-center">Thank You</h3>
              <p class="fst-italic ">
              Thank you for your participation in casting your vote.
              </p>
              <a href="logout.php" class="btn btn-danger" style="border-radius: 50px;">Logout</a>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

</main><!-- End #main -->
<!-- ======= Footer ======= -->
<footer id="footer" class="mt-5">

  <div class="container">
    <div class="copyright">
      &copy; Copyright <strong><span></span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by 
    </div>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="../assets_front/vendor/aos/aos.js"></script>
<script src="../assets_front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets_front/vendor/glightbox/js/glightbox.min.js"></script>
<script src="../assets_front/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="../assets_front/vendor/php-email-form/validate.js"></script>
<script src="../assets_front/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="../assets_front/js/main.js"></script>

</body>

</html>