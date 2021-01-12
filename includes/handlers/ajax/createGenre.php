<?php
    include("../../config.php");
    if(isset($_POST['create'])) {
        $name = $_POST['name'];
        $dir = __DIR__ . '/../../../assets/images/artwork/';
		$audio_path = $dir . '/' .$_FILES['audioFile']['name']; // duong that
		$dirTemp = '/assets/images/artwork/';
        $audio_duration_path = $dirTemp . basename($_FILES['audioFile']['name']); // duong ao
        $query = mysqli_query($con, "INSERT INTO `genres` VALUES ('', '$name', '$audio_duration_path')");
        if($query == true) {
			if(move_uploaded_file($_FILES['audioFile']['tmp_name'], $audio_path)) {
				echo 'Uploaded successfully';
			} else {
                echo 'Failed';
            }
        }
        header("Location: ../../../admin/listGenres.php");
    } else {
        echo "Name parameters not passed into file";
    }
?>