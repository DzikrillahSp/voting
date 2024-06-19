<?php 
include '../template/database.php';
$facultyId = mysqli_real_escape_string($koneksi,$_POST['faculty_id']);
$nameFaculty = mysqli_real_escape_string($koneksi,$_POST['update_name']);
$inShort = mysqli_real_escape_string($koneksi,$_POST['update_singkat']);

$query = mysqli_query($koneksi,"UPDATE faculties SET faculty_name='$nameFaculty', faculty_short='$inShort' WHERE faculty_id='$facultyId'");
if ($query) {
	echo "success";
}else{
	echo "error";
}
?>