<div class="modal fade" id="createAlbum" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="../includes/handlers/ajax/createAlbum.php" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Create Album</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputTitle">Title</label>
						<div class="input-group">
							<input type="text" name="title" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="inputArtist">Artist</label>
						<select class="form-control select2" style="width: 100%;" name="artist">
							<?php 
								$artists = mysqli_query($con, "SELECT * FROM artists");
								while($row = mysqli_fetch_array($artists)) {
									echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
								}
							?>
                        </select>
					</div>
                    <div class="form-group">
						<label for="inputGenre">Genre</label>
						<select class="form-control select2" style="width: 100%;" name="genre">
							<?php 
								$genres = mysqli_query($con, "SELECT * FROM genres");
								while($row = mysqli_fetch_array($genres)) {
									echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
								}
							?>
                        </select>
					</div>
                    <div class="form-group">
						<label for="inputImage">Image</label>
						<div class="input-group">
							<input type="file" name="audioFile" class="form-control">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success" name="create">Create</button>
				</div>
			</form>
		</div>
	</div>
</div>