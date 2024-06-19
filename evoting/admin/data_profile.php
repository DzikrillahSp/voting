<?php 
$judul = "Profile";
include 'template/header.php';

$id_user = $_SESSION['id_user'];
$getuser = mysqli_query($koneksi,"SELECT * FROM user WHERE id_user='$id_user'");
$user = mysqli_fetch_array($getuser);
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
    <h6 class="m-0 font-weight-bold text-primary">Setting <?php echo $judul; ?></h6>
  </div>
  <div class="card-body">
    <div class="form-group">
      <label><b> Full Name </label>
        <input type="text" class="form-control" id="nama_lengkap" value="<?php echo htmlspecialchars($user['user_nama']); ?>">
      </div>
      <div class="form-group">
        <label><b>Username</b></label>
        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user['user_username']); ?>">
      </div>
      <div class="form-group">
        <label><b> Password</b></label>
        <input type="password" class="form-control" id="password">
        <small class="form-text text-muted">Leave it blank if you don't want to replace it</small>
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


    function tambah_proses(){
      var nama_lengkap = $('#nama_lengkap').val();       
      var username = $('#username').val();       
      var password = $('#password').val();

      var form_data = new FormData();
      form_data.append("nama_lengkap",nama_lengkap);
      form_data.append("username",username);
      form_data.append("password",password);
      if(nama_lengkap.length == "") {

       Swal.fire({
        icon: 'error',
        title: 'Oops..!',
        text: 'Full Name must be filled in'
      });

     }else if(username.length == "") {

      Swal.fire({
        icon: 'error',
        title: 'Oops..!',
        text: 'Username cannot be empty'
      });

    }else{

      $.ajax({
        url: "proses_data/update_profile.php",
        type: "POST",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success:function(response){

          if (response == "success") {

            Swal.fire({
              icon: 'success',
              title: 'Succed!',
              text: 'Successfully changed data'
            })
            .then (function() {
             window.location.reload();
           });

          } else {

            Swal.fire({
              icon: 'success',
              title: 'Succed!',
              text: 'Successfully changed data'
            });

          }

          console.log(response);

        },

        error:function(response){

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

  $(".btn-tambah").click( function() {
    tambah_proses();
  });

});
</script>