<?php
session_start();
session_destroy();
$error = "logout";
header("location:../auth_admin.php");
?>