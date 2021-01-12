<?php
    include("../../config.php");
    if(isset($_POST['albumId'])) {
        $albumId = $_POST['albumId'];
        $albumIdQuery = mysqli_query($con, "DELETE FROM albums WHERE id='$albumId'");
    } else {
        echo "albumId not was passed into deleteAlbum.php";
    }
?>