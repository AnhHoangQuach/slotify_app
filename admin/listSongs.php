<?php 
	include("../includes/config.php");
	include("../includes/classes/Song.php");
	include("../includes/classes/Artist.php");
	include("../includes/classes/Album.php");
?>
<?php
    include("header_admin.php"); 
    //TÌM TỔNG SỐ RECORDS
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
    
    $result = mysqli_query($con, "SELECT * FROM songs LIMIT $start, $limit");

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Song List</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Song Now</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Artist</th>
                                        <th>Album</th>
                                        <th>Genre</th>
                                        <th>Duration</th>
                                        <th>Views</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(isset($_GET['id'])) {
                                            $id = $_GET['id'];
                                            $seeSong = mysqli_query($con, "SELECT * FROM songs WHERE id=$id");
                                            $row = mysqli_fetch_array($seeSong);
                                            $song = new Song($con, $row['id']);
                                    ?>
                                        <tr>
                                            <td><?php echo $song->getId() ?></td>
                                            <td><?php echo $song->getTitle() ?></td>
                                            <td><?php echo $song->getArtist()->getName() ?></td>
                                            <td><?php echo $song->getAlbum()->getTitle() ?></td>
                                            <td><?php echo $song->getGenreName() ?></td>
                                            <td><?php echo $song->getDuration() ?></td>
                                            <td><?php echo $song->getPlays() ?></td>
                                            <td>
                                            <button class="btn btn-warning" data-toggle="modal" type="button" data-target="#song<?php echo $song->getId()?>">Edit</button>
                                            <button class="btn btn-danger" onclick="deleteSong(<?php echo $song->getId()?>)">DELETE</button>
                                            </td>
                                        </tr>
                                    <?php 
                                        include("updateSong.php");
                                        } else {
                                            while($row = mysqli_fetch_array($result)) {
                                                $song = new Song($con, $row['id']);
                                    ?>
                                        <tr>
                                            <td><?php echo $song->getId()?></td>
                                            <td><?php echo $song->getTitle() ?></td>
                                            <td><?php echo $song->getArtist()->getName() ?></td>
                                            <td><?php echo $song->getAlbum()->getTitle() ?></td>
                                            <td><?php echo $song->getGenreName() ?></td>
                                            <td><?php echo $song->getDuration() ?></td>
                                            <td><?php echo $song->getPlays() ?></td>
                                            <td>
                                                <button class="btn btn-warning" data-toggle="modal" type="button" data-target="#song<?php echo $song->getId()?>">Edit</button>
                                                <button class="btn btn-danger" onclick="deleteSong(<?php echo $song->getId()?>)">DELETE</button>
                                            </td>
                                        </tr>
                                    <?php
                                                include("updateSong.php");
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->                  
                </div>
                <!-- /.col -->
            </div>
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
                                        <a class="page-link" href="listSongs.php?page='.($current_page-1).'">Prev</a> 
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
                                            <a class="page-link" href="listSongs.php?page='.$i.'">'.$i.'</a>
                                        </li>';
                                    }
                                }
                     
                                // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                if ($current_page < $total_page && $total_page > 1){
                                    echo '
                                    <li class="paginate_button page-item ">
                                        <a class="page-link" href="listSongs.php?page='.($current_page+1).'">Next</a>
                                    </li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?php 
    include("footer_admin.php");
?>