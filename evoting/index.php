<?php 
$judul = "E-Election";
include'template/header.php';

$getpemilih = mysqli_query($koneksi,"SELECT * FROM voter_votes, voter, faculties WHERE voter_votes.vote_voter_id=voter.id_voter AND voter.voter_faculty=faculties.faculty_id ORDER BY voter_votes.id_vote DESC LIMIT 5");

$getkandidat = mysqli_query($koneksi,"SELECT * FROM candidates");
?>
<link href="assets_back/alert/sweetalert2.min.css" rel="stylesheet">
<!-- ======= Hero Section ======= -->
<section id="hero">

  <div class="container">
    <div class="row">
      <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
        <div>
          <h1>WELCOME </h1>
          <h2>Election Website  <?php if ($setting['setting_type'] == "osis") { echo "Election of Head of Organization"; }elseif($setting['setting_type'] == "presma"){ echo "Election of Student President"; } ?>
          <?php echo htmlspecialchars($setting['setting_school_name']); ?> <br> Please log in to select candidates</h2>
          <a href="auth_pemilih.php" class="btn-get-started scrollto">Login to vote</a>
        </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
        <img src="assets_front/svg/voting.svg" class="img-fluid" alt="">
      </div>
    </div>
  </div>

</section><!-- End Hero -->

<main id="main">

  <!-- ======= Features Section ======= -->
  <section id="features" class="features">
    <div class="container">

      <div class="row">
        <div class="col-lg-6 mt-2 mb-tg-0 order-2 order-lg-1">
          <ul class="nav nav-tabs flex-column">
            <li class="nav-item" data-aos="fade-up">
              <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">
                <h4>Enter the Election website Chairman of the organization</h4>
              </a>
            </li>
            <li class="nav-item mt-2" data-aos="fade-up" data-aos-delay="100">
              <a class="nav-link" data-bs-toggle="tab" href="#tab-2">
                <h4>Sign in using Matrix</h4>
              </a>
            </li>
            <li class="nav-item mt-2" data-aos="fade-up" data-aos-delay="200">
              <a class="nav-link" data-bs-toggle="tab" href="#tab-3">
                <h4>View the list of candidates along with their vision &amp; Mision</h4>
              </a>
            </li>
            <li class="nav-item mt-2" data-aos="fade-up" data-aos-delay="300">
              <a class="nav-link" data-bs-toggle="tab" href="#tab-4">
                <h4>Select the candidate according to your choice</h4>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in">
          <div class="tab-content">
            <div class="tab-pane active show" id="tab-1">
              <figure>
                <img src="assets_front/svg/masuk.svg" alt="" class="img-fluid">
              </figure>
            </div>
            <div class="tab-pane" id="tab-2">
              <figure>
                <img src="assets_front/svg/login.svg" alt="" class="img-fluid">
              </figure>
            </div>
            <div class="tab-pane" id="tab-3">
              <figure>
                <img src="assets_front/svg/kandidat.svg" alt="" class="img-fluid">
              </figure>
            </div>
            <div class="tab-pane" id="tab-4">
              <figure>
                <img src="assets_front/svg/pilih.svg" alt="" class="img-fluid">
              </figure>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End Features Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact section-bg">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Check E-Voting Voter Status</h2>
      </div>

      <div class="row">

        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-left">
          <form role="form" id="form_insert" method="post" class="php-email-form">

            <div class="form-group mt-3 mb-2">
              <input type="number" class="form-control" name="nis" id="nis"  placeholder="Enter your Matrix ">
            </div>
            <div class="text-center"><button type="submit">Check</button></div>
          </form>
        </div>
      </div>

    </div>
  </section><!-- End Contact Section -->

  <!-- ======= Testimonials Section ======= -->
  <section id="testimonials" class="testimonials">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>List of Just Voted</h2>
      </div>

      <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
        <?php 
        $cek_pemilih = mysqli_num_rows($getpemilih);

        if ($cek_pemilih > 0) { ?>
          <div class="swiper-wrapper">

            <?php
            while ($pemilih = mysqli_fetch_array($getpemilih)) { ?>
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    <?php echo htmlspecialchars($pemilih['voter_name']); ?> from faculty <?php echo htmlspecialchars($pemilih['faculty_short']); ?> already vote on the date <?php echo date('d/m/Y h:i:s', strtotime($pemilih['vote_time'])); ?>
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                  <img src="assets_back/img/boy.png" class="testimonial-img" alt="">
                  <h3><?php echo htmlspecialchars($pemilih['voter_name']); ?></h3>
                  <h4><?php echo htmlspecialchars($pemilih['faculty_short']); ?></h4>
                </div>
              </div><!-- End testimonial item -->
            <?php } ?>
          </div>
          <div class="swiper-pagination"></div>
        <?php }else{ ?>
          <center><h4 class="text-danger">No One Has Voted Yet</h4></center>
        <?php } ?>
      </div>

    </div>
  </section><!-- End Testimonials Section -->

  <!-- ======= Team Section ======= -->
  <section id="team" class="team">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>List of Candidates</h2>
      </div>

      <div class="row">
        <?php 
        $no = 1;
        $count = mysqli_num_rows($getkandidat);
        if ($count > 0) {
          while ($kandidat = mysqli_fetch_array($getkandidat)) { ?>
            <div class="col-lg-4 col-md-6">
              <div class="member" data-aos="zoom-in">
                <div class="pic"><img src="assets_back/foto_kandidat/<?php echo htmlspecialchars($kandidat['candidate_photo']) ?>" class="img-fluid" alt=""></div>
                <div class="member-info">
                  <h4><?php echo htmlspecialchars($kandidat['candidate_name']); ?></h4>
                  <a href="kandidat_detail.php?id=<?php echo htmlspecialchars($kandidat['candidate_id']); ?>" class="btn btn-sm btn-primary text-white"><i class='bx bx-show' ></i> Detail</a>
                </div>
              </div>
            </div>
          <?php }}else{ ?>
           <center data-aos="zoom-in"><h4 class="text-danger">No Candidates Yet</h4></center>
         <?php } ?>
       </div>

     </div>
   </section><!-- End Team Section -->

   <!-- ======= Cta Section ======= -->
   <section id="cta" class="cta">
    <div class="container">

      <div class="row" data-aos="zoom-in">
        <div class="col-lg-9 text-center text-lg-start">
          <h3>Already want to vote?</h3>
          <p> Choose candidates that suit your wishes</p>
        </div>
        <div class="col-lg-3 cta-btn-container text-center">
          <a class="cta-btn align-middle" href="auth_pemilih.php">Login to vote</a>
        </div>
      </div>

    </div>
  </section><!-- End Cta Section -->

  <!-- ======= F.A.Q Section ======= -->
  <section id="faq" class="faq">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
      </div>

      <ul class="faq-list" data-aos="zoom-in">

        <li>
          <div data-bs-toggle="collapse" class="collapsed question" href="#faq1"> How to create an account? <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
          <div id="faq1" class="collapse" data-bs-parent=".faq-list">
            <p>
            The account for logging in will be created by the admin using matrix you when the account has been created.
           </p>
         </div>
       </li>

       <li>
        <div data-bs-toggle="collapse" href="#faq2" class="collapsed question">Can I vote twice? <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
        <div id="faq2" class="collapse" data-bs-parent=".faq-list">
          <p>
          Of course not because one account only has one option to avoid cheating.
         </p>
       </div>
     </li>

     <li>
      <div data-bs-toggle="collapse" href="#faq3" class="collapsed question">I haven't selected yet but can't log in? <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
      <div id="faq3" class="collapse" data-bs-parent=".faq-list">
        <p>
        Please contact the admin on the number below so that your account is restored
        </p>
      </div>
    </li>

  </ul>

