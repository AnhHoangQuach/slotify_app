<?php
    $songQuery = mysqli_query($con, "SELECT id FROM songs");
    $resultArray = array();

    while($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);
?>

<script>
    var item = localStorage.getItem('songNow');
    var statusChange = localStorage.getItem('statusChange');
    $(document).ready(function() {
        var newPlaylist = <?php echo $jsonArray; ?>;
        if(item == null) {
            audioElement = new Audio();
            setTrack(newPlaylist[0], newPlaylist, false);
            return;
        } else {
            if(statusChange == 1) {
                $('.controlButton.play').show();
                $('.controlButton.pause').hide();
            } else {
                $('.controlButton.pause').show();
                $('.controlButton.play').hide();
            }
            continueSong(item);
        }
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });

        // progressbar
        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e) {
            if(mouseDown == true) {
                timeFromOffset(e, this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function(e) {
            timeFromOffset(e, this);
        });

        // volume
        $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(e) {
            if(mouseDown == true) {
                var percentage = e.offsetX / $(this).width();

                if(percentage >=0 && percentage < 1) {
                    audioElement.audio.volume = percentage;
                }
            }
        });

        $(".volumeBar .progressBar").mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();
                
            if(percentage >=0 && percentage < 1) {
                audioElement.audio.volume = percentage;
            }
        });

        $(document).mouseup(function() {
		    mouseDown = false;
        });
    });

    function timeFromOffset (mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function prevSong() {
        if(audioElement.audio.currentTime >=3 || currentIndex == 0) {
            audioElement.setTime(0);
        } else {
            currentIndex--;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    function nextSong() {
        if(repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if(currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }

        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "/slotify_app/assets/images/icons/" + imageName);
    }

    function setMuted() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "/slotify_app/assets/images/icons/" + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "/slotify_app/assets/images/icons/" + imageName);

        if(shuffle == true) {
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        } else {
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
    }

    function shuffleArray(a) {
        var j, x, i;
        for (i = a.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = a[i];
            a[i] = a[j];
            a[j] = x;
        }
        return a;
    }

    function setTrack(trackId, newPlaylist, play) {
        if(newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }
        if(shuffle == true ) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }

        pauseSong();

        $.post("/slotify_app/includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {
            var track = JSON.parse(data);
            $(".trackName span").text(track.title);

            $.post("/slotify_app/includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) {
                var artist = JSON.parse(data);
                $(".trackInfo .artistName span").text(artist.name);
                $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
            });

            $.post("/slotify_app/includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
                var album = JSON.parse(data);
                $(".content .albumLink img").attr("src", album.artworkPath);
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");

            });
            audioElement.setTrack(track);
            if(play == true) {
                playSong();
            }
        });
    }

    function continueSong(trackId) {
        $.post("/slotify_app/includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {
            var track = JSON.parse(data);
            $(".trackName span").text(track.title);

            $.post("/slotify_app/includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) {
                var artist = JSON.parse(data);
                $(".trackInfo .artistName span").text(artist.name);
                $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
            });

            $.post("/slotify_app/includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
                var album = JSON.parse(data);
                $(".content .albumLink img").attr("src", album.artworkPath);
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            });
        });
    }

    function playSong() {
        if(audioElement.audio.currentTime == 0) {
            $.post("/slotify_app/includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id});
        }
        $('.controlButton.play').hide();
        $('.controlButton.pause').show();
        audioElement.play();
        localStorage.setItem("songNow", audioElement.currentlyPlaying.id)
        localStorage.setItem("statusChange", 2);
    }

    function pauseSong() {
        $('.controlButton.play').show();
        $('.controlButton.pause').hide();
        audioElement.pause();
        localStorage.setItem("statusChange", 1);
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role='link' tabindex='0' src="" alt="" class="albumArtwork">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span role='link' tabindex='0'></span>
                    </span>
                    <span class="artistName">
                        <span role='link' tabindex='0'></span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle();">
                        <img src="/slotify_app/assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous button" onclick="prevSong();">
                        <img src="/slotify_app/assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play" title="Play button" onclick="playSong();">
                        <img src="/slotify_app/assets/images/icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong();">
                        <img src="/slotify_app/assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next button" onclick="nextSong();">
                        <img src="/slotify_app/assets/images/icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat button" onclick="setRepeat();">
                        <img src="/slotify_app/assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume button" onclick="setMuted();">
                    <img src="/slotify_app/assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>