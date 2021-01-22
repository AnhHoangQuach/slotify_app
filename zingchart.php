<section class="z-week-chart">
    <div class="container">
        <div class="sub-container z-widget">
            <div class="row">
                <div class="col-md-12">
                    <div class="z-chart-realtime-wrapper">
                        <div class="z-chart-realtime">
                            <div class="realtime-header">
                                <div class="pull-left">
                                    <a href="#" class="z-btn z-btn-zingchart">#zingchart</a>
                                    <span class="z-time-pick"><?php echo date("Y-m-d h:i:s") ?></span>
                                </div>
                                <div class="pull-right">
                                    <button onclick="playFirstSong()" href="" class="z-btn z-btn-shadow"> Nghe tất cả
                                        <i class="icon ic-play"></i>
                                    </button>
                                </div>
                            </div>
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="realtime-list-song">
                            <ul class="z-hor-chart-list">
                                <?php
                                    $query = mysqli_query($con, "SELECT * FROM songs ORDER BY plays DESC LIMIT 5");
                                    $i = 1;
                                    $songIdArray = [];
                                    while($row = mysqli_fetch_array($query)) {
                                        array_push($songIdArray, $row['id']);
                                        $song = new Song($con, $row['id']);
                                        $artist = $song->getArtist();
                                ?>
                                <li class="chart-item first active">
                                    <div class="z-card card-40 song-item">
                                        <div class="prefix">
                                            <div class="sort">
                                                <div class="sort-number">
                                                    <span><?php echo $i ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-40">
                                            <div class="image lazyload-img loaded">
                                                <img src="<?php echo $song->getImage() ?>" onclick="setTrack(<?php echo $song->getId() ?>, tempPlaylist, true);" alt="">
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <div class="title">
                                                <a><?php echo $song->getTitle() ?></a>
                                            </div>
                                            <div class="artist">
                                                <a>
                                                    <?php echo "
                                                        <span onclick='openPage(\"artist.php?id=" . $artist->getId() . "\");'>
                                                            " . $artist->getName() . "
                                                        </span>";
                                                    ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++; } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row week-chart mar-top-20">
                <div class="col-md-12">
                    <div class="row">
                        <?php 
                            $query = mysqli_query($con, "SELECT * FROM genres LIMIT 4");
                            while($rows = mysqli_fetch_array($query)) {
                                echo '
                                <div class="col-md-3 col-xs-6 mar-bottom-15">
                                    <span role="link" tabindex="0" onclick="openPage(\'title.php?id=' . $rows['id'] . '\');">
                                        <div class="card-210-118">
                                            <div class="lazyload-img loaded">
                                                <img src="' . $rows['image'] . '" alt="">
                                            </div>
                                        </div>
                                    </span>
                                </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        $query = mysqli_query($con, "SELECT * FROM songs ORDER BY plays DESC LIMIT 5");
        $data_plays = [];
        $data_name = [];
        foreach($query as $a) {
            $temp = intval($a['plays']);
            $string = $a['title'];
            array_push($data_plays, $temp);
            array_push($data_name, $string);
        }
    ?>
    <script>
        var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
        tempPlaylist = JSON.parse(tempSongIds);

        var ctx = document.getElementById('myChart').getContext('2d');
        var tempData = <?php echo json_encode($data_plays); ?>;
        var tempName = <?php echo json_encode($data_name); ?>;
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',
            // The data for our dataset
            data: {
                labels: [1,2,3,4,5],
                datasets: [
                    {
                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                        data: tempData,
                    }
                ]
            },

            // Configuration options go here
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 10,
                        }
                    }]
                },
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Top Bài Hát Hay Nhất',
                    fontColor: '#fff',
                }
            }
        });
    </script>
</section>