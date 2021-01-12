<?php include("includes/includedFiles.php");
    if(isset($_GET['id'])) {
        $genre = $_GET['id'];
    } else {
        header('Location: index.php');
    }

    $genreId = intval($genre);
    $genre = mysqli_query($con, "SELECT * FROM genres WHERE id=$genreId");
    $genre_info = mysqli_fetch_array($genre);
    $listSongs = mysqli_query($con, "SELECT * FROM songs WHERE genre=$genreId");
    $numberOfSongs = mysqli_num_rows($listSongs);
?>

    <div class="container">
        <div class="entityInfo">
            <div class="rightSectionGenre">
                <h2><?php echo $genre_info['name'] ?></h2>
                <span class="rightSection__number-songs"><?php echo $numberOfSongs ?> songs</span>
            </div>
        </div>

        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $i = 1;
                    foreach($listSongs as $song) {
                        $genreSong = new Song($con, $song['id']);
                        $name = explode("/", $song['path']);
                        $songArtist = $genreSong->getArtist();
                        echo "<li class='tracklistRow'>
                                <div class='trackCount'>
                                    <img class='play' src='/assets/images/icons/play-white.png' onclick='setTrack(\"" . $genreSong->getId() . "\", tempPlaylist, true);'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                    <span class='trackName'>" . $genreSong->getTitle() . "</span>
                                    <span class='artistName'>" . $songArtist->getName() . "</span>
                                </div>

                                <div class='trackOptions'>
                                    <input type='hidden' class='songId' value='" . $genreSong->getId() . "'>
                                    <img class='optionsButton' src='/assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                                    <a href='includes/handlers/ajax/download.php?file=" . $name[2] . "'><img src='/assets/images/icons/download.png'></a>
                                </div>

                                <div class='trackDuration'>
                                    <span class='duration'>" . $genreSong->getDuration() . "</span>
                                </div>
                            </li>
                        ";
                        $i++;
                    }
                ?>
            </ul>
        </div>

        <nav class="optionsMenu">
            <input type="hidden" name="" class="songId">
            <?php 
                $temp = $userLoggedIn->getUsername();
                $query = mysqli_query($con, "SELECT id FROM users WHERE username='$temp'");
                $row = mysqli_fetch_array($query);
            ?>
            <?php echo Playlist::getPlaylistsDropdown($con, intval($row['id'])); ?>
        </nav>
        <?php 
            include("includes/footer.php")
        ?>
    </div>