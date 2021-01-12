<?php
	include("../../config.php");
	
	if(isset($_POST['update'])){
		$user_id = $_POST['user_id'];
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		
		mysqli_query($con, "UPDATE users SET fullname='$fullname', email='$email' WHERE id='$user_id'") or die(mysqli_error());

		header("Location: ../../../admin/listUser.php");
	}
?>