<?php 
    include("../../config.php");
?>
<?php
    $albumId = $_POST['albumId'];
    $userId = $_POST['userId'];
    $cs_comment = $_POST['comment'];
    $cs_date = time();
    $cs_query = "INSERT INTO `comments` VALUES ('', '$cs_comment', $albumId, '$cs_date', $userId)";
    if(mysqli_query($con, $cs_query)) {
        header("Location: ../../../album.php?id={$albumId}");
    }
?>