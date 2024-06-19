<?php
include '../template/database.php';
$id = $_POST['id'];
$getDataOld = mysqli_query($koneksi, "SELECT candidate_photo FROM candidates WHERE candidate_id='$id'");
$dataOld = mysqli_fetch_array($getDataOld);
unlink("../../assets_back/foto_kandidat/" . $dataOld['candidate_photo']);

$delete = mysqli_query($koneksi, "DELETE FROM candidates WHERE candidate_id='$id'");
if ($delete) {
	$getCandidate = mysqli_query($koneksi, "SELECT * FROM voter_votes WHERE vote_voter_id='$id'");
	while ($candidate = mysqli_fetch_array($getCandidate)) {
		$idVoter = $candidate['vote_voter_id'];
		mysqli_query($koneksi, "UPDATE voter SET voter_status='0' WHERE id_voter='$idVoter'");
	}
	mysqli_query($koneksi, "DELETE FROM voter_votes WHERE vote_candidate_id='$id'");
	echo "success";
} else {
	echo "failed";
}
