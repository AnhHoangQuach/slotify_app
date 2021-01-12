<div class="modal fade" id="genre<?php echo $row['id']?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="../includes/handlers/ajax/update_genre.php" method="POST">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Genre</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputTitle">Name</label>
                        <input type="hidden" name="genre_id" value="<?php echo $row['id']?>"/>
						<div class="input-group">
							<input type="text" name="name" class="form-control" value="<?php echo $row['name']?>">
						</div>
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