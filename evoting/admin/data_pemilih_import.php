<?php 
$submenu = 'MasterData';
$judul = "Voter Data";
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

  <div class="row mb-5">
    <div class="col-xl-12 col-lg-7 mb-4">
      <div class="card">
        <div class="card-header py-3 flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Import Voter Data</h6>
          <button type="button" class="m-0 ml-2 float-right btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal"id="#button_insert">
            <i class="fas fa-plus"></i> Upload Instructions
          </button>
          <a href="template/template-upload-data-evoting-2.xlsx" class="m-0 float-right btn btn-sm btn-primary"><i class="fas fa-download"></i> Download Templates</a>
        </div>
        <div class="card-body">
          <div class="pesan" id="pesan"></div>
          <div class="sebentar" id="sebentar"></div>
          <form method="post" id="import_excel">

            <div class="form-group">
              <label><b>Upload Files</b></label>
              <input type="file" name="import" id="import" class="form-control">
            </div> 

            <div class="form-group">
              <label><b>Passed to faculty</b></label>
              <select name="kelas" id="kelas" class="form-control" required>
                <?php
                $faculty = mysqli_query($koneksi, "SELECT * FROM faculties");
                while($cc = mysqli_fetch_assoc($faculty)){ 
                  if($cc['faculty_id'] == 1){
                    continue;
                  }?>
                  <option value="<?php echo htmlspecialchars($cc['faculty_id']); ?>"><?php echo htmlspecialchars($cc['faculty_name']); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group" id="process" style="display:none;">
              <div class="progress mb-3">
                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer">
            <button class="btn btn-primary btn-form" id="btn-form" type="submit">Submit</button>
            <a href="data_pemilih.php" class="btn btn-outline-danger" id="btn-kembali">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!---Container Fluid-->

  <!-- MODAL INSERT -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Upload Instructions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="font-weight-bold">Conditions for Uploading Files</h5>
        <ul>
          <li>If a student does not have WhatsApp/email then just leave it blank but must fill in their name and matrix.</li>
          <li>Can import a maximum of 200 data only (more but not recommended)</li>
        </ul>
        <h5 class="font-weight-bold">How to Upload Data</h5>
        <ul>
          <li>First download the template on the download button</li>
          <li>Please fill in the data according to the template provided</li>
          <li>An example of filling in is as below :</li>
          <li><img src="../assets_back/8.jpg" class="img-fluid"><br><small class="text-muted text-center">Note: Colors are just examples, don't copy them!</small></li>
          <ul>
            <li><b>Sequence Data No. 2</b>:Is the most correct way to fill in data</li>
            <li><b>Yellow</b>: If a student doesn't have a WhatsApp number, just delete it and don't fill in anything</li>
            <li><b>Green</b>: If a student doesn't have an email, just delete it and don't fill in anything</li>
            <li><b>Purple</b>: If a student doesn't have an email or WhatsApp number, just delete it and don't fill in anything</li>
          </ul>
          <li>The important thing is to fill in the Matrix and the student's name</li>
        </ul>
        <h5 class="font-weight-bold">Things To Avoid!</h5>
        <ul>
          <li>This feature can only upload a maximum of 200 data, actually it can be more than that, but to avoid server delays, I recommend uploading a maximum of 200 data.</li>
          <li>Don't have 1 empty row of data!</li>
          <li>When uploading data, the page should not be refreshed</li>then it is better to delete the quotation marks, for example Dzi&#039;ril change to Dzikril.
          <li>If the voter's name has quotation marks (&#039;) </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<!-- MODAL INSERT END -->

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php 
include 'template/footer.php';
?>
<script type="text/javascript">
  $(document).ready(function(){  

    $('#import_excel').on('submit', function(event){  
     event.preventDefault();  
     $.ajax({  
      url:"proses_data/import_pemilih.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,
      beforeSend:function(){
        $('#sebentar').html("<div class='alert alert-danger' role='alert'>Wait a minute, please...</div>");
        $('#btn-kembali').hide();
        $('#btn-form').hide();
        $('#process').css('display', 'block');
      },  
      success:function(data){  
       var percentage = 0;

       var timer = setInterval(function(){
         percentage = percentage + 20;
         progress_bar_process(percentage, timer);
       }, 1000);

       console.log(data);
     },

     error:function(data){

      Swal.fire({
        icon: 'error',
        title: 'Oops..!',
        text: 'Server error!'
      });

      console.log(data);

    }  
  });  
   });  

    function progress_bar_process(percentage, timer){
     $('.progress-bar').css('width', percentage + '%');
     if(percentage > 100){
      clearInterval(timer);
      $('#import_excel')[0].reset();
      
      $('#process').css('display', 'none');
      $('.progress-bar').css('width', '0%');
      $('#pesan').html("<div class='alert alert-primary' role='alert'>OK, voter data has been entered successfully</div>");
      $('#sebentar').html("");
      setTimeout(function(){
       $('#pesan').html('');
       $('#btn-kembali').show();
       $('#btn-form').show();
     }, 3000);
    }
  }

});
</script>