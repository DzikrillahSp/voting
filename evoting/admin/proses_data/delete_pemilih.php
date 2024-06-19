<?php
include '../template/database.php';
$id = $_POST['id'];
$getVote = mysqli_query($koneksi,"SELECT * FROM voter_votes WHERE vote_voter_id='$id'");
$vote = mysqli_num_rows($getVote);
if ($vote > 0) {
	
	$delete = mysqli_query($koneksi,"DELETE FROM voter WHERE id_voter='$id'");
	if($delete){
		mysqli_query($koneksi,"DELETE FROM voter_votes WHERE vote_voter_id='$id'");
		echo "success";
	}else{
		echo "failed";
	}

}else{

	$delete = mysqli_query($koneksi,"DELETE FROM voter WHERE id_voter='$id'");
	if($delete){
		echo "success";
	}else{
		echo "failed";
	}

}

?>
