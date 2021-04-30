<?php 
	include("../../config.php");
	if(!empty($_POST['title']) && !empty($_POST['artist']) && !empty($_POST['album']) && !empty($_POST['genre'])) {
		$title = $_POST['title'];
		$artist = $_POST['artist'];
		$album = $_POST['album'];
		$genre = $_POST['genre'];
		$image_path = $_POST['image_path'];
		$audio_path = $_POST['audio_path'];
		$duration = rand(3,5).":".str_pad(rand(0,59), 2, "0", STR_PAD_LEFT);
		if ($image_path == "") {
			$image_path = 'assets/images/listmusic/logoicon.jpg';
		}

		// query

		$sql = "INSERT INTO `songs` VALUES ('', '$title', '$artist', '$album', '$genre', '$duration', '$audio_path', '$image_path', 0)";
		$query = mysqli_query($con, $sql);
	}  else {
        echo "Fill fields or field not valid";
    }
?>