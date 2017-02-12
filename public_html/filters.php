<?php include_once('../init.php');

	if(isset($_SESSION["sort"])) {
		unset($_SESSION['sort']);
		redirect("index.php"); 
	} else { redirect("index.php"); }
?>