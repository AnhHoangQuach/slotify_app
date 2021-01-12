<div class="modal fade" id="song<?php echo $song->getId()?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="../includes/handlers/ajax/update_song.php" method="POST">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Song</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputTitle">Title</label>
						<input type="hidden" name="song_id" value="<?php echo $song->getId()?>"/>
						<div class="input-group">
							<input type="text" class="form-control" id="" name="title" value="<?php echo $song->getTitle() ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputArtist">Artist</label>
						<select class="form-control select2" style="width: 100%;" name="artist">
							<?php 
								$artists = mysqli_query($con, "SELECT * FROM artists");
								while($row = mysqli_fetch_array($artists)) {
									echo "<option value=" . $row['id'] . " ";
									if($row['id'] == $song->getArtistId()) { 
										echo "selected"; 
									}
									echo ">" . $row['name'] . "</option>";
								}
							?>
                        </select>
					</div>
					<div class="form-group">
						<label for="inputAlbum">Album</label>
						<select class="form-control select2" style="width: 100%;" name="album">
							<?php 
								$albums = mysqli_query($con, "SELECT * FROM albums");
								while($row = mysqli_fetch_array($albums)) {
									echo "<option value=" . $row['id'] . " ";
									if($row['id'] == $song->getAlbumId()) { 
										echo "selected"; 
									}
									echo ">" . $row['title'] . "</option>";
								}
							?>
                        </select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success" name="update">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>