<?php
	include("../../config.php");
	
	if(isset($_POST['update'])){
		$album_id = $_POST['album_id'];
		$artist = $_POST['artist'];
		$title = $_POST['title'];
		$genre = $_POST['genre'];
		
		mysqli_query($con, "UPDATE albums SET title='$title', artist='$artist', genre='$genre' WHERE id='$album_id'") or die(mysqli_error());

		header("Location: ../../../admin/listAlbums.php");
	}
?>