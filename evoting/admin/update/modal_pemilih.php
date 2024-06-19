<?php
//memasukkan koneksi database
include '../template/database.php';
if ($_POST['id']) {
  $id = $_POST['id'];
  $view = mysqli_query($koneksi, "SELECT * FROM voter WHERE id_voter='$id'");
  $row_view = mysqli_fetch_array($view);
?>
  <form method="post" id="form_update">
    <div class="form-group">
      <label><b>Matrix</label>
      <input type="number" class="form-control" name="nis_update" id="nis_update" value="<?php echo htmlspecialchars($row_view['voter_nis']) ?>">
      <input type="hidden" class="form-control" name="id_voter" id="id_voter" value="<?php echo htmlspecialchars($row_view['id_voter']) ?>">
    </div>
    <div class="form-group">
      <label><b>Full Name</b></label>
      <input type="text" class="form-control" name="nama_update" id="nama_update" value="<?php echo htmlspecialchars($row_view['voter_name']) ?>">
    </div>
    <div class="form-group">
      <label><b>Faculty</b></label>
      <select name="kelas_update" id="kelas_update" class="form-control" required>
        <option value="">- Select Faculty -</option>
        <?php
        $kelas = mysqli_query($koneksi, "SELECT * FROM faculties");
        while ($cc = mysqli_fetch_assoc($kelas)) {
          if ($cc['faculty_id'] == 1) {
            continue;
          }
        ?>
          <option <?php if ($cc['faculty_id'] == $row_view['voter_faculty']) {
                    echo "selected";
                  } ?> value="<?php echo htmlspecialchars($cc['faculty_id']); ?>"><?php echo htmlspecialchars($cc['faculty_name']); ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="nowa_update"><b>Whatsapp Number</b> <small class="text-muted">(Can be left blank)</small></label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="no">+60</span>
        </div>
        <input type="number" class="form-control" name="nowa_update" id="nowa_update" aria-describedby="no" value="<?php echo htmlspecialchars($row_view['voter_phone_number']) ?>" placeholder="contoh: 89560171727">
      </div>
      <small class="text-muted">Make sure the WhatsApp number is active!</small>
    </div>
    <div class="form-group">
      <label><b>Email</b> <small class="text-muted">(Can be left blank)</small></label>
      <input type="email" class="form-control" name="email_update" id="email_update" value="<?php echo htmlspecialchars($row_view['voter_email']) ?>">
      <small class="text-muted">Make sure Email is Active!</small>
    </div>

    <div class="form-group">
      <label for="file_foto_update"><b>Picture</b> <small class="text-muted">(Can be left blank)</small></label>
      <input type="file" class="form-control-file file_foto_update" name="file_foto_update" id="file_foto_update" accept="image/png, image/jpeg">
      <small class="form-text text-muted">Max 2 MB format PNG, JPG, dan JPEG</small>

    </div>

    <div class="form-group">
      <label for="file_foto_update"><b>Picture (Old)</b></label> <br>
      <img src="../assets_back/verify_pemilih/<?php echo htmlspecialchars($row_view['verification']); ?>" style="width:20%;" alt="Picture">
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