</div>
</section><!-- End Frequently Asked Questions Section -->

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
            <div  class="col-md-6">
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
  $(document).on('submit', '#form_insert', function(event){
    event.preventDefault();
    var nis = $('#nis').val();

    if(nis != ''){
      $.ajax({
        url:"pemilih/cek_pemilih.php",
        method:'POST',
        data:{
          nis:nis
        },
        beforeSend:function(){
          Swal.fire({
            title: 'Wait a moment',
            html: 'Currently looking for data...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
              Swal.showLoading()
            },
          });
        },
        success:function(response){
          if (response.status_data == "tidak_ada") {

           Swal.fire({
            icon: 'info',
            title: 'Opss!',
            text: 'You are not registered yet, please contact admin'
          });

         }else if(response.status_data == "ada"){

          Swal.fire({
            icon: 'success',
            title: 'Data Found!',
            html: `<b>Summary of Your Account Data:</b> <br> <b>${response.jenis}:</b> ${response.nis} <br> <b>Name:</b> ${response.nama} <br> <b>Faculty:</b> ${response.kelas} <br> <b>Status:</b> ${response.status}`,
            footer: 'Please contact Admin if it is not suitable'
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

      error:function(response){

        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'Server error!'
        });

        console.log(response);

      }

    });
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Oops..!',
        text: 'All fields must be filled in!'
      });
    }
  });
</script>