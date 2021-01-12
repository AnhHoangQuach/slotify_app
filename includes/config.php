<?php
	ob_start();
	if(!isset($_SESSION)) 
    { 
        session_start();
    }

	$timezone = date_default_timezone_set("Asia/Saigon");

	$con = mysqli_connect("localhost", "root", "", "slotify");

	if(mysqli_connect_errno()) {
		echo "Failed to connect: " . mysqli_connect_errno();
	}
?>