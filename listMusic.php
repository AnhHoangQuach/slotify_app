<?php 
    $query = mysqli_query($con, "SELECT albums.* , SUM(plays) AS Plays
    FROM albums INNER JOIN songs on albums.id = songs.album
    GROUP BY albums.id
    HAVING SUM(plays) >= ANY(SELECT sum(plays)
                             FROM albums,songs
                             WHERE albums.id = songs.album
                             GROUP BY albums.id 
                             )   
    ORDER BY Plays DESC
    LIMIT 5");
?>
<section class="z-recently-listen">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="z-float-header" style="margin: 20px 0;">
                    <div class="z-box-title z-show">Top Album</div>
                </div>
                <div class="box-slide album-slider">
                    <div class="album-list">
                        <?php 
                            while($row = mysqli_fetch_array($query)) {
                                $album = new Album($con, $row['id']);
                        ?>
                        <div class="z-album-item">
                            <div class="col-album">
                                <div class="card-190 z-reset-height">
                                        <div class="image">
                                            <img class="top_album_image" src="<?php echo $album->getArtworkPath() ?>" alt=""  onclick="openPage('album.php?id=<?php echo $album->getId() ?>'); window.location.reload();">
                                        </div>
                                    </div>
                                <div class="card-info">
                                    <div class="title text-center mb-4">
                                        <?php echo $album->getTitle() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>