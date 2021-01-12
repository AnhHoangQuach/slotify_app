<?php 
    include("../../config.php");

    $output = '';
    if(isset($_POST["query"])) {
        $search = mysqli_real_escape_string($con, $_POST["query"]);
        $querySong = " SELECT * FROM songs 
        WHERE Title LIKE '%".$search."%'
        ORDER BY plays DESC LIMIT 3";
        
        
        $queryArtist = "SELECT * FROM artists 
        WHERE name LIKE '%".$search."%'
        ORDER BY name DESC LIMIT 3";


        $queryAlbum = "SELECT * FROM albums 
        WHERE title LIKE '%".$search."%'
        ORDER BY title DESC LIMIT 3";


        $result = mysqli_query($con, $querySong);
        $resultArt = mysqli_query($con, $queryArtist);
        $resultAlbum = mysqli_query($con, $queryAlbum);
        if(mysqli_num_rows($result) > 0 || mysqli_num_rows($resultArt) || mysqli_num_rows($resultAlbum)) {
            $output .= '<ul class="search-list">
                <li class="title-query">-- Songs --</li>
            ';
            while($row = mysqli_fetch_array($result)){
                $output .= "<a href='../admin/listSongs.php?id=" . $row['id'] . "'>
                    <li>" . $row["title"] . "</li>
                </a>";
            }
            $output .= "<li class='title-query'>-- Artists --</li>";
            while($row1 = mysqli_fetch_array($resultArt)) {
                $output .= "<a href='../admin/listArtists.php?id=" . $row1['id'] . "'>
                    <li>" . $row1["name"] . "</li>
                </a>";
            }

            $output .= "<li class='title-query'>-- Albums --</li>";
            while($row2 = mysqli_fetch_array($resultAlbum)) {
                $output .= "<a href='../admin/listAlbums.php?id=" . $row2['id'] . "'>
                    <li>" . $row2["title"] . "</li>
                </a>";
            }
            echo $output . '</ul>';
        }
    }
?>