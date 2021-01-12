<?php
	include("../../config.php");
	
	if(isset($_POST['update'])){
		$artist_id = $_POST['artist_id'];
		$name = $_POST['name'];
		
		mysqli_query($con, "UPDATE artists SET name='$name' WHERE id='$artist_id'") or die(mysqli_error());

		header("Location: ../../../admin/listArtists.php");
	}
?>