  </div>
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
      <!--  &copy; Copyright <strong><span></span></strong>. All Rights Reserved - Designed </b> -->
      </span>
    </div>
  </div>
</footer>
<!-- Footer -->
</div>
</div>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <p>Are you sure to come out?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
      <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
  </div>
</div>
</div>
<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="../assets_back/vendor/jquery/jquery.min.js"></script>
<script src="../assets_back/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets_back/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../assets_back/js/ruang-admin.min.js"></script>
<!-- Page level plugins -->
<script src="../assets_back/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets_back/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../assets_back/alert/sweetalert2.min.js"></script>
<script src="../assets_back/ckeditor/ckeditor.js"></script>
<!-- Page level custom scripts -->
<script>
  $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>