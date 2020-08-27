<?php
    include("../../config.php");
    if(isset($_POST['playlistId'])) {
        $playlistId = $_POST['playlistId'];
        $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistId'");
        $songQuery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistid='$playlistId'");
    } else {
        echo "PlaylistId not was passed into deletePlaylist.php";
    }
?>