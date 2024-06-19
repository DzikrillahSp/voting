<?php
//memasukkan koneksi database
include '../template/database.php';

if($_POST['id']){
	$id = $_POST['id'];
	$view = mysqli_query($koneksi,"SELECT * FROM user WHERE id_user='$id'");
	$row_view = mysqli_fetch_array($view);
	?>
  <div class="form-group">
    <label><b>Full Name</b></label>
    <input type="text" class="form-control" name="nama_lengkap_update" id="nama_lengkap_update" value="<?php echo htmlspecialchars($row_view['user_nama']) ?>">
    <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?php echo htmlspecialchars($row_view['id_user']) ?>">
  </div>
  <div class="form-group">
    <label><b>Username</b></label>
    <input type="text" class="form-control" name="username_update" id="username_update" value="<?php echo htmlspecialchars($row_view['user_username']) ?>">
  </div>
  <div class="form-group">
    <label><b>Password</b></label>
    <input type="password" class="form-control" name="password_update" id="password_update">
    <small class="text-muted text-form">Leave it blank if you don't want to replace it</small>
  </div>
  <div class="form-group">
    <label><b>User Role</b></label>
    <select id="role_update" class="form-control">
      <option <?php if ($row_view['user_role'] == "admin") {echo "selected";} ?> value="admin">Admin</option>
      <option <?php if ($row_view['user_role'] == "petugas") {echo "selected";} ?> value="petugas">Officer</option>
    </select>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
  <button class="btn btn-primary btn-update" type="submit">Save</button>
</div>
<?php
}
?>
<script type="text/javascript">
  function update_proses(){

   var nama_lengkap_update = $('#nama_lengkap_update').val();
   var username_update = $('#username_update').val();
   var password_update = $('#password_update').val();
   var role_update = $('#role_update').val();
   var id_user = $('#id_user').val();

   if(nama_lengkap_update != '' && username_update != '' && role_update != '' && id_user != ''){
    $.ajax({
      url:"proses_data/update_user.php",
      method:'POST',
      data:{ 
        "id_user":id_user,
        "nama_lengkap_update":nama_lengkap_update,
        "username_update":username_update,
        "password_update":password_update,
        "role_update":role_update
      },
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
            icon: 'error',
            title: 'Sorry!',
            text: 'Failed to change data'
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
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Oops..!',
      text: 'All fields must be filled in!'
    });
  }
}

$(".btn-update").click( function() {
  update_proses();
});
</script>