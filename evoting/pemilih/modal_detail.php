<?php  
include '../database.php';

$id = $_POST['id'];

$get_kandidat = mysqli_query($koneksi,"SELECT * FROM candidates WHERE candidate_id='$id'");
$kandidat = mysqli_fetch_array($get_kandidat);
?>
<img src="../assets_back/foto_kandidat/<?php echo htmlspecialchars($kandidat['candidate_photo']) ?>" class="img-fluid" alt="...">
<br>
<br>
<ul class="list-unstyled">
	<li><strong>Candidate Name:</strong> <?php echo htmlspecialchars($kandidat['candidate_name']); ?></li>

	<?php if ($kandidat['candidate_video'] != "") {?>
		<li><strong>Campaign Video:</strong> <br> 
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
		</li>
	<?php } ?>
	<li><strong>Information:</strong></li>
	<li><?php echo $kandidat['candidate_description']; ?></li>
</ul>

