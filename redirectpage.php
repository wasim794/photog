<?php
// Start the session
session_start();
$_SESSION['id']=$_GET['id'];
header('location: subcategories/subcategories');
?>