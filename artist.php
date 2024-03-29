<?php
    include("includes/includedFiles.php");
    if(isset($_GET['id'])) {
        $artistId = $_GET['id'];
    } else {
        header('Location: index.php');
    }

    $artist = new Artist($con, $artistId);
?>

<div class="container">
    <div class="entityInfo">
        <div class="leftSection">
            <div class="artistInfo">
                <h1 class="artistName">
                    <?php echo $artist->getName(); ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="tracklistContainer">
        <h2>SONGS</h2>
        <ul class="tracklist">
            <?php
                $songIdArray = $artist->getSongIds();
                $i = 1;
                foreach($songIdArray as $songId) {
                    if($i > 5 ) {
                        break;
                    }

                    $albumSong = new Song($con, $songId);
                    $name = explode("/", $albumSong->getPath());
                    $albumArtist = $albumSong->getArtist();
                    echo "<li class='tracklistRow'>
                            <div class='trackCount'>
                                <img class='play' src='/slotify_app/assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true);'>
                                <span class='trackNumber'>$i</span>
                            </div>

                            <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                <span class='artistName'>" . $albumArtist->getName() . "</span>
                            </div>

                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img class='optionsButton' src='/slotify_app/assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                                <a href='/slotify_app/includes/handlers/ajax/download.php?file=" . $name[2] . "'><img src='/slotify_app/assets/images/icons/download.png'></a>
                            </div>

                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>
                            </div>
                        </li>
                    ";
                    $i++;
                }
            ?>
            <script>
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
            </script>
        </ul>
    </div>

    <div class="gridViewContainer">
        <h2 class="text-center">ALBUMS</h2>
        <?php 
            $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");
            while($row = mysqli_fetch_array($albumQuery)) {
                

                echo "<div class='gridViewItem  artist-album'>
                        <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\");'>
                            <img src='" . $row['artworkPath'] . "'>
                            <div class='gridViewInfo'>
                                " . $row['title'] . "
                            </div>
                        </span>
                    </div>";
            }
        ?>
    </div>

    <nav class="optionsMenu">
        <input type="hidden" name="" class="songId">
        <?php
            $temp = $userLoggedIn->getUsername();
            $query = mysqli_query($con, "SELECT id FROM users WHERE username='$temp'");
            $row = mysqli_fetch_array($query);
            echo Playlist::getPlaylistsDropdown($con, $row['id']); 
        ?>
    </nav>
    <?php 
        include("includes/footer.php");
    ?>
    <?php include("nowPlayingBar.php"); ?>
</div>