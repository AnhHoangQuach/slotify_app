<?php
    include("../../config.php");
    if(isset($_POST['userId'])) {
        $userId = $_POST['userId'];
        $userIdQuery = mysqli_query($con, "DELETE FROM users WHERE id='$userId'");
    } else {
        echo "userId not was passed into deleteUser.php";
    }
?>