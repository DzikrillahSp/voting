<?php
$judul = "Voter's Vote";
include 'template/header.php';

$getVote = mysqli_query($koneksi, "SELECT * FROM voter_votes, candidates, voter, faculties WHERE voter_votes.vote_candidate_id=candidates.candidate_id 
AND voter_votes.vote_voter_id=voter.id_voter 
AND voter.voter_faculty=faculties.faculty_id ORDER BY voter_votes.id_vote DESC");
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
    <div class="col-xl-12 col-lg-7 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">All Data <?php echo $judul; ?></h6>
        </div>
        <div class="card-body">
          <div class="table-responsive  p-3">
            <table class="table align-items-center table-flush" id="dataTable">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>Matrix</th>
                  <th>Voter Name</th>
                  <th>Faculty</th>
                  <th>Selected Candidates</th>
                  <th>Time</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while ($suara = mysqli_fetch_array($getVote)) {
                  $id_voter = $suara['id_voter'];
                  $getVoter = mysqli_query($koneksi, "SELECT count(vote_voter_id) as jumlah FROM voter_votes WHERE vote_voter_id='$id_voter'");
                  $voter = mysqli_fetch_array($getVoter);
                ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($suara['voter_nis']); ?></td>
                    <td><?php echo htmlspecialchars($suara['voter_name']); ?></td>
                    <td><?php echo htmlspecialchars($suara['faculty_name']); ?></td>
                    <td><?php echo htmlspecialchars($suara['candidate_name']); ?></td>
                    <td><?php echo date('d/m/Y h:i:s', strtotime($suara['vote_time'])); ?></td>
                    <td>
                      <?php if ($voter['jumlah'] > 1) { ?>
                        <?php $nomor = htmlspecialchars($suara['id_vote']); ?>
                        <button type="button" class='btn btn-sm btn-danger hapus' data-id="<?php echo $nomor; ?>"><i class="fas fa-trash"></i></button>
                      <?php } ?>
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
  </div>
</div>
<!---Container Fluid-->
<?php
include 'template/footer.php';
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.hapus', function() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Will delete this data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, sure!'
      }).then((result) => {
        if (result.value) {
          var id = $(this).attr('data-id');
          $.ajax({
            method: "POST",
            url: "proses_data/delete_suara.php",
            data: {
              id: id
            },
            success: function(response) {

              if (response == "success") {

                Swal.fire({
                    icon: 'success',
                    title: 'Succed!',
                    text: 'Successfully deleted data'
                  })
                  .then(function() {
                    window.location.reload();
                  });

              } else {

                Swal.fire({
                  icon: 'error',
                  title: 'Sorry!',
                  text: 'Failed to delete data'
                });

              }
              console.log(response);
            }
          });
        }
      })
    });
  });
</script>