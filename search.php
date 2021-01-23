<?php 
    include("includes/config.php");

    $output = '';
    if(isset($_POST["query"])) {
        $search = mysqli_real_escape_string($con, $_POST["query"]);
        $querySong = " SELECT * FROM songs 
        WHERE Title LIKE '%".$search."%'
        ORDER BY plays DESC LIMIT 2";
        
        
        $queryArtist = "SELECT * FROM artists 
        WHERE name LIKE '%".$search."%'
        ORDER BY name DESC LIMIT 2";


        $queryAlbum = "SELECT * FROM albums 
        WHERE title LIKE '%".$search."%'
        ORDER BY title DESC LIMIT 2";

		$songIdArray = [];
        $result = mysqli_query($con, $querySong);
        $resultArt = mysqli_query($con, $queryArtist);
        $resultAlbum = mysqli_query($con, $queryAlbum);
        if(mysqli_num_rows($result) > 0 || mysqli_num_rows($resultArt) || mysqli_num_rows($resultAlbum)) {
            $output .= '<div class="search-list"><ul>
				<div class="title-query text-center">Songs</div>
			';
            while($row = mysqli_fetch_array($result)){
				array_push($songIdArray, $row['id']);
                $output .= "<li><span onclick='setTrack(" . $row['id'] . ", tempPlaylist,true)'>
                    " . $row["title"] . "
                </span></li>";
			}
			$output .= "</ul><ul><div class='title-query text-center'>Artists</div>";
            while($row1 = mysqli_fetch_array($resultArt)) {
                $output .= "<li><span onclick=openPage('artist.php?id=" . $row1['id'] . "')>
                    " . $row1["name"] . "
                </span></li>";
			}
			
			$output .= "</ul><ul><div class='title-query text-center'>Albums</div>";
            while($row2 = mysqli_fetch_array($resultAlbum)) {
                $output .= "<li><span onclick=openPage('album.php?id=" . $row2['id'] . "')>
                    " . $row2["title"] . "
                </span></li>";
            }
            echo $output . '</ul></div>';
        }
    }
?>