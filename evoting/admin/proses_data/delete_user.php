<?php
include '../template/database.php';
$id = $_POST['id'];
$delete = mysqli_query($koneksi,"DELETE FROM user WHERE id_user='$id'");
if($delete){
    echo "success";
}else{
   echo "failed";
}
?>
