<?php
	include("../../config.php");
	
	if(isset($_POST['update'])){
		$genre_id = $_POST['genre_id'];
		$name = $_POST['name'];
		
		mysqli_query($con, "UPDATE genres SET name='$name' WHERE id='$genre_id'") or die(mysqli_error());

		header("Location: ../../../admin/listGenres.php");
	}
?>