var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;
$(document).click(function(click) {
    var target = $(click.target);
    if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

$(window).scroll(function() {
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();
    $.post("../includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId })
        .done(function(error) {
            if (error != "") {
                alert(error);
                return;
            }
            hideOptionsMenu();
            select.val("");

        })
})

function openPage(url) {
    if (timer != null) {
        clearTimeout(timer);
    }

    if (url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);

    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".songId").val();
    $.post("../includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
        .done(function(error) {
            if (error != "") {
                alert(error);
                return;
            }
            openPage("playlist.php?id=" + playlistId);
        });
}

function createPlaylist() {
    var popup = prompt("Please enter the name of your playlist");
    if (popup != null) {
        $.post("../includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("./yourMusic.php");
            });
    }
}

function logout() {
    $.post("../includes/handlers/ajax/logout.php", function() {
        location.reload();
    })
}

function updateEmail(emailClass) {
    var emailValue = $("." + emailClass).val();

    $.post("../includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn })
        .done(function(response) {
            $("." + emailClass).nextAll(".message").text(response);
        })
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("../includes/handlers/ajax/updatePassword.php", {
            oldPassword: oldPassword,
            newPassword1: newPassword1,
            newPassword2: newPassword2,
            username: userLoggedIn
        })
        .done(function(response) {
            $("." + oldPasswordClass).nextAll(".message").text(response);
        })
}

function deletePlaylist(playlistId) {
    var prompt = confirm("Are you sure you want to delete this playlist?");
    if (prompt == true) {
        $.post("../includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("yourMusic.php");
            });
    }
}

function deleteAlbum(albumId) {
    var prompt = confirm("Are you sure you want to delete this album?");
    if (prompt == true) {
        $.post("../includes/handlers/ajax/deleteAlbum.php", { albumId: albumId })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("./listAlbums.php");
                location.reload();
            });
    }
}

function deleteSong(songId) {
    var prompt = confirm("Are you sure you want to delete this song?");
    if (prompt == true) {
        $.post("../includes/handlers/ajax/deleteSong.php", { songId: songId })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("./listSongs.php");
                location.reload();
            });
    }
}

function deleteGenre(genreId) {
    var prompt = confirm("Are you sure you want to delete this song?");
    if (prompt == true) {
        $.post("../includes/handlers/ajax/deleteGenre.php", { genreId: genreId })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("./listGenres.php");
                location.reload();
            });
    }
}

function deleteArtist(artistId) {
    var prompt = confirm("Are you sure you want to delete this artist?");
    if (prompt == true) {
        $.post("../includes/handlers/ajax/deleteArtist.php", { artistId: artistId })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("./listArtists.php");
                location.reload();
            });
    }
}

function deleteUser(userId) {
    var prompt = confirm("Are you sure you want to delete this user?");
    if (prompt == true) {
        $.post("../includes/handlers/ajax/deleteUser.php", { userId: userId })
            .done(function(error) {
                if (error != "") {
                    alert(error);
                    return;
                }
                openPage("./listUser.php");
                location.reload();
            });
    }
}

function hideOptionsMenu() {
    var menu = $('.optionsMenu');
    if (menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showOptionsMenu(button) {
    var songId = $(button).prevAll(".songId").val();
    var menu = $('.optionsMenu');
    var menuWidth = menu.width();

    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop(); // distance from top of window to top of element
    var elementOffset = $(button).offset().top; // distance from top of document

    var top = elementOffset - scrollTop;

    menu.css({ "top": top + "px", "right": 315 + "px", "display": "block" });
}

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : "";
    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}


function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}


function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function() {
        nextSong();
    });

    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration)
        $(".progressTime.remaining").text(duration);
    })

    this.audio.addEventListener("timeupdate", function() {
        if (this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    })

    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        var playPromise = this.audio.play();
        if (playPromise !== undefined) {
            playPromise.then(_ => {

            })
            .catch(error => {
                console.log("Error");
            });
        }
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}