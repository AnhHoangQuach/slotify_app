<?php
    include("includes/includedFiles.php");
?>
<div class="container">
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND()");
        while($row = mysqli_fetch_array($albumQuery)) {
            
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                        <img src='../" . $row['artworkPath'] . "'>
                        <div class='gridViewInfo'>
                            " . $row['title'] . "
                        </div>
                    </span>
                </div>";
        }
    ?>
</div>
<?php include("nowPlayingBar.php"); ?>