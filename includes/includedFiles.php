<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        include("config.php");
        include("classes/User.php");
        include("classes/Artist.php");
        include("classes/Album.php");
        include("classes/Song.php");
        include("classes/Playlist.php");

        if(isset($_GET['userLoggedIn'])) {
            $userLoggedIn = new User($con, $_GET['userLoggedIn']);
        } else {
            echo "Username variable was not passed into page. Check the openPage JS function";
            exit();
        }
    } else {
        include("header.php");
        include("footer.php");
        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url')</script>";
        exit();
    }
?>