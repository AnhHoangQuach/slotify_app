<?php 
	include("../includes/config.php");
	include("../includes/classes/Artist.php");
	include("../includes/classes/Album.php");
?>
<?php
	include("header_admin.php"); 
?>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-storage.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyBsnIVcp5dbfcat2de-ewkyfDEOPZEy5E8",
    authDomain: "slotify-app-27ac1.firebaseapp.com",
    projectId: "slotify-app-27ac1",
    storageBucket: "slotify-app-27ac1.appspot.com",
    messagingSenderId: "1004944716100",
    appId: "1:1004944716100:web:d9623be9603155b107a711",
    measurementId: "G-987L31M9K8"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
  function uploadImage() {
	var path_file;
	const ref = firebase.storage().ref();
	const file = document.querySelector('#inputImage').files[0]
	const name = new Date() + '-' + file.name
	const metadata = {
		contentType: file.type
	}
	const task = ref.child(name).put(file, metadata)
	task.then(snapshot => snapshot.ref.getDownloadURL())
	.then(url => {
		console.log(url)
		$('#imageLink').val(url);		
	})
  }
  function uploadImage2() {
	var path_file;
	const ref = firebase.storage().ref();
	const file = document.querySelector('#inputAudio').files[0]
	const name = new Date() + '-' + file.name
	const metadata = {
		contentType: file.type
	}
	const task = ref.child(name).put(file, metadata)
	task.then(snapshot => snapshot.ref.getDownloadURL())
	.then(url => {
		console.log(url)
		$('#audioLink').val(url);		
	})
  }
  async function uploadForm() {
	await Promise.all([uploadImage(), uploadImage2()]);
	setTimeout(() => {
		$.post('../../slotify_app/includes/handlers/ajax/uploadFile.php', {
			title: $('#inputTitle').val(),
			artist: $('#artist').val(),
			album: $('#album').val(),
			genre: $('#genre').val(),
			image_path: $('#imageLink').val(),
			audio_path: $('#audioLink').val(),
		})
		location.href = "./listSongs.php";
	}, 5000)
  }
</script>
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
				
							<div class="card-body">
								<div class="form-group">
									<label for="inputTitle">Title</label>
									<input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title">
								</div>
								<div class="form-group">
									<label for="inputPass">Artist</label>
									<select class="form-control select2" style="width: 100%;" name="artist" id="artist">
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
									<select class="form-control select2" style="width: 100%;" name="album" id="album">
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
									<select class="form-control select2" style="width: 100%;" name="genre" id="genre">
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
										<input type="file" id="inputAudio" name="audioFile">
										<input type="text" id="audioLink" hidden>
									</div>
								</div>
								<div class="form-group">
									<label for="inputImage">Image</label>
									<div class="input-group">
										<input type="file" name="imageFile" id="inputImage">
										<input type="text" id="imageLink" hidden>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
		
							<div class="card-footer">
								<button class="btn btn-primary" onclick="uploadForm()" name="upload">Upload</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
    </div>
<?php 
    include("footer_admin.php");
?>