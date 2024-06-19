<?php
$judul = "Dashboard";
include 'template/header.php';

$getVoter = mysqli_query($koneksi, "SELECT * FROM voter");
$voterData = mysqli_num_rows($getVoter);

$getValidVoted = mysqli_query($koneksi, "SELECT count(voter_status) AS count_valid FROM voter WHERE voter_status='1'");
$valid = mysqli_fetch_array($getValidVoted);

$getNotVoted = mysqli_query($koneksi, "SELECT count(voter_status) AS count_not_voted FROM voter WHERE voter_status='0'");
$notVoted = mysqli_fetch_array($getNotVoted);

$getCandidate = mysqli_query($koneksi, "SELECT * FROM candidates");
$candidate = mysqli_num_rows($getCandidate);

$getLast = mysqli_query($koneksi, "SELECT * FROM voter_votes, voter, faculties WHERE voter_votes.vote_voter_id=voter.id_voter AND voter.voter_faculty=faculties.faculty_id ORDER BY voter_votes.id_vote DESC LIMIT 5");
$last = mysqli_num_rows($getLast);
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

  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Number of Voters</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $voterData; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Number of candidates</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $candidate; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-graduate fa-2x text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- New User Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Those Who Have Voted</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $valid['count_valid']; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-check fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- New User Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Those Who Haven't Voted Yet</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $notVoted['count_not_voted']; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-clock fa-2x text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($candidate > 0 && $voterData > 0) { ?>
      <div class="col-xl-6">
        <div class="card mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Votes Obtained by Prospective Candidates</h6>
          </div>
          <div class="card-body">
            <?php

            while ($dta = mysqli_fetch_array($getCandidate)) {
              $candidateID = $dta['candidate_id'];
              $getVoted = mysqli_query($koneksi, "SELECT count(vote_voter_id) AS count_vote FROM voter_votes WHERE vote_candidate_id='$candidateID'");
              $voted = mysqli_fetch_array($getVoted);
            ?>
              <div class="mb-3">
                <div class="small text-gray-500"><?php echo htmlspecialchars($dta['candidate_name']); ?>
                  <div class="small float-right"><b><?php echo htmlspecialchars($voted['count_vote']); ?> from <?php echo $voterData; ?></b></div>
                </div>
                <div class="progress" style="height: 12px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: <?php
                                                                                        $persentasi = round($voted['count_vote'] / $voterData * 100, 2);
                                                                                        echo $persentasi;
                                                                                        ?>%" aria-valuenow="<?php echo htmlspecialchars($voted['count_vote']); ?>" aria-valuemin="0" aria-valuemax="<?php echo $voterData; ?>"></div>
                </div>
              </div>
            <?php } ?>

          </div>
          <div class="card-footer text-center">
            <a class="m-0 small text-primary card-link" href="data_perhitungan.php">More <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if ($last > 0) { ?>
      <!-- Message From Customer-->
      <div class="col-xl-6">
        <div class="card">
          <div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-light">Final Voter</h6>
          </div>
          <div>
            <?php
            while ($row = mysqli_fetch_array($getLast)) {
            ?>
              <div class="customer-message align-items-center">
                <a class="font-weight-bold" href="#">
                  <div class="text-truncate message-title"><?php echo htmlspecialchars($row['voter_name']); ?> from faculty <?php echo htmlspecialchars($row['faculty_short']); ?> already chosen on the date <?php echo date('d/m/Y h:i:s', strtotime($row['vote_time'])); ?></div>
                </a>
              </div>
            <?php } ?>
            <div class="card-footer text-center">
              <a class="m-0 small text-primary card-link" href="data_suara.php">More <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

</div>
<!---Container Fluid-->
<?php
include 'template/footer.php';
?>