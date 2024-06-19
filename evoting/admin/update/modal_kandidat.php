<?php

//memasukkan koneksi database
include '../template/database.php';

if ($_POST['id']) {
  $id = $_POST['id'];
  $view = mysqli_query($koneksi, "SELECT * FROM candidates WHERE candidate_id='$id'");
  $row_view = mysqli_fetch_array($view);
?>

  <form method="post" id="form_update">
    <div class="form-group">
      <label><b>Candidate Name</b></label>
      <input type="text" class="form-control" name="nama_update" id="nama_update" autocomplete="off" value="<?php echo htmlspecialchars($row_view['candidate_name']); ?>">
      <input type="hidden" class="form-control" name="candidate_id" id="candidate_id" autocomplete="off" value="<?php echo htmlspecialchars($row_view['candidate_id']); ?>">
    </div>
    <div class="form-group">
      <label><b>Information</b></label>
      <textarea class="form-control ckeditor_update" id="ckeditor_update" name="ckeditor_update" required><?php echo htmlspecialchars($row_view['candidate_description']); ?></textarea>
      <script type="text/javascript">
        CKEDITOR.replace('ckeditor_update');
      </script>
      <small class="form-text text-muted">It could be like a vision & mission</small>
    </div>
    <div class="form-group">
      <label><b>Cover</b></label>
      <input type="file" class="form-control file_foto_update" name="file_foto_update" id="file_foto_update">
      <small class="form-text text-muted">Max 2 MB PNG, JPG and JPEG formats</small>
      <img src="../assets_back/foto_kandidat/<?php echo htmlspecialchars($row_view['candidate_photo']); ?>" class="img-fluid">
    </div>
    <div class="form-group">
      <label><b>Campaign Video Link</b> <small class="text-muted">(Opsional)</small></label>
      <input type="text" class="form-control" name="link_update" id="link_update" autocomplete="off" value="<?php echo htmlspecialchars($row_view['candidate_video']); ?>">
      <small class="form-text text-muted">The video must be uploaded to YouTube then enter the embed code into the field</small>
    </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
      <input type="submit" name="update_data" id="update_data" class="btn btn-primary" value="Save" />
    </div>
  </form>
<?php
}
?>