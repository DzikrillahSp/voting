<?php
include '../template/database.php';
$id = $_POST['id'];
$delete = mysqli_query($koneksi,"DELETE FROM faculties WHERE faculty_id='$id'");
if($delete){
   mysqli_query($koneksi,"UPDATE voter SET voter_faculty='1' WHERE voter_faculty='$id'");
   echo "success";
}else{
   echo "failed";
}
?>
