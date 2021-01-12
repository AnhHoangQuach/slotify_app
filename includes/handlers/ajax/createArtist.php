<?php
    include("../../config.php");
    if(isset($_POST['create'])) {
        $name = $_POST['name'];
        $query = mysqli_query($con, "INSERT INTO `artists` VALUES ('', '$name')");

        header("Location: ../../../admin/listArtists.php");
    } else {
        echo "Name parameters not passed into file";
    }
?>