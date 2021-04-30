<?php include("includes/includedFiles.php");
    if(isset($_GET['id'])) {
        $playlistId = $_GET['id'];
    } else {
        header('Location: index.php');
    }
    $playlist = new Playlist($con, $playlistId);
    $temp = intval($playlist->getUser());
    $query = mysqli_query($con, "SELECT username FROM users WHERE id=$temp");
    $row = mysqli_fetch_array($query);
    $owner = new User($con, $row['username']);
?>

    <div class="container">
        <div class="entityInfo">
            <div class="leftSection">
                <div class="playlistImage">
                    <img src="/slotify_app/assets/images/icons/playlist.png" alt="">
                </div>
            </div>
            <div class="rightSection">
                <h2><?php echo $playlist->getName(); ?></h2>
                <span>By <?php echo $owner->getUsername(); ?></span>
                <span class="rightSection__number-songs"><?php echo $playlist->getNumberOfSongs(); ?> songs</span>
                <button class="button" onclick="deletePlaylist(<?php echo $playlistId; ?>);">DELETE PLAYLIST</button>
            </div>
        </div>

        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $songIdArray = $playlist->getSongIds();
                    $i = 1;
                    foreach($songIdArray as $songId) {
                        $playlistSong = new Song($con, $songId);
                        $songArtist = $playlistSong->getArtist();
                        echo "<li class='tracklistRow'>
                                <div class='trackCount'>
                                    <img class='play' src='/slotify_app/assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true);'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                    <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                                    <span class='artistName'>" . $songArtist->getName() . "</span>
                                </div>

                                <div class='trackOptions'>
                                    <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                                    <img class='optionsButton' src='/slotify_app/assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                                </div>

                                <div class='trackDuration'>
                                    <span class='duration'>" . $playlistSong->getDuration() . "</span>
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

        <nav class="optionsMenu">
            <input type="hidden" name="" class="songId">
            <input type="hidden" name="" class="songId">
            <?php
                $temp = $userLoggedIn->getUsername();
                $query = mysqli_query($con, "SELECT id FROM users WHERE username='$temp'");
                $row = mysqli_fetch_array($query);
                echo Playlist::getPlaylistsDropdown($con, $row['id']); 
            ?>
            <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from Playlist</div>
        </nav>
    </div>
    <?php 
        include("nowPlayingBar.php");
    ?>