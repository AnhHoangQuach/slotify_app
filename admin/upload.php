<?php 
	include("../includes/config.php");
	include("../includes/classes/Artist.php");
	include("../includes/classes/Album.php");
?>
<?php
	include("header_admin.php"); 
?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Form Upload Music</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
		<section class="content">
			<div class="container-fluid">
				<div class="row">
				<!-- left column -->
					<div class="col-md-6">
						<!-- general form elements -->
						<section class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Music Life</h3>
							</div>
							<!-- /.card-header -->
							<!-- form start -->
							<form action="../includes/handlers/ajax/uploadFile.php" method="POST" enctype="multipart/form-data">
								<div class="card-body">
									<div class="form-group">
										<label for="inputTitle">Title</label>
										<input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title">
									</div>
									<div class="form-group">
										<label for="inputPass">Artist</label>
										<select class="form-control select2" style="width: 100%;" name="artist">
											<?php 
												$nameArtists = mysqli_query($con, "SELECT * FROM artists");
												while($rows = mysqli_fetch_array($nameArtists)) {
													$artist = new Artist($con, $rows['id']);
													echo "<option value=" . $artist->getId() . ">" . $rows['name'] . "</option>";
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="inputPass">Album</label>
										<select class="form-control select2" style="width: 100%;" name="album">
											<?php 
												$nameAlbums = mysqli_query($con, "SELECT * FROM albums");
												while($rows = mysqli_fetch_array($nameAlbums)) {
													$album = new Album($con, $rows['id']);
													echo "<option value=" . $album->getId() . ">" . $rows['title'] . "</option>";
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="inputPass">Genre</label>
										<select class="form-control select2" style="width: 100%;" name="genre">
											<?php 
												$nameGenres = mysqli_query($con, "SELECT * FROM genres");
												while($rows = mysqli_fetch_array($nameGenres)) {
													echo "<option value=" . $rows['id'] . ">" . $rows['name'] . "</option>";
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="inputFile">File Audio</label>
										<div class="input-group">
											<input type="file" class="" id="inputFile" name="audioFile">
											<button onclick="uploadAudio()">Upload Audio</button>
										</div>
									</div>
									<div class="form-group">
										<label for="inputImage">Image</label>
										<div class="input-group">
											<input type="file" name="imageFile">
										</div>
									</div>
								</div>
								<!-- /.card-body -->

								<div class="card-footer">
									<input type="submit" class="btn btn-primary" value="Upload" name="submit"></input>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
    </div>
<?php 
    include("footer_admin.php");
?>
<script>
	function uploadAudio() {

	}
</script>