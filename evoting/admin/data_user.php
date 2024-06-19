<?php
$judul = "User Management";
include 'template/header.php';

$user_get = mysqli_query($koneksi, "SELECT * FROM user");
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
          <h6 class="m-0 font-weight-bold text-primary"><?php echo $judul; ?></h6>
          <button type="button" class="m-0 float-right btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal" id="#button_insert">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>
        <div class="table-responsive  p-3">
          <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($get = mysqli_fetch_array($user_get)) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo htmlspecialchars($get['user_nama']); ?></td>
                  <td><?php echo htmlspecialchars($get['user_username']); ?></td>
                  <td><?php
                      if ($get['user_role'] == 'admin') {
                        echo 'Admin';
                      } elseif ($get['user_role'] == 'petugas') {
                        echo 'Officer';
                      } ?></td>
                  <td>
                    <?php

                    if ($get['id_user'] != $_SESSION['id_user']) {

                    ?>
                      <button type="button" class="btn btn-warning text-white btn-sm view_data" id="<?php echo htmlspecialchars($get['id_user']); ?>" data-toggle="modal" data-target="modal_update"><i class="fas fa-pen"></i></button>

                      <?php $nomor = htmlspecialchars($get['id_user']); ?>
                      <button type="button" class='btn btn-sm btn-danger hapus' data-id="<?php echo $nomor; ?>"><i class="fas fa-trash"></i></button>
                    <?php } ?>
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
          <div class="form-group">
            <label><b>Full Name</b></label>
            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap">
          </div>
          <div class="form-group">
            <label><b>Username</b></label>
            <input type="text" class="form-control" name="username" id="username">
          </div>
          <div class="form-group">
            <label><b>Password</b></label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="form-group">
            <label><b>User Role</b></label>
            <select id="role" class="form-control">
              <option value="admin">Admin</option>
              <option value="petugas">Officer</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary btn-tambah" type="submit">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL INSERT END -->

  <!-- MODAL UPDATE -->
  <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Form</h5>
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
<script type="text/javascript">
  $(document).ready(function() {
    $('#button_insert').click(function() {
      $('#form_insert')[0].reset();
    });

    function tambah_proses() {
      var nama_lengkap = $('#nama_lengkap').val();
      var username = $('#username').val();
      var password = $('#password').val();
      var role = $('#role').val();
      if (nama_lengkap != '' && username != '' && password != '' && role != '') {
        $.ajax({
          url: "proses_data/insert_user.php",
          method: 'POST',
          data: {
            "nama_lengkap": nama_lengkap,
            "username": username,
            "password": password,
            "role": role
          },
          success: function(response) {
            if (response == "success") {

              Swal.fire({
                  icon: 'success',
                  title: 'Succed!',
                  text: 'Successfully added data'
                })
                .then(function() {
                  window.location.reload();
                });

            } else {

              Swal.fire({
                icon: 'error',
                title: 'Sorry!',
                text: 'Failed to add data'
              });

            }

            console.log(response);
          },

          error: function(response) {

            Swal.fire({
              icon: 'error',
              title: 'Oops..!',
              text: 'Server error!'
            });

            console.log(response);

          }

        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'All fields must be filled in!'
        });
      }
    }

    $(".btn-tambah").click(function() {
      tambah_proses();
    });

    $('.view_data').click(function() {
      var id = $(this).attr("id");
      // memulai ajax
      $.ajax({
        url: 'update/modal_user.php',
        method: 'post',
        data: {
          id: id
        },
        success: function(data) {
          $('#tampil').html(data);
          $('#modal_update').modal("show");
        }
      });
    });

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
            url: "proses_data/delete_user.php",
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