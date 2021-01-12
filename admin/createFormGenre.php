<div class="modal fade" id="createGenre" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="../includes/handlers/ajax/createGenre.php" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Create Genre</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputName">Name</label>
						<div class="input-group">
							<input type="text" name="name" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="inputImage">Image</label>
						<div class="input-group">
							<input type="file" name="audioFile">
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