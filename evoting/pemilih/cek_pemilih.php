<?php 
include '../database.php';

$getsetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getsetting);

$nis = mysqli_real_escape_string($koneksi,$_POST['nis']);

$get_pemilih = mysqli_query($koneksi,"SELECT voter.*, faculties.*, COUNT(voter.id_voter) AS jumlah 
FROM voter
JOIN faculties ON voter.voter_faculty = faculties.faculty_id
WHERE voter.voter_nis = '$nis'
GROUP BY voter.id_voter
LIMIT 1;
");
$pemilih = mysqli_fetch_array($get_pemilih);

// var_dump($pemilih);
// header("Content-type: application/json; charset=utf-8");
if ($pemilih == null) {
	$data = array(
		'status_data' => 'tidak_ada'
	);
	header("Content-type: application/json; charset=utf-8");
	echo json_encode($data);
}else{

	if ($pemilih['voter_status'] == 0) {
		$status = "Have not chosen yet";
	}elseif ($pemilih['voter_status'] == 1) {
		$status = "Already Chosen";
	}

	if ($setting['setting_type'] == "presma") { 
		$jenis = "Matrix"; 
	}elseif ($setting['pengaturan_jenis'] == "presma") { 
		$jenis = "Matrix";
	}
	$data = array(
		'status_data' => 'ada',
		'nis' => $nis,
		'nama' => $pemilih['voter_name'],
		'kelas' => $pemilih['faculty_name'],
		'jenis' => $jenis,
		'status' => $status
	);
	header("Content-type: application/json; charset=utf-8");
	echo json_encode($data);
}

?>