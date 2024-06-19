<?php
$judul = "Web Settings";
include 'template/header.php';

$getsetting = mysqli_query($koneksi, "SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getsetting);
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
    <div class="col-xl-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Reset Database</h6>
        </div>
        <div class="card-body">
          <span class="text-muted">If you want to vote again, to clean the data from the previous vote, you have to reset the database first.</span>
          <br>
          <button class="btn btn-sm btn-danger btn-icon-split mt-2" data-toggle="modal" data-target="#resetdb">
            <span class="icon text-white-50">
              <i class="fas fa-trash"></i>
            </span>
            <span class="text">Reset</span>
          </button>
        </div>
      </div>
    </div>

    <div class="col-xl-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Election Type</h6>
        </div>
        <div class="card-body">
          <form method="post" id="jenis_pemilihan">
            <div class="form-group">
              <label><b>Election Type</b> <small class="text-muted">(Adjust it to your agency's selection needs)</small></label>
              <select id="jenis_pemilih" name="jenis_pemilih" class="form-control">
                <option value="osis" <?php if ($setting['setting_type'] == "osis") {
                                        echo "selected";
                                      } ?>>Election of Head of Organization</option>
                <option value="presma" <?php if ($setting['setting_type'] == "presma") {
                                          echo "selected";
                                        } ?>>Election of Student President</option>
              </select>
            </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary btn-form" id="btn-form" type="submit">Submit</button>
        </div>
        </form>
      </div>
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="resetdb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelLogout">Confirm Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="form_reset">
              <div class="form-group">
                <label><b>Enter password</b></label>
                <input type="password" class="form-control" name="password" id="password">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            <input type="submit" name="action" id="action" class="btn btn-primary" value="Submit" />
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-xl-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><?php echo $judul; ?> to load the basic website settings</h6>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label><b> Organization Name </label>
            <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah" value="<?php echo htmlspecialchars($setting['setting_school_name']); ?>">
          </div>
          <div class="form-group">
            <label><b> Website Description</b></label>
            <textarea class="form-control" name="deskripsi" id="deskripsi"><?php echo htmlspecialchars($setting['setting_description']); ?></textarea>
          </div>
          <div class="form-group">
            <label><b> Website Keywords</b></label>
            <textarea class="form-control" name="keyword" id="keyword"><?php echo htmlspecialchars($setting['setting_keyword']); ?></textarea>
            <small class="form-text text-muted">Separate each keyword with commas</small>
          </div>
          <div class="form-group">
            <label><b> Email</b></label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($setting['setting_email']); ?>">
            <small class="form-text text-muted">Email where you can be contacted</small>
          </div>
          <div class="form-group">
            <label><b> Whatsapp Number</b></label>
            <input type="number" class="form-control" name="nowa" id="nowa" value="<?php echo htmlspecialchars($setting['setting_phone_number']); ?>">
            <small class="form-text text-muted">whatsapp number that can be contacted</small>
          </div>
          <div class="form-group">
            <label><b> Website URL</b></label>
            <input type="text" class="form-control" name="url" id="url" value="<?php echo htmlspecialchars($setting['setting_url']); ?>" placeholder="contoh: www.example.com">
            <small class="form-text text-muted">Filled in correctly and active because it will be used for voter login access</small>
          </div>
          <div class="form-group">
            <label><b> Voting Status</b></label>
            <select id="status" name="status" class="form-control">
              <option value="open" <?php if ($setting['setting_schedule'] == "open") {
                                      echo "selected";
                                    } ?>>Opened</option>
              <option value="closed" <?php if ($setting['setting_schedule'] == "closed") {
                                        echo "selected";
                                      } ?>>Closed</option>
            </select>
          </div>
          <div class="form-group">
            <label><b> Website Logos</b></label>
            <input type="file" class="form-control logo" id="logo" name="logo">
            <small class="form-text text-muted">Max 2 MB PNG, JPG and JPEG formats</small>
          </div>
          <div class="form-group">
            <label><b> Website Logo Preview</b></label> <br>
            <img src="../assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" style="width: 100px; height: 100px;">
          </div>
          <button type="submit" class="btn btn-primary btn-tambah">Save</button>
        </div>
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


    $('#jenis_pemilihan').on('submit', function(event) {
      event.preventDefault();
      var jenis = $('#jenis_pemilih').val();
      Swal.fire({
        title: 'Wait a moment',
        html: 'Currently adjusting...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
          Swal.showLoading()
        },
      });
      $.ajax({
        url: "proses_data/setting_jenis.php",
        method: 'post',
        data: {
          jenis: jenis
        },
        success: function(data) {
          if (data == "success") {

            Swal.fire({
              icon: 'success',
              title: 'Okey!',
              text: 'Customized successfully'
            });

          } else {

            Swal.fire({
              icon: 'error',
              title: 'Ops!',
              text: 'Failed to adjust'
            });

          }

          console.log(data);
        },

        error: function(data) {

          Swal.fire({
            icon: 'error',
            title: 'Oops..!',
            text: 'Server error!'
          });

          console.log(data);

        }
      });
    });


    function tambah_proses() {
      var nama_sekolah = $('#nama_sekolah').val();
      var deskripsi = $('#deskripsi').val();
      var keyword = $('#keyword').val();
      var email = $('#email').val();
      var nowa = $('#nowa').val();
      var url = $('#url').val();
      var status = $('#status').val();
      var logo = $('.logo').prop('files')[0]; //Fetch the file

      var form_data = new FormData();
      form_data.append("logo", logo);

      form_data.append("nama_sekolah", nama_sekolah);
      form_data.append("deskripsi", deskripsi);
      form_data.append("keyword", keyword);
      form_data.append("email", email);
      form_data.append("nowa", nowa);
      form_data.append("url", url);
      form_data.append("status", status);

      if (nama_sekolah.length == "") {

        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'University Name must be filled in'
        });

      } else if (deskripsi.length == "") {

        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'Website description must be filled in'
        });

      } else if (keyword.length == "") {

        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'Website keywords must be filled in'
        });

      } else if (nowa.length == "") {

        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'Whatsapp number must be filled in'
        });

      } else if (email.length == "") {

        Swal.fire({
          icon: 'error',
          title: 'Oops..!',
          text: 'Email must be filled in'
        });

      } else {

        $.ajax({
          url: "proses_data/update_pengaturan.php",
          type: "POST",
          dataType: 'script',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          success: function(response) {

            if (response == "success") {

              Swal.fire({
                  icon: 'success',
                  title: 'Succed!',
                  text: 'Successfully changed data'
                })
                .then(function() {
                  window.location.reload();
                });

            } else if (response == "ukuran") {

              Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'Size must be under 2 MB'
              });

            } else if (response == "extentions") {

              Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'The extension must be a PNG. JPG and JPEG'
              });

            } else {

              Swal.fire({
                icon: 'success',
                title: 'succed!',
                text: 'Successfully changed data'
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

      }

    }

    $(".btn-tambah").click(function() {
      tambah_proses();
    });

    $(document).on('submit', '#form_reset', function(event) {
      event.preventDefault();
      Swal.fire({
        title: 'Are you sure?',
        text: "Will delete all voting data such as voter data, candidates and all voter votes!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, sure!'
      }).then((result) => {
        if (result.value) {
          var password = $('#password').val();

          if (password != '') {
            $.ajax({
              url: "proses_data/reset_database.php",
              method: 'POST',
              data: $('#form_reset').serialize(),
              success: function(response) {
                if (response == "success") {

                  Swal.fire({
                      icon: 'success',
                      title: 'Succed!',
                      text: 'Successfully deleted all data'
                    })
                    .then(function() {
                      window.location.reload();
                    });

                } else if (response == "password_salah") {

                  Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'The password entered is incorrect!'
                  });

                } else {

                  Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Failed to delete all data'
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
              text: 'Password is required!'
            });
          }
        }
      })
    });

  });
</script>