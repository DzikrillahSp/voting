<?php
session_start();
$judul = "Voting";
include '../database.php';

if ($_SESSION['auth'] != "auth") {

  session_destroy();
  header("location:../auth_pemilih.php?pesan=belum");
} else {

  $getsetting = mysqli_query($koneksi, "SELECT * FROM settings WHERE id_setting=1");
  $setting = mysqli_fetch_array($getsetting);

  $getkandidat = mysqli_query($koneksi, "SELECT * FROM candidates");

  $id_pemilih = $_SESSION['id_voter'];
  $getpemilih = mysqli_query($koneksi, "SELECT * FROM voter WHERE id_voter='$id_pemilih' AND voter_status='0'");
  $cekpemilih = mysqli_num_rows($getpemilih);

  if ($cekpemilih > 0) {

    $ceksuara = mysqli_query($koneksi, "SELECT * FROM voter_votes WHERE vote_voter_id='$id_pemilih'");
    $suaracek = mysqli_num_rows($ceksuara);
    if ($suaracek == 0) {

      $pemilih = mysqli_fetch_array($getpemilih);
    } else {
      session_destroy();
      header("location:../auth_pemilih.php?pesan=sudah");
    }
  } else {
    session_destroy();
    header("location:../auth_pemilih.php?pesan=sudah");
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
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <h1><a href="../index.php">E-Election</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto" href="../index.php">Home</a></li>
          <li><a class="nav-link scrollto " href="#">Hai, <?php echo htmlspecialchars($pemilih['voter_name']); ?></a></li>
          <li><a class="nav-link scrollto" href="logout.php">Logout</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li><?php echo $judul; ?></li>
        </ol>
        <h2><?php echo $judul; ?></h2>

      </div>
    </section><!-- End Breadcrumbs -->
    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h3>Immediately vote for your best candidate.</h3>
        </div>

        <div class="row">
          <?php
          $cek = mysqli_num_rows($getkandidat);
          if ($cek > 0) {
            while ($kandidat = mysqli_fetch_array($getkandidat)) {
          ?>
              <div class="col-lg-4 col-md-6">
                <div class="member" data-aos="zoom-in">
                  <div class="pic"><img src="../assets_back/foto_kandidat/<?php echo htmlspecialchars($kandidat['candidate_photo']) ?>" class="img-fluid" alt=""></div>
                  <div class="member-info">

                    <?php
                    $id = $kandidat['candidate_id'];
                    $getsuara = mysqli_query($koneksi, "SELECT count(voter_votes.vote_candidate_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='$id'");
                    $suara = mysqli_fetch_array($getsuara);
                    ?>
                    <h4><?php echo htmlspecialchars($kandidat['candidate_name']); ?></h4>
                    <button type="button" class="btn btn-sm btn-warning text-white  view_data" id="<?php echo htmlspecialchars($kandidat['candidate_id']); ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" id="#button_insert"> <i class='bx bx-show-alt'></i> Detail</button>

                    <?php $nomor = htmlspecialchars($kandidat['candidate_id']); ?>
                    <button type="button" class='btn btn-sm btn-primary hapus' data-id="<?php echo $nomor; ?>"><i class='bx bx-check'></i> Vote</button>
                  </div>
                </div>
              </div>
            <?php }
          } else { ?>
            <center>
              <h4 class="text-danger">No Candidates Yet</h4>
            </center>
          <?php } ?>

        </div>

      </div>
    </section><!-- End Team Section -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Candidate Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="tampil"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Closed</button>
          </div>
        </div>
      </div>
    </div>

  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container">
      <div class="copyright">
        <!-- &copy; Copyright <strong><span></span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by 
    </div> -->
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="../assets_back/alert/sweetalert2.min.js"></script>
  <script type="text/javascript">
    $('.view_data').click(function() {
      var id = $(this).attr("id");
      // memulai ajax
      $.ajax({
        url: 'modal_detail.php',
        method: 'post',
        data: {
          id: id
        },
        success: function(data) {
          $('#tampil').html(data);
          $('#modal_update').modal("show");
        }
      });
    });

    $(document).on('click', '.hapus', function() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Voting can only be done once and use your voice as best as possible",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, sure!'
      }).then((result) => {
        if (result.value) {
          var id = $(this).attr('data-id');
          $.ajax({
            method: "POST",
            url: "proses_pemilih.php",
            data: {
              id: id
            },
            success: function(response) {

              if (response == "success") {

                Swal.fire({
                    icon: 'success',
                    title: 'Succed!',
                    text: 'Your vote has been recorded'
                  })
                  .then(function() {
                    window.location.href = "bilik_selesai.php";
                  });

              } else {

                Swal.fire({
                  icon: 'error',
                  title: 'Sorry!',
                  text: 'Your vote failed to be recorded'
                });

              }
              console.log(response);
            }
          });
        }
      })
    });
  </script>

</body>

</html>