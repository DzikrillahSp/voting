<?php
//memasukkan koneksi database
include '../template/database.php';

if($_POST['id']){
	$id = $_POST['id'];
	$view = mysqli_query($koneksi,"SELECT * FROM faculties WHERE faculty_id='$id'");
	$row_view = mysqli_fetch_array($view);
	?>
	 <form  method="post" id="form_update">
          <div class="form-group">
            <label><b>Faculty Name</b></label>
            <input type="text" class="form-control" name="update_name" id="update_name" value="<?php echo htmlentities($row_view['faculty_name']); ?>">
            <input type="hidden" class="form-control" name="faculty_id" id="faculty_id" value="<?php echo htmlentities($row_view['faculty_id']); ?>">
          </div>
          <div class="form-group">
            <label><b>Abbreviation</b></label>
            <input type="text" class="form-control" name="update_singkat" id="update_singkat" value="<?php echo htmlentities($row_view['faculty_short']); ?>">
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
