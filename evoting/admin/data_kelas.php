<?php 
$submenu = 'MasterData';
$judul = "Faculty Data";
include 'template/header.php';

$getFaculty = mysqli_query($koneksi,"SELECT * FROM faculties");
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
          <h6 class="m-0 font-weight-bold text-primary">Entire <?php echo $judul; ?></h6>
          <button type="button" class="m-0 float-right btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"id="#button_insert">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>
        <div class="table-responsive  p-3">
          <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Faculty Name</th>
                <th>Abbreviation</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              while ($faculty = mysqli_fetch_array($getFaculty)) { 
                $faculty_id = $faculty['faculty_id'];

                $getVoter = mysqli_query($koneksi,"SELECT count(voter_faculty) AS count_voter FROM voter WHERE voter_faculty='$faculty_id'");

                $voter = mysqli_fetch_array($getVoter);
                if($faculty['faculty_id'] == 1){
                  continue;
                }
                ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo htmlspecialchars($faculty['faculty_name']); ?></td>
                  <td><?php echo htmlspecialchars($faculty['faculty_short']); ?></td>
                  <td><?php echo htmlspecialchars($voter['count_voter']); ?></td>
                  <td>
                    <button type="button" class="btn btn-warning text-white btn-sm view_data" id="<?php echo htmlspecialchars($faculty['faculty_id']);?>" data-toggle="modal" data-target="modal_update"><i class="fas fa-pen"></i></button>
                    <?php $nomor = htmlspecialchars($faculty['faculty_id']);?> 
                    <button type="button" class='btn btn-sm btn-danger hapus' data-id="<?php echo $nomor; ?>" ><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>

  <!-- MODAL INSERT -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Add Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" id="form_insert">
          <div class="form-group">
            <label><b>Faculty Name</b></label>
            <input type="text" class="form-control" name="name" id="name">
          </div>
          <div class="form-group">
            <label><b>Abbreviation</b></label>
            <input type="text" class="form-control" name="singkat" id="singkat">
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
  $(document).ready(function(){
    $('#button_insert').click(function(){
      $('#form_insert')[0].reset();
    });

    $(document).on('submit', '#form_insert', function(event){
      event.preventDefault();
      var name = $('#name').val();
      var singkat = $('#singkat').val();

      if(name != '' && singkat != ''){
        $.ajax({
          url:"proses_data/insert_kelas.php",
          method:'POST',
          data:$('#form_insert').serialize(),
          success:function(response){
            if (response) {

              Swal.fire({
                icon: 'success',
                title: 'Succed!',
                text: 'Successfully added data'
              })
              .then (function() {
                 window.location.reload();
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
    });

    $(document).on('click','.view_data',function(){
      var id = $(this).attr("id");
      // memulai ajax
      $.ajax({
        url: 'update/modal_kelas.php', 
        method: 'post',  
        data: {id:id},    
        success:function(data){   
          $('#tampil').html(data);  
          $('#modal_update').modal("show");  
        }
      });
    });

    $(document).on('submit', '#form_update', function(event){
      event.preventDefault();
      var faculty_id = $('#faculty_id').val();
      var update_name = $('#update_name').val();
      var update_singkat = $('#update_singkat').val();

      if(update_name != '' && update_singkat != ''){
        $.ajax({
          url:"proses_data/update_kelas.php",
          method:'POST',
          data:$('#form_update').serialize(),
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
    });

    $(document).on('click','.hapus',function(){
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
            url: "proses_data/delete_kelas.php",
            data: { 
              id:id
            },
            success:function(response){

              if (response == "success") {

                Swal.fire({
                  icon: 'success',
                  title: 'Succed!',
                  text: 'Successfully deleted data'
                })
                .then (function() {
                   window.location.reload();
                });

              }else {

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