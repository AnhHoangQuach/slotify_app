<?php 
	include("../../config.php");

	function getDuration($file){
        if (file_exists($file)){
            ## open and read video file
            $handle = fopen($file, "r");

            ## read video file size
            $contents = fread($handle, filesize($file));
            fclose($handle);
            $make_hexa = hexdec(bin2hex(substr($contents,strlen($contents)-3)));
			$pre_duration = hexdec(bin2hex(substr($contents,strlen($contents)-$make_hexa,3))) ;
			$post_duration = $pre_duration/1000;
			$timehours = $post_duration/3600;
			$timeminutes =($post_duration % 3600)/60;
			$timeseconds = ($post_duration % 3600) % 60;
			$timehours = explode(".", $timehours);
			$timeminutes = explode(".", $timeminutes);
			$timeseconds = explode(".", $timeseconds);
			$duration = rand(3,5).":".str_pad(rand(0,59), 2, "0", STR_PAD_LEFT);
            return $duration;
		} else {
			return false;
		}
	}

	if(isset($_POST['submit']) && $_POST['submit'] == "Upload") {

		// audio song
		$dir =  '../../../assets/music';
		$audio_path = $dir . '/' .$_FILES['audioFile']['name']; // duong that
		$dirTemp = 'assets/music/';
		$audio_duration_path = $dirTemp . basename($_FILES['audioFile']['name']); // duong ao
		$title = $_POST['title'];
		$artist = $_POST['artist'];
		$album = $_POST['album'];
		$genre = $_POST['genre'];
		$duration = getDuration($audio_path) ? getDuration($audio_path) : rand(3,5).":".str_pad(rand(0,59), 2, "0", STR_PAD_LEFT);


		// image song
		$dir = '../../../assets/images/listmusic/';
		$image_path = $dir . '/' .$_FILES['imageFile']['name']; // duong that
		$dirTemp = 'assets/images/listmusic/';
		$image_duration_path = $dirTemp . basename($_FILES['imageFile']['name']); // duong ao
		if($image_duration_path == $dirTemp) {
			$image_duration_path = 'assets/images/listmusic/logoicon.jpg';
		}
		// query

		$sql = "INSERT INTO `songs` VALUES ('', '$title', '$artist', '$album', '$genre', '$duration', '$audio_duration_path', '$image_duration_path', 0)";
		$query = mysqli_query($con, $sql);
		if($query == true) {
			if(move_uploaded_file($_FILES['audioFile']['tmp_name'], $audio_path) && move_uploaded_file($_FILES['imageFile']['tmp_name'], $image_path)) {
				echo 'Uploaded successfully';
			}
		}

		header("Location: ../../../admin/listSongs.php");
	}  else {
        echo "Fill fields or field not valid";
    }
?>