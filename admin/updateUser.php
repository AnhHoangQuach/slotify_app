<div class="modal fade" id="exampleModal<?php echo $rows['id']?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="../includes/handlers/ajax/update_query.php" method="POST">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputUsername">User Name</label>
						<input type="hidden" name="user_id" value="<?php echo $rows['id']?>"/>
						<div class="input-group">
							<input type="text" class="form-control" id="" name="username" value="<?php echo $user->getUsername() ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputFullname">Full Name</label>
						<div class="input-group">
							<input type="text" class="form-control" id="" name="fullname" value="<?php echo $user->getFullName() ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail">Email</label>
						<div class="input-group">
							<input type="text" class="form-control" id="" name="email" value="<?php echo $user->getEmail() ?>">
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