<?php
// Start the session
session_start();
$_SESSION['id']=$_GET['id'];
$_SESSION['catname'] = $_GET['catname'];
header('location: https://localhost/photog/'.$_SESSION['catname']);
?>