<?php 
$judul = "Candidate Detail";
include 'template/header.php';

if($_GET['id'] != "") {

	$id = mysqli_real_escape_string($koneksi,$_GET['id']);
	
	$getkandidat = mysqli_query($koneksi,"SELECT * FROM candidates WHERE candidate_id='$id'");

	$cek = mysqli_num_rows($getkandidat);

	if ($cek > 0) {
		$kandidat = mysqli_fetch_array($getkandidat);

		$getsuara = mysqli_query($koneksi,"SELECT count(voter_votes.vote_voter_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='$id'");
		$suara = mysqli_fetch_array($getsuara);
	}else{
		header("location:index.php");
	}

}else{
	header("location:index.php");
}
?>
<main id="main">

	<!-- ======= Breadcrumbs ======= -->
	<section id="breadcrumbs" class="breadcrumbs">
		<div class="container">

			<ol>
				<li><a href="index.php">Home</a></li>
				<li><?php echo $judul; ?></li>
			</ol>
			<h2><?php echo $judul; ?> <?php echo htmlspecialchars($kandidat['candidate_name']); ?></h2>

		</div>
	</section><!-- End Breadcrumbs -->

	<!-- ======= Portfolio Details Section ======= -->
	<section id="portfolio-details" class="portfolio-details">
		<div class="container">

			<div class="row gy-4">

				<div class="col-lg-8">
					<div class="portfolio-details-slider swiper-container">
						<div class="swiper-wrapper align-items-center">

							<div class="swiper-slide">
								<img src="assets_back/foto_kandidat/<?php echo htmlspecialchars($kandidat['candidate_photo']) ?>" alt="">
							</div>

						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="portfolio-info">
						<h3>Candidate Information</h3>
						<ul>
							<li><strong>Name</strong>: <?php echo htmlspecialchars($kandidat['candidate_name']); ?></li>
							<li><strong>Number of Votes</strong>: <?php echo $suara['jumlah_suara']; ?> Votes</li>
						</ul>
					</div>
					<?php if ($kandidat['candidate_video'] != "") { ?>
					<div class="portfolio-info">
						<h3>Campaign Video</h3>
						
						<style type="text/css">
							.responsive-embed-youtube {
								position:relative;
								padding-bottom:56.25%;
								padding-top:30px;
								height:0;
								overflow:hidden;
							}
							.responsive-embed-youtube iframe, .responsive-embed-youtube object, .responsive-embed-youtube embed {
								position:absolute;
								top:0;
								left:0;
								width:100%;
								height:100%;
								right:10px;
							}
						</style>

						<div class="responsive-embed-youtube">
							<?php echo $kandidat['candidate_video']; ?>
						</div>
					</div>
				<?php } ?>
					<div class="portfolio-description">
						<?php echo $kandidat['candidate_description']; ?>
					</div>
				</div>

			</div>

		</div>
	</section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
<?php 
include 'template/footer.php'; 
?>