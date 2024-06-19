<?php 
session_start();
include 'database.php';

$timeout = 30; 
$logout = "logout.php"; 

$timeout = $timeout * 60;
if(isset($_SESSION['start_session'])){
  $elapsed_time = time()-$_SESSION['start_session'];
  if($elapsed_time >= $timeout){
    session_destroy();
    echo "<script type='text/javascript'>alert('The session has ended, please log in again');window.location='$logout'</script>";
  }
}

$_SESSION['start_session']=time();

if (isset($_SESSION['login'])) {

  if ($_SESSION['login'] != "login") {
    echo "<script type='text/javascript'>alert('The session has ended, please log in again');window.location='$logout'</script>";
  }else{
   $id_user = $_SESSION['id_user'];

   $ambil_user = mysqli_query($koneksi,"SELECT * FROM user WHERE id_user='$id_user' ");
   $user = mysqli_fetch_array($ambil_user);
 }

}else{

  echo "<script type='text/javascript'>alert('The session has ended, please log in again');window.location='$logout'</script>";

}

$getSetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getSetting);

?> 

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets_back/<?php echo htmlspecialchars($setting['setting_favicon']); ?>" rel="icon">
  <title><?php echo $judul; ?> - Website for Election of Organization Chair <?php echo htmlspecialchars($setting['setting_school_name']); ?></title>
  <link href="../assets_back/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets_back/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets_back/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets_back/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../assets_back/alert/sweetalert2.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">

        </div>
        <div class="sidebar-brand-text mx-3">E-Election</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item <?php if($judul=='Dashboard'){ echo'active'; } ?>" >
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Features
        </div>
        <?php 
        if ($user['user_role'] == "admin") {
          ?>
          <li class="nav-item <?php if($submenu == 'MasterData'){ echo 'active'; } ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Master Data</span>
          </a>
          <div id="collapseBootstrap" class="collapse <?php if($submenu == 'MasterData'){ echo 'show'; } ?>" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item <?php if($judul=='Data Kelas'){ echo'active'; } ?>" href="data_kelas.php">Faculty Data</a>
              <a class="collapse-item <?php if($judul=='Data Pemilih'){ echo'active'; } ?>" href="data_pemilih.php">Voter Data</a>
              <a class="collapse-item <?php if($judul=='Data Kandidat'){ echo'active'; } ?>" href="data_kandidat.php">Candidate Data</a>
            </div>
          </div>
        </li>
      <?php } ?>
      <li class="nav-item <?php if($judul=='Suara Pemilih'){ echo'active'; } ?>">
        <a class="nav-link" href="data_suara.php">
          <i class="fas fa-fw fa-pen"></i>
          <span>Voter's Vote</span>
        </a>
      </li>
      <li class="nav-item <?php if($judul=='Quick Count'){ echo'active'; } ?>">
        <a class="nav-link" href="data_perhitungan.php">
          <i class="fas fa-fw fa-chart-pie"></i>
          <span>Quick Count</span>
        </a>
      </li>
      <li class="nav-item <?php if($judul=='Laporan'){ echo'active'; } ?>">
        <a class="nav-link" href="data_laporan.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Report</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Setting
      </div>

      <?php 
      if ($user['user_role'] == "admin") {
        ?>
        <li class="nav-item <?php if($judul=='Manajemen User'){ echo'active'; } ?>">
          <a class="nav-link" href="data_user.php">
            <i class="fas fa-users"></i>
            <span>User Management</span>
          </a>
        </li>
        <li class="nav-item <?php if($judul=='Setting Web'){ echo'active'; } ?>">
          <a class="nav-link" href="data_pengaturan.php">
            <i class="fas fa-cogs"></i>
            <span>Web Settings</span>
          </a>
        </li>
      <?php } ?>
      <li class="nav-item ">
        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt "></i>
          <span>Logout</span>
        </a>
      </li>
      <!-- <div class="version" id="version-ruangadmin"></div> -->
    </ul>

    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <img class="img-profile rounded-circle" src="../assets_back/img/boy.png" style="max-width: 60px">
              <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $user['user_nama']; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="data_profile.php">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
              </a>
              <?php 
              if ($user['user_role'] == "admin") {
                ?>
                <a class="dropdown-item" href="data_pengaturan.php">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
              <?php } ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->