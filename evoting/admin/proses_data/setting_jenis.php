<?php
include '../template/database.php';

$typeVoter = mysqli_real_escape_string($koneksi,$_POST['jenis']);

$query = mysqli_query($koneksi,"UPDATE settings SET setting_type='$typeVoter' WHERE id_setting=1");
if ($query) {
   echo "success";
}else{
    echo "error";
}

?>