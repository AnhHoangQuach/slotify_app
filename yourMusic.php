<?php
    include("includes/includedFiles.php");
?>

<div class="container">
    <div class="playlistsContainer">
        <div class="gridViewContainer">
            <div class="buttonItems text-center">
                <button class="button green" onclick="createPlaylist();">NEW PLAYLISTS</button>
            </div>

            <?php
                $userId = $userLoggedIn->getId();
                $playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE user='$userId'");
                if(mysqli_num_rows($playlistsQuery) == 0) {
                    echo "<span class='noResults'>You don't have any playlists yet. </span>";
                }

                while($row = mysqli_fetch_array($playlistsQuery)) {
                    $playlist = new Playlist($con, $row);    
                
                    echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                            <div class='playlistImage'>
                                <img src='/assets/images/icons/playlist.png'>
                            </div>
                            <div class='gridViewInfo'>
                                " . $playlist->getName() . "
                            </div>
                        </div>";
                }
            ?>
        </div>
    </div>
</div>