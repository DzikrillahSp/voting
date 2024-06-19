<?php
include '../template/database.php';
$id = $_POST['id'];

$delete = mysqli_query($koneksi,"DELETE FROM voter_votes WHERE id_vote='$id'");
if($delete){
	echo "success";
}else{
	echo "failed";
}


?>
