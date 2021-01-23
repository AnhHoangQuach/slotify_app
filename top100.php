<?php
    include("includes/includedFiles.php");
?>
<head>
    <link rel="stylesheet" href="../assets/css/adminlte.min.css">
    <style>
        .progress {
            background-color: #a0a0a0;
            height: 4px;
            border-radius: 2px;
        }
    </style>
</head>
<?php
    // pagination

    $result = mysqli_query($con, 'select count(*) as total from songs');
    $row = mysqli_fetch_array($result);
    $total_records = $row['total'];
    
    //TÌM LIMIT VÀ CURRENT_PAGE
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 10;
    
    // tổng số trang
    $total_page = ceil($total_records / $limit);
    
    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_page > $total_page){
        $current_page = $total_page;
    }
    else if ($current_page < 1){
        $current_page = 1;
    }
    
    // Tìm Start
    $start = ($current_page - 1) * $limit;
    if(!isset($_GET['sort'])) {
        $sort = "ASC";
    } else if ($_GET['sort'] == "desc") {
        $sort = "DESC";
    } else {
        $sort = "ASC";
    }
    
    $result = mysqli_query($con, "SELECT * FROM songs ORDER BY id $sort LIMIT $start, $limit");
?>
<div class="container">
    <div class="tile_box_key">
        <h1>TOP 100 VIỆT NAM</h1>
    </div>
    <div class="descriptionBXH">
        TOP 100 là danh sách 100 bài hát hot nhất thuộc các thể loại nhạc được nghe nhiều nhất trên NAH05. Danh sách bài hát này được hệ thống tự động đề xuất dựa trên lượt nghe, lượt share v.v của từng bài hát trên tất cả các nền tảng (Web, Mobile web, App). Top 100 sẽ được cập nhật mỗi ngày dựa trên các chỉ số có được từ ngày đó. <br> <br>
        <span>* TOP 100 vừa được cập nhật vào: <b><?php echo date('d-m-Y h:i:s'); ?></b></span>
    </div>
    <div class="list-chart-page">
        <div class="box_view_week"> 
            <h2>100 ca khúc 
                <b>Nhạc Trẻ</b> 
                hay nhất trên NAH05</h2>
            <a href="top100.php?sort=desc" id="sortBtn" title="Giảm danh sách">
                <img src="/assets/images/icons/desc.jpg" class="desc_btn_sort">
            </a>
            <a href="top100.php?sort=asc" id="sortBtn" title="Tăng danh sách">
                <img src="/assets/images/icons/asc.jpg" class="asc_btn_sort">
            </a>
            <button class="active_play" title="Nghe toàn bộ">
                <img src="/assets/images/icons/play-white.png" class="icon_playall" onclick="playFirstSong()">Nghe toàn bộ
            </button>
        </div>
        <div class="box-resource-slide">
            <ul class="list-show-chart">
                <?php
                    $songIdArray = [];
                    while($row_query = mysqli_fetch_array($result)) {
                        $song = new Song($con, $row_query['id']);
                        array_push($songIdArray, $row_query['id']);
                        $name = explode("/", $song->getPath());
                        $temp = intval($song->getId());
                        $artist = $song->getArtist();
                        echo "<li>
                        <span class='chart-tw " . (($temp == 1) ? 'special-1' :  (($song->getId() == 2) ? 'special-2' : (($song->getId() == 3) ? 'special-3' : '')))  . "'>" . $song->getId() . "</span>                                
                        <div class='box-field-info'>
                            <div class='box-image'>
                                <img class='is-60x60' src='../" . $song->getImage() . "' alt=''>
                            </div>
                            <div class='box-text-info'>
                                <div class='box-title-music'>" . $song->getTitle() . "</div>
                                <span onclick='openPage(\"artist.php?id=" . $artist->getId() . "\");' class='box-artist'>" . $artist->getName() . "</span>
                            </div>
                            <div class='box-play'>
                                <a href='includes/handlers/ajax/download.php?file=" . $name[2] . "'><img class='download-button' src='/assets/images/icons/download.png'></a>
                                <img class='box-play-button' src='/assets/images/icons/play-white.png' onclick='setTrack(\"" . $song->getId() . "\", tempPlaylist, true);'>
                            </div>
                        </div>
                        </li>";
                    }
               ?>
            </ul>
        </div>
    </div>
    <div class="pagination-songs">
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                Showing 1 to 10 of <?php echo $total_records ?> entries 
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                    <ul class="pagination">
                        <?php 
                            if ($current_page > 1 && $total_page > 1){
                                echo '
                                <li class="paginate_button page-item previous" id="example2_previous">
                                    <span class="page-link" onclick=openPage("top100.php?page='.($current_page-1).'")>Prev</span> 
                                </li>';
                            }
                    
                            // Lặp khoảng giữa
                            for ($i = 1; $i <= $total_page; $i++){
                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                // ngược lại hiển thị thẻ a
                                if ($i == $current_page){
                                    echo '
                                    <li class="paginate_button page-item active">
                                        <span class="page-link">'.$i.'</span>
                                    </li>
                                    ';
                                }
                                else{
                                    echo '
                                    <li class="paginate_button page-item ">
                                        <span class="page-link" onclick=openPage("top100.php?page='.$i.'")>'.$i.'</span>
                                    </li>';
                                }
                            }
                    
                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                            if ($current_page < $total_page && $total_page > 1){
                                echo '
                                <li class="paginate_button page-item ">
                                    <span class="page-link" onclick=openPage("top100.php?page='.($current_page+1).'")>Next</span>
                                </li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php 
        include("includes/footer.php");
    ?>
</div>
<?php include("nowPlayingBar.php"); ?>
<script>
    var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
    tempPlaylist = JSON.parse(tempSongIds);
</script>