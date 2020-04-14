<?php
	session_start();
	if(!isset($_SESSION['username']) AND !isset($_SESSION['nama'])){
		header("Location:./index.php");
	}
?>