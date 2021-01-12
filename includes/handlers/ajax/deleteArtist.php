<?php
    include("../../config.php");
    if(isset($_POST['artistId'])) {
        $artistId = $_POST['artistId'];
        $artistIdQuery = mysqli_query($con, "DELETE FROM artists WHERE id='$artistId'");
    } else {
        echo "artistId not was passed into deleteArtist.php";
    }
?>