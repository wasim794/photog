<?php
// Start the session
session_start();
$_SESSION['id']=$_GET['id'];
header('location: gallery/grid/col-2-wide/');
?>