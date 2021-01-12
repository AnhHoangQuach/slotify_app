<?php
	include("../../config.php");
	
	if(isset($_POST['update'])){
		$song_id = $_POST['song_id'];
		$title = $_POST['title'];
		$artist = $_POST['artist'];
		$album = $_POST['album'];
		
		mysqli_query($con, "UPDATE songs SET title='$title', artist='$artist', album='$album' WHERE id='$song_id'") or die(mysqli_error());

		header("Location: ../../../admin/listSongs.php");
	}
?>