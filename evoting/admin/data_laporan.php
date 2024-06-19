<?php
$judul = "Report";
include 'template/header.php';

?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $judul; ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><?php echo $judul; ?></li>
    </ol>
  </div>

  <?php

  $getFaculty = mysqli_query($koneksi, "SELECT * FROM faculties");
  $faculty_rows = mysqli_num_rows($getFaculty);

  $getVoter = mysqli_query($koneksi, "SELECT * FROM voter");
  $data_rows = mysqli_num_rows($getVoter);
  ?>

  <?php if ($faculty_rows != "" && $data_rows != "") { ?>
    <div class="row">
      <div class="col-xl-12 col-lg-7 mb-4">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Export Student Data by Faculty</h6>
          </div>
          <div class="card-body">
            <form method="get" action="proses_data/ekspor_kelas.php">

              <div class="form-group">
                <label><b>Faculty</b></label>
                <select name="kelas" class="form-control" required>
                  <?php while ($facultyData = mysqli_fetch_array($getFaculty)) { ?>
                    <option value="<?php echo $facultyData['faculty_id'] ?>"><?php echo $facultyData['faculty_name']; ?></option>
                  <?php } ?>
                </select>
              </div>

          </div>
          <div class="card-footer">
            <button class="btn btn-primary" type="submit">Export</button>
          </div>
          </form>
        </div>
      </div>
    <?php } ?>


    <div class="col-xl-12 col-lg-7 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Form <?php echo $judul; ?></h6>
        </div>
        <div class="card-body">
          <form method="get" action="">
            <div class="form-group">
              <label><b>Based report</b></label>
              <select name="dasar" class="form-control" required>
                <option value="pemilih">All voter data</option>
                <option value="hasil">Recapitulation of voting results</option>
              </select>
            </div>

            <div class="form-group">
              <label><b>File format</b></label>
              <select name="file" class="form-control" required>
                <option value="pdf">PDF</option>
                <option value="excel">EXCEL</option>
              </select>
            </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary" type="submit">Search</button>
        </div>
        </form>
      </div>
    </div>

    <?php if (isset($_GET['dasar']) && isset($_GET['file'])) { ?>

      <!-- PEMILIH -->
      <?php if ($_GET['dasar'] == "pemilih") {
        $getpemilih = mysqli_query($koneksi, "SELECT * FROM voter, faculties WHERE voter.voter_faculty=faculties.faculty_id");
      ?>

        <div class="col-xl-12 col-lg-7 mb-4">
          <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">All Data <?php echo $judul; ?></h6>

              <?php if ($_GET['file'] == "pdf") { ?>
                <a href="proses_data/ekspor_pemilih.php?file=pdf" target="_blank" class="m-0 float-right btn btn-sm btn-primary"> <i class="fas fa-print"></i> EXPORT PDF</a>
              <?php } elseif ($_GET['file'] == "excel") { ?>
                <a href="proses_data/ekspor_pemilih.php?file=excel" class="m-0 float-right btn btn-sm btn-info"> <i class="fas fa-print"></i> EXPORT EXCEL</a>
              <?php } ?>
            </div>
            <div class="card-body">
              <div class="table-responsive  p-3">
                <table class="table align-items-center table-flush" id="dataTable">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Matrix</th>
                      <th>Full Name</th>
                      <th>Faculty</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    while ($pemilih = mysqli_fetch_array($getpemilih)) { ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($pemilih['voter_nis']); ?></td>
                        <td><?php echo htmlspecialchars($pemilih['voter_name']); ?></td>
                        <td><?php echo htmlspecialchars($pemilih['faculty_name']); ?></td>
                        <td>
                          <?php
                          if ($pemilih['voter_status'] == 0) {
                            echo '<span class="badge badge-danger">Have not chosen yet</span>';
                          } elseif ($pemilih['voter_status'] == 1) {
                            echo '<span class="badge badge-success">Already Chosen</span>';
                          }
                          ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer"></div>
          </div>
        </div>


        <!-- END PEMILIH -->
      <?php } elseif ($_GET['dasar'] == "hasil") {

        $getCandidatesArr = mysqli_query($koneksi, "SELECT * FROM candidates");

        $getVoterArr = mysqli_query($koneksi, "SELECT count(id_voter) AS jumlah_pemilih FROM voter");
        $pemilih = mysqli_fetch_array($getVoterArr);

        $getsudah = mysqli_query($koneksi, "SELECT count(voter_status) AS jumlah_sudah FROM voter WHERE voter_status='1'");
        $sudah = mysqli_fetch_array($getsudah);

        $getbelum = mysqli_query($koneksi, "SELECT count(voter_status) AS jumlah_belum FROM voter WHERE voter_status='0'");
        $belum = mysqli_fetch_array($getbelum);

        $getpemilih = mysqli_query($koneksi, "SELECT * FROM voter");
        $pemilih_rows = mysqli_num_rows($getpemilih);
      ?>
        <!-- REKAP EVOTING -->

        <div class="col-xl-12 col-lg-7 mb-4">
          <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">All Data <?php echo $judul; ?></h6>

              <?php if ($_GET['file'] == "pdf") { ?>
                <a href="proses_data/ekspor_hasil.php?file=pdf" target="_blank" class="m-0 float-right btn btn-sm btn-info"> <i class="fas fa-print"></i> EKSPOR PDF</a>
              <?php } elseif ($_GET['file'] == "excel") { ?>
                <a href="proses_data/ekspor_hasil.php?file=excel" class="m-0 float-right btn btn-sm btn-info"> <i class="fas fa-print"></i> EKSPOR EXCEL</a>
              <?php } ?>
            </div>
            <div class="card-body">
              <h3 class="font-weight-bold text-center uppercase">Recapitulation Results of the Election of the Head of the Organization</h3>
              <h4 class="font-weight-bold text-center uppercase"><?php echo htmlspecialchars($setting['setting_school_name']); ?></h4>
              <div class="table-responsive  p-3">
                <table class="table align-items-center table-flush table-bordered">
                  <thead class="thead-light">
                    <tr>
                      <th>Candidate Name</th>
                      <th width="20%">Number of Votes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $kandidat_rows = mysqli_num_rows($getCandidatesArr);
                    if ($kandidat_rows != "") {
                      while ($kandidat = mysqli_fetch_array($getCandidatesArr)) {

                        $candidateID = $kandidat['candidate_id'];

                        $getsuara = mysqli_query($koneksi, "SELECT count(vote_candidate_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='$candidateID'");
                        $suara = mysqli_fetch_array($getsuara);
                    ?>
                        <tr>
                          <td><?php echo htmlspecialchars($kandidat['candidate_name']); ?></td>
                          <td>
                            <?php echo htmlspecialchars($suara['jumlah_suara']); ?>
                          </td>
                        </tr>
                    <?php }
                    } ?>
                    <tr>
                      <td></td>
                      <td></td>
                    </tr>
                    <?php if ($pemilih_rows != "") { ?>
                      <tr>
                        <td><b> Total Number of Voters</b></td>
                        <td>
                          <?php echo $pemilih['jumlah_pemilih']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b> Number of Valid Votes</b></td>
                        <td>
                          <?php
                          $persentasi = round($sudah['jumlah_sudah'] / $pemilih['jumlah_pemilih'] * 100, 2);
                          echo $persentasi;
                          ?>% <?php echo "(" . $sudah['jumlah_sudah'] . " Suara)" ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b> Number of Unused Votes</b></td>
                        <td>
                          <?php
                          $persentasi = round($belum['jumlah_belum'] / $pemilih['jumlah_pemilih'] * 100, 2);
                          echo $persentasi;
                          ?>% <?php echo "(" . $belum['jumlah_belum'] . " Suara)" ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <p></p>

            </div>
            <div class="card-footer"></div>
          </div>
        </div>

        <!-- AND REKAP EVOTING -->
      <?php } ?>
    <?php } ?>
    </div>
    <!---Container Fluid-->
    <?php
    include 'template/footer.php';
    ?>