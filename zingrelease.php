<div class="container new-release-slider channel-section mar-t-30">
    <h2 class="title">Đánh giá</h2>
</div>

<div class="zm-carousel">
    <div class="zm-carousel-item">
        <?php
            $i = 1;
            $query = mysqli_query($con, "SELECT albums.* , COUNT(comments.id) AS TongComment FROM albums INNER JOIN comments on albums.id = comments.album GROUP BY albums.id HAVING COUNT(comments.id) >= ANY(SELECT COUNT(comments.id) FROM albums,comments WHERE albums.id = comments.album GROUP BY albums.id ) ORDER BY TongComment DESC LIMIT 3");
            while($row = mysqli_fetch_array($query)) {
                $album = new Album($con, $row['id']);
                $artist = new Artist($con, $album->getArtistId());
        ?>
        <div class="column mar-b-0 item-width">
            <div class="new-release-item">
                <div class="media">
                <span role='link' tabindex='0' onclick='openPage("album.php?id=<?php echo $album->getId() ?>"); window.location.reload();';>
                    <div class="media-left">
                        <figure class="image is-120x120" title="<?php echo $album->getTitle() ?>" onclick='openPage("album.php?id=<?php echo $album->getId() ?>")'>
                            <img src="<?php echo $album->getArtworkPath() ?>" alt="">
                        </figure>       
                    </div>
                </span>
                    <div class="media-content">
                        <div class="title-wrapper">
                            <span class="item-title title" title="<?php echo $album->getTitle() ?>">
                                <?php echo $album->getTitle() ?>
                            </span>
                        </div>
                        <h3 class="is-one-line subtitle">
                            <a class="">
                                <?php echo "
                                    <span onclick='openPage(\"artist.php?id=" . $artist->getId() . "\"); window.location.reload();'>
                                        " . $artist->getName() . "
                                    </span>";
                                ?>
                            </a>
                        </h3>
                        <div>
                            <span class="order">#<?php echo $i ?></span>
                            <span class="release-date"><?php echo $row['TongComment'] ?>
                                <img src="/assets/images/icons/comment.png"> 
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; } ?>
    </div>
</div>

<div class="container home-song-list channel-section mar-t-30">
    <div class="columns is-multiline text-center">
        <?php 
            $result = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 9");
            while($row = mysqli_fetch_array($result)) {
                $song = new Song($con, $row['id']);
                $artist = $song->getArtist();
        ?>
        <div class="col-md-4">
            <div class="list">
                <div class="list-item hide-right media-item full-left">
                    <div class="media">
                        <div class="media-left">
                            <div class="song-thumb">
                                <div class="image is-40x40">
                                    <img src="<?php echo $song->getImage() ?>" onclick="setTrack(<?php echo $song->getId() ?>, tempPlaylist, true);" alt="">
                                </div>
                                <div class="opacity"></div>
                            </div>
                            <div class="card-info">
                                <div class="title-wrapper">
                                    <span class="item-title title" title="<?php echo $song->getTitle() ?>"><?php echo $song->getTitle() ?></span>
                                </div>
                                <h3 class="is-one-line subtitle">
                                    <a class="" onclick='openPage("artist.php?id=<?php echo $artist->getId() ?>")'><?php echo $artist->getName() ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="container new-release-slider channel-section mar-t-30">
    <h2 class="title">Thành Viên</h2>
    <div class="member-info">
        <div class="staff-item text-center">
            <div class="image-wrapper">
                <img src="/assets/images/members/hoanganh.png" alt="" class="img-member">
            </div>
            <p class="name">Quách Hoàng Anh</p>
            <p class="position">IT Engineer</p>
        </div>
        <div class="staff-item text-center">
            <div class="image-wrapper">
                <img src="/assets/images/members/ngan.jpg" alt="" class="img-member">
            </div>
            <p class="name">Đinh Thị Ngân</p>
            <p class="position">IT Engineer</p>
        </div>
        <div class="staff-item text-center">
            <div class="image-wrapper">
                <img src="/assets/images/members/hoang.jpg" alt="" class="img-member">
            </div>
            <p class="name">Vũ Nguyễn Việt Hoàng</p>
            <p class="position">IT Engineer</p>
        </div>
    </div>
</div>

