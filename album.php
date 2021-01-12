<?php include("includes/includedFiles.php");
    if(isset($_GET['id'])) {
        $albumId = $_GET['id'];
    } else {
        header('Location: index.php');
    }

    $album = new Album($con, $albumId);

    $artist = $album->getArtist();
    $userId = intval($userLoggedIn->getId());
?>

    <div class="container">
        <div class="entityInfo">
            <div class="leftSection">
                <img src="/<?php echo $album->getArtworkPath(); ?>" alt="">
            </div>
            <div class="rightSection">
                <h2><?php echo $album->getTitle(); ?></h2>
                <span>By <?php echo $artist->getName(); ?></span>
                <span class="rightSection__number-songs"><?php echo $album->getNumberOfSongs(); ?> songs</span>
            </div>
        </div>

        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $songIdArray = $album->getSongIds();
                    $i = 1;
                    foreach($songIdArray as $songId) {
                        $albumSong = new Song($con, $songId);
                        $name = explode("/", $albumSong->getPath());
                        $albumArtist = $albumSong->getArtist();
                        echo "<li class='tracklistRow'>
                                <div class='trackCount'>
                                    <img class='play' src='/assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true);'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                    <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                    <span class='artistName'>" . $albumArtist->getName() . "</span>
                                </div>

                                <div class='trackOptions'>
                                    <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                    <img class='optionsButton' src='/assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                                    <a href='includes/handlers/ajax/download.php?file=" . $name[2] . "'><img src='/assets/images/icons/download.png'></a>
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

        <nav class="optionsMenu">
            <input type="hidden" name="" class="songId">
            <?php 
                $temp = $userLoggedIn->getUsername();
                $query = mysqli_query($con, "SELECT id FROM users WHERE username='$temp'");
                $row = mysqli_fetch_array($query);
            ?>
            <?php echo Playlist::getPlaylistsDropdown($con, intval($row['id'])); ?>
        </nav>

        <div class="comment">
            <h2>Comments</h2>
            <?php
                $query_comment = mysqli_query($con, "SELECT * FROM comments WHERE album=$albumId");
                while($row = mysqli_fetch_array($query_comment)) {
                    $user_id = intval($row['user']);
                    $temp = mysqli_query($con, "SELECT * FROM users WHERE id=$user_id");
                    $username = mysqli_fetch_array($temp);
            ?>
            <div class="row single-comment">
                <div class="col-md-2">
                    <img src="/assets/images/profile-pics/head_emerald.png" class="img-circle">
                </div>
                <div class="col-md-10">
                    <h4><?php echo $username['username'] ?></h4>
                    <p><?php echo $row['comment'] ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
        
        <div class="comment-box">
            <div class="row">
                <div class="col-md-12">
                    <form action="includes/handlers/ajax/createComment.php" method="POST">
                        <div class="form-group">
                            <textarea id="comment" name="comment" cols="30" rows="10" class="form-control" placeholder="Your comment should be here"></textarea>
                        </div>
                        <input type='hidden' name="userId" value='<?php echo $userId ?>'>
                        <input type='hidden' name="albumId" value='<?php echo $album->getId(); ?>'>
                        <button type="submit" name="submit" value="submit" class="button-comment">Gửi comment</button>
                    </form>
                </div>
            </div>
        </div>
        <?php 
            include("includes/footer.php")
        ?>
    </div>
