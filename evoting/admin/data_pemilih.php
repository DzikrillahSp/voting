<?php
$submenu = 'MasterData';
$judul = "Voter Data";
include 'template/header.php';

$getVoter = mysqli_query($koneksi, "SELECT * FROM voter,faculties WHERE voter.voter_faculty=faculties.faculty_id ORDER BY faculties.faculty_name ASC");
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
        <div class="card-header flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">All <?php echo $judul; ?></h6>

          <button type="button" class="m-0 ml-2 float-right btn btn-sm btn-primary button_insert" data-toggle="modal" data-target="#exampleModal" id="#button_insert">
            <i class="fas fa-plus"></i> Add
          </button>
          <a href="data_pemilih_import.php" class="m-0 float-right btn btn-sm btn-info import_data_btn"><i class="fas fa-download"></i> Import Data</a>
          <br>
          <br>
          <button class="m-0 ml-2 mt-1 float-right btn btn-sm btn-warning generate-all"><i class="fas fa-sync-alt"></i> Update Access Code</button>
          <button class="m-0 ml-2 mt-1 float-right btn btn-sm btn-primary update-all" id="#button_all"><i class="fa fa-edit"></i> Status Updates</button>

          <button class="m-0 ml-2 mt-1 float-right btn btn-sm btn-dark send-email-all" id="send-email-all"><i class="fa fa-envelope"></i> Send Access Code</button>

        </div>
        <div class="table-responsive  p-3">
          <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Matrix</th>
                <th>Full Name</th>
                <th>Faculty</th>
                <th>Status</th>
                <th>Access Code</th>
                <th>Kode Verifikasi</th>
                <th>Send</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($voter = mysqli_fetch_array($getVoter)) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo htmlspecialchars($voter['voter_nis']); ?></td>
                  <td><?php echo htmlspecialchars($voter['voter_name']); ?></td>
                  <td><?php echo htmlspecialchars($voter['faculty_name']); ?></td>
                  <td>
                    <?php
                    if ($voter['voter_status'] == 0) {
                      echo '<span class="badge badge-danger">Have not chosen yet</span>';
                    } elseif ($voter['voter_status'] == 1) {
                      echo '<span class="badge badge-success">Already Chosen</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($voter['voter_code']); ?>
                    <?php $id_get = htmlspecialchars($voter['id_voter']); ?>
                    <button type="button" class='btn btn-sm btn-primary generate' data-id="<?php echo $id_get; ?>" alt="Generate Ulang"><i class="fas fa-sync-alt"></i></button>
                  </td>
                  <td>
                    
                  </td>
                  <td>
                    <?php
                    if ($voter['voter_phone_number'] == "") {
                      echo " - ";
                    } else {
                    ?>
                      <a href="https://api.whatsapp.com/send?phone=62<?php echo htmlspecialchars($voter['voter_phone_number']); ?>&text=Haloo%2C%20Saya%20panitia%20E-Voting%20ingin%20memberikan%20akses%20login%20kewebsite%20untuk%20melakukan%20pemilihan.%0D%0A%0D%0AUsername%3A%20<?php echo htmlspecialchars($voter['voter_nis']); ?>%0D%0AKode%20Akses%3A%20<?php echo htmlspecialchars($pemilih['voter_code']); ?>%0D%0A%0D%0ALink%20login%20%3A%20<?php echo $setting['setting_url']; ?>%0D%0A%0D%0AGunakan%20hak%20suaramu%20sebaik%20mungkin%20ya%21" class="btn btn-success text-white btn-sm" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <?php }

                    if ($voter['voter_email'] == "") {
                      echo " - ";
                    } else { ?>
                      <button type="button" class="btn btn-info text-white btn-sm kirim_email" id="<?php echo htmlspecialchars($voter['id_voter']); ?>"><i class="far fa-envelope"></i></button>
                    <?php } ?>
                  </td>
                  <td>
                    <button type="button" class="btn btn-warning text-white btn-sm view_data" id="<?php echo htmlspecialchars($voter['id_voter']); ?>" data-toggle="modal" data-target="modal_update"><i class="fas fa-pen"></i></button>
                    <?php $nomor = htmlspecialchars($voter['id_voter']); ?>
                    <button type="button" class='btn btn-sm btn-danger hapus' data-id="<?php echo $nomor; ?>"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>

  <!-- MODAL INSERT -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Add Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="form_insert">
            <div class="form-group">
              <label><b>Matrix</b></label>
              <input type="number" class="form-control" name="nis" id="nis">
            </div>
            <div class="form-group">
              <label><b>Full Name</b></label>
              <input type="text" class="form-control" name="nama" id="nama">
            </div>
            <div class="form-group">
              <label><b>Faculty</b></label>
              <select name="kelas" id="kelas" class="form-control" required>
                <option value="">- Select Faculty -</option>
                <?php
                $faculty = mysqli_query($koneksi, "SELECT * FROM faculties");
                while ($cc = mysqli_fetch_assoc($faculty)) {
                  if ($cc['faculty_id'] == 1) {
                    continue;
                  } ?>
                  <option value="<?php echo htmlspecialchars($cc['faculty_id']); ?>"><?php echo htmlspecialchars($cc['faculty_name']); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="nowa"><b>Whatsapp Number</b> <small class="text-muted">(Can be left blank)</small></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="no">+60</span>
                </div>
                <input type="number" class="form-control" name="nowa" id="nowa" aria-describedby="no" placeholder="contoh: 89560171727">
              </div>
              <small class="text-muted">Make sure the WhatsApp number is active!</small>
            </div>
            <div class="form-group">
              <label><b>Email</b> <small class="text-muted">(Can be left blank)</small></label>
              <input type="email" class="form-control" name="email" id="email">
              <small class="text-muted">Make sure Email is Active!</small>
            </div>
            <div class="form-group">
              <label for="file_foto"><b>Picture</b></label>
              <input type="file" class="form-control-file file_foto" name="file_foto" id="file_foto" accept="image/png, image/jpeg" required>
              <small class="form-text text-muted">Max 2 MB format PNG, JPG, dan JPEG</small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
          <input type="submit" name="action" id="action" class="btn btn-primary" value="Save" />
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- MODAL INSERT END -->

  <!-- MODAL UPDATE -->
  <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Update Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="tampil"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL UPDATE END -->


</div>
<!---Container Fluid-->
<?php
include 'template/footer.php';
?>
<script type="text/javascript" src="../assets_back/js/app/pemilih.js"></script>