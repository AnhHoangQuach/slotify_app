<?php
    include("includes/config.php");
?>
<?php
    include("includes/header.php")
?>

<div class="container">
    <div class="container-list-genres">
        <?php 
            $result = mysqli_query($con, "SELECT * FROM genres");
            while($row = mysqli_fetch_array($result)) {
                echo '<span role="link" tabindex="0" onclick="openPage(\'title.php?id=' . $row['id'] . '\')">
                <div class="col-3">
                    <div class="zm-card-image">
                        <figure class="image bg-image">
                            <img class="is-256x135" src="/' . $row['image'] . '" alt="">
                        </figure>
                    </div>
                </div>
            </span>';
            }
        ?>
    </div>
</div>