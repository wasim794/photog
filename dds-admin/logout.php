<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
	} else if(isset($_SESSION['user'])!="") {
		header("Location: dashboard.php");
	}
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['user']);
		header("Location: index.php");
		exit;
	}