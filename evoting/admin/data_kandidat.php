<?php 
$submenu = 'MasterData';
$judul = "Candidate Data";
include 'template/header.php';

$getCandidate = mysqli_query($koneksi,"SELECT * FROM candidates");
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
    <div class="col-xl-12 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">All <?php echo $judul; ?></h6>
          <button type="button" class="m-0 float-right btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"id="#button_insert">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>

  <div class="row">
    <?php 
    $no = 1;
    $count = mysqli_num_rows($getCandidate);
    if ($count > 0) {
      while ($candidate = mysqli_fetch_array($getCandidate)) {
        ?>
        <div class="col-xl-6 mb-4">
          <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h5 class="m-0 font-weight-bold text-success">Candidate <?php echo $no++; ?></h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="font-weight-bold"><span class="text-primary">Name:</span> <?php echo htmlspecialchars($candidate['candidate_name']); ?></h6>
                  <h6 class="font-weight-bold"><span class="text-primary">Information:</span> <br>
                    <?php if (strlen($candidate['candidate_description']) > 20 ){
                      echo mb_substr($candidate['candidate_description'],0,200)."...";
                    } else {
                      echo $candidate['candidate_description'];
                    } ?>
                  </h6>
                </div>
                <div class="col-md-6">
                  <img src="../assets_back/foto_kandidat/<?php echo htmlspecialchars($candidate['candidate_photo']) ?>" style="width:100%;">
                </div>
              </div>
            </div>
            <div class="card-footer">
             <button type="button" class="btn btn-warning text-white btn-sm view_data" id="<?php echo htmlspecialchars($candidate['candidate_id']);?>" data-toggle="modal" data-target="modal_update"><i class="fas fa-pen"></i> Update</button>
             <?php $nomor = htmlspecialchars($candidate['candidate_id']);?>
             <button type="button" class='btn btn-sm btn-danger hapus' data-id="<?php echo $nomor; ?>" ><i class="fas fa-trash"></i> Delete</button>
           </div>
         </div>
       </div>
     <?php }}else{ ?>
      <div class="col-xl-12 mb-4">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          </button>
        </div>
        <div class="card-body">
         <h6 class="m-0 font-weight-bold text-danger"><center>THERE ARE NO CANDIDATES YET!</center></h6>
       </div>
       <div class="card-footer"></div>
     </div>
   </div>
 <?php } ?>
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
          <label><b>Candidate Name</b></label>
          <input type="text" class="form-control" name="nama" id="nama" autocomplete="off">
        </div>
        <div class="form-group">
          <label><b>Information</b></label>
          <textarea class="form-control ckeditor" id="ckeditor" name="ckeditor" required></textarea>
          <small class="form-text text-muted">It could be like a vision & mission</small>
        </div>
        <div class="form-group">
          <label><b>Cover</b></label>
          <input type="file" class="form-control file_foto" name="file_foto" id="file_foto" required>
          <small class="form-text text-muted">Max 2 MB format PNG,JPG dan JPEG</small>
        </div>
        <div class="form-group">
          <label><b>Campaign Video Link</b> <small class="text-muted">(Optional)</small></label>
          <input type="text" class="form-control" name="link" id="link"  autocomplete="off">
          <small class="form-text text-muted">The video must be uploaded to YouTube then enter the embed code into the field</small>
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
      var nama = $('#nama').val();
      var link = $('#link').val();
      var ckeditor = CKEDITOR.instances['ckeditor'].getData();
      var file_foto = $('.file_foto').prop('files')[0];

      var form_data = new FormData();
      form_data.append("file_foto",file_foto);
      form_data.append("nama",nama);
      form_data.append("link",link);
      form_data.append("ckeditor",ckeditor);

      if(nama != ''){
        $.ajax({
          url:"proses_data/insert_kandidat.php",
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
                text: 'Successfully added data'
              })
              .then (function() {
                window.location.reload();
              });

            }else if(response == "ukuran"){

              Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'Cover size must be under 2 MB'
              });

            }else if(response == "extentions"){

              Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'Extensions must be PNG, JPG and JPEG'
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
          text: 'All Fields Must Be Filled Out!'
        });
      }
    });

    $('.view_data').click(function(){
      var id = $(this).attr("id");
      // memulai ajax
      $.ajax({
        url: 'update/modal_kandidat.php', 
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
      var candidate_id = $('#candidate_id').val();
      var nama_update = $('#nama_update').val();
      var link_update = $('#link_update').val();
      var ckeditor_update = CKEDITOR.instances['ckeditor_update'].getData();
      var file_foto_update = $('.file_foto_update').prop('files')[0];

      var form_data = new FormData();
      form_data.append("file_foto_update",file_foto_update);
      form_data.append("candidate_id",candidate_id);
      form_data.append("nama_update",nama_update);
      form_data.append("link_update",link_update);
      form_data.append("ckeditor_update",ckeditor_update);

      if(candidate_id != '' && nama_update != '' ){
        $.ajax({
          url:"proses_data/update_kandidat.php",
          method:'POST',
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

            }else if(response == "ukuran"){

              Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'Cover size must be under 2 MB'
              });

            }else if(response == "extentions"){

              Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'Extensions must be PNG, JPG and JPEG'
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
          text: 'All Fields Must Be Filled Out!'
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
            url: "proses_data/delete_kandidat.php",
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