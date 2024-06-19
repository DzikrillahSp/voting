<?php
include '../template/database.php';

$nameFaculty = mysqli_real_escape_string($koneksi,$_POST['name']);
$inShort = mysqli_real_escape_string($koneksi,$_POST['singkat']);

$query = mysqli_query($koneksi,"INSERT INTO faculties (faculty_name, faculty_short) VALUES('$nameFaculty', '$inShort') ");
if ($query) {
   echo "success";
}

?>

