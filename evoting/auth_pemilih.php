<?php
$judul = "Voter Login";
include 'template/header.php';
session_start();
?>
<link href="assets_back/alert/sweetalert2.min.css" rel="stylesheet">
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

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact section-bg">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Voter Login Form</h2>
      </div>
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
      <div class="row">

        <?php if ($setting['setting_schedule'] == "open") { ?>

          <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-left">
            <form role="form" id="form_insert" method="post" class="php-email-form">

              <div class="form-group mt-3">
                <input type="number" class="form-control" name="nis" id="nis" placeholder="Enter your Matrix ">
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="kode" id="kode" placeholder="Access Code">
              </div>
              <br>
              <div class="text-center"><button type="submit">Login</button></div>
            </form>
          </div>

        <?php } elseif ($setting['setting_schedule'] == "closed") { ?>
          <center data-aos="fade-left">
            <h4 class="text-danger">Voting is Closed</h4>
          </center>
        <?php } ?>

      </div>

    </div>
  </section><!-- End Contact Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact section-bg">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Contact Us</h2>
      </div>

      <div class="row">

        <div class="col-lg-12 d-flex align-items-stretch" data-aos="fade-right">
          <div class="info">
            <div class="row">
              <div class="col-md-6">
                <div class="email">
                  <i class="bi bi-envelope"></i>
                  <h4>Email</h4>
                  <p><?php echo htmlspecialchars($setting['setting_email']); ?></p>
                </div>
              </div>


              <div class="col-md-6">
                <div class="phone">
                  <i class="bi bi-phone"></i>
                  <h4>Whatsapp</h4>
                  <p><?php echo htmlspecialchars($setting['setting_phone_number']); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->
<?php
include 'template/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="assets_back/alert/sweetalert2.min.js"></script>
<script type="text/javascript">
  $(document).on('submit', '#form_insert', function(event) {
    event.preventDefault();
    var nis = $('#nis').val();
    var kode = $('#kode').val();

    if (nis != '' && kode != '') {
      $.ajax({
        url: "pemilih/login_pemilih.php",
        method: 'POST',
        data: $('#form_insert').serialize(),
        success: function(response) {
          if (response == "success") {

            Swal.fire({
                icon: 'success',
                title: 'Login Successful!',
                text: 'Wait a minute, please...',
                timer: 3000,
                showCancelButton: false,
                showConfirmButton: false
              })
              .then(function() {
                // jika sukses maka akan diarahkan kehalaman yang dituju
                // window.location.href = "deteksi/index.php";
                window.location.href = "otp_detection.php";
                // window.location.href = "pemilih/bilik.php";
              });

          } else if (response == "sudah") {

            Swal.fire({
              icon: 'error',
              title: 'Sorry!',
              text: 'You have already voted'
            });

          } else if (response == "tidak_ada_kandidat") {

            Swal.fire({
              icon: 'info',
              title: 'Sorry!',
              text: 'There are no candidates yet'
            });

          } else {

            Swal.fire({
              icon: 'error',
              title: 'Sorry!',
              text: 'Incorrect Matrix or Access Code'
            });

          }

          console.log(response);
        },

        error: function(response) {

          Swal.fire({
            icon: 'error',
            title: 'Oops..!',
            text: 'Server error!'
          });

          console.log(response);

        }

      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops..!',
        text: 'All fields must be filled in!'
      });
    }
  });
</script>

<?php if (isset($_GET['pesan'])) { ?>
  <?php if ($_GET['pesan'] == "belum") { ?>
    <script type="text/javascript">
      Swal.fire({
        icon: 'info',
        title: 'Oops!',
        text: 'You must log in first'
      });
    </script>
  <?php } elseif ($_GET['pesan'] == "sudah") { ?>
    <script type="text/javascript">
      Swal.fire({
        icon: 'info',
        title: 'Oops!',
        text: 'You have already voted!'
      });
    </script>
<?php }
} ?>