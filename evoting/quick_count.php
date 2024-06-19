<?php 
$judul = "Quick Count";
include 'template/header.php';

$getkandidat = mysqli_query($koneksi,"SELECT * FROM candidates");
?>
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
        <h2>Number of Votes for Each Candidate</h2>
      </div>

      <div class="row">
        <?php 
        $cek = mysqli_num_rows($getkandidat);
        if ($cek > 0) {
          while ($kandidat = mysqli_fetch_array($getkandidat)) {
            ?>
            <div class="col-lg-4 col-md-6">
              <div class="member" data-aos="zoom-in">
                <div class="pic"><img src="assets_back/foto_kandidat/<?php echo htmlspecialchars($kandidat['candidate_photo']) ?>" class="img-fluid" alt=""></div>
                <div class="member-info">

                  <?php 
                  $id = $kandidat['candidate_id'];
                  $getsuara = mysqli_query($koneksi,"SELECT count(voter_votes.vote_candidate_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='$id'");
                  $suara = mysqli_fetch_array($getsuara);
                  ?>
                  <h4><?php echo htmlspecialchars($kandidat['candidate_name']); ?></h4>
                  <a href="#" class="btn btn-sm btn-primary text-white"><strong><?php echo $suara['jumlah_suara']; ?></strong> Votes</a>
                </div>
              </div>
            </div>
          <?php }}else{ ?>
            <div class="col-lg-12 mb-5">
              <center class="mb-5" data-aos="zoom-in"><h4 class="text-danger">No Candidates Yet</h4></center>
            </div>
          <?php } ?>

        </div>

      </div>
    </section><!-- End Team Section -->

    <?php if ($cek != "") {?>
      <!-- ======= Contact Section ======= -->
      <section id="contact" class="contact section-bg">
        <div class="container">

          <div class="section-title" data-aos="fade-up">
            <h2>Number of Votes Graph</h2>
          </div>

          <div class="row">

            <div class="col-lg-12 d-flex align-items-stretch" data-aos="fade-right">
              <div class="info">

                <div class="chart-bar">
                  <canvas id="myChart"></canvas>
                </div>

              </div>
            </div>
          </div>

        </div>
      </section><!-- End Contact Section -->
    <?php } ?>
  </main><!-- End #main -->
  <?php 
  include 'template/footer.php'; 
  ?>
  <?php if ($cek != "") { ?>
    <script src="assets_front/package/dist/chart.js"></script>
    <?php 

    $get_kandidat = mysqli_query($koneksi,"SELECT * FROM candidates");
    while($kandidat = mysqli_fetch_array($get_kandidat)){
      $kandidat_data[] = $kandidat['candidate_name'];

      $query = mysqli_query($koneksi,"SELECT count(vote_candidate_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='".$kandidat['candidate_id']."'");
      $row = $query->fetch_array();
      $suara_data[] = $row['jumlah_suara'];
    }
    ?>
    <script>
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($kandidat_data); ?>,
          datasets: [{
            label: '# Suara',
            data: <?php echo json_encode($suara_data); ?>,
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
    <?php } ?>