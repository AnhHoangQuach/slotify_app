<?php
    include("../../config.php");
    if(isset($_POST['genreId'])) {
        $genreId = $_POST['genreId'];
        $genreIdQuery = mysqli_query($con, "DELETE FROM genres WHERE id='$genreId'");
    } else {
        echo "genreId not was passed into deleteGenre.php";
    }
?>