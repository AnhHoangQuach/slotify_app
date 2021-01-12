<?php
    include("../../config.php");
    if(isset($_POST['songId'])) {
        $songId = $_POST['songId'];
        $songIdQuery = mysqli_query($con, "DELETE FROM songs WHERE id='$songId'");
    } else {
        echo "songId not was passed into deleteSong.php";
    }
?>