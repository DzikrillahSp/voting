<?php
include '../template/database.php';
require 'phpexcel/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

if(isset($_FILES['import']['name']) && in_array($_FILES['import']['type'], $file_mimes)) {
    var_dump($_FILES['import']['name']);
    $arr_file = explode('.', $_FILES['import']['name']);
    $extension = end($arr_file);

    if('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $reader->load($_FILES['import']['tmp_name']);

    $kelas = $_POST['kelas'];

    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    // $query = "INSERT INTO pemilih(id_pemilih, pemilih_nis, pemilih_nama, pemilih_kelas, pemilih_nowa, pemilih_email, pemilih_status, pemilih_kode) VALUES";
    for($i = 1;$i < count($sheetData);$i++){

        $nis = $sheetData[$i]['0'];
        $nama = $sheetData[$i]['1'];
        $nama_change = preg_replace('/[^A-Za-z0-9\  ]/', '', $nama);
        $nowa = $sheetData[$i]['2'];
        $email= $sheetData[$i]['3'];

        $status = 0;
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $kode = substr(str_shuffle($karakter), 0, 5);

        mysqli_query($koneksi, "INSERT INTO voter(id_voter, voter_nis, voter_name, voter_faculty, voter_phone_number, voter_email, voter_status, voter_code) VALUES (NULL,'$nis','$nama_change', '$kelas','$nowa', '$email', '$status', '$kode')");
    }
    
}
?>