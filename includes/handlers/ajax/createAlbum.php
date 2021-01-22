<?php
    include("../../config.php");
    if(isset($_POST['create'])) {
        $dir = __DIR__ . '/../../../assets/images/artwork/';
		$audio_path = $dir . '/' .$_FILES['audioFile']['name']; // duong that
		$dirTemp = '/assets/images/artwork/';
        $audio_duration_path = $dirTemp . basename($_FILES['audioFile']['name']); // duong ao
        if($audio_duration_path == $dirTemp) {
			$audio_duration_path = 'assets/images/listmusic/logoicon.jpg';
		}
		$title = $_POST['title'];
		$artist = $_POST['artist'];
        $genre = $_POST['genre'];

        $sql = "INSERT INTO `albums` VALUES ('', '$title', $artist, $genre, '$audio_duration_path')";
        $query = mysqli_query($con, $sql);
		if($query == true) {
			if(move_uploaded_file($_FILES['audioFile']['tmp_name'], $audio_path)) {
				echo 'Uploaded successfully';
			} else {
                echo 'Failed';
            }
        }
        
        header("Location: ../../admin/listAlbums.php");
    } else {
        echo "Parameters not passed into file";
    }
?>