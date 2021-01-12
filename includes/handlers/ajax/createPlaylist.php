<?php
    include("../../config.php");
    if(isset($_POST['name']) && isset($_POST['username'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $date = date("Y-m-d");

        $check = mysqli_query($con, "SELECT id FROM users WHERE username='$username'");
        $check_id = mysqli_fetch_array($check);
        $userId = $check_id['id'];

        $query = mysqli_query($con, "INSERT INTO playlists VALUES('', '$name', $userId, '$date')");
    } else {
        echo "Name or username parameters not passed into file";
    }
?>