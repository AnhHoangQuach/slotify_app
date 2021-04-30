<?php 
	include("includes/config.php"); 
	include("includes/classes/Song.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
?>
<?php 
	include("header_admin.php")
?>
  <!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Dashboard</h1>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-seedling"></i></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Views</span>
						<span class="info-box-number">
							<?php 
								$sumView = mysqli_query($con, "SELECT sum(plays) AS SumViews FROM songs");
								$row = mysqli_fetch_array($sumView);
								echo $row['SumViews']
							?>
						</span>
					</div>
					<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
					<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Albums</span>
						<span class="info-box-number">
							<?php 
								$sumAlbums = mysqli_query($con, "SELECT count(id) AS SumAlbums
								FROM albums");
								$row = mysqli_fetch_array($sumAlbums);
								echo $row['SumAlbums']
							?>
						</span>
					</div>
					<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<!-- fix for small devices only -->
				<div class="clearfix hidden-md-up"></div>

				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Songs</span>
						<span class="info-box-number">
							<?php 
								$sumSongs = mysqli_query($con, "SELECT count(id) AS SumSongs
								FROM songs");
								$row = mysqli_fetch_array($sumSongs);
								echo $row['SumSongs']
							?>
						</span>
					</div>
					<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Members</span>
						<span class="info-box-number">
							<?php 
								$sumUsers = mysqli_query($con, "SELECT count(id) AS SumUsers
								FROM users");
								$row = mysqli_fetch_array($sumUsers);
								echo $row['SumUsers']
							?>
						</span>
					</div>
					<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->

			<!-- Main row -->
			<div class="row">
			<!-- Left col -->
				<div class="col-md-8">
					<!-- TABLE: LATEST ORDERS -->
					<div class="card">
						<div class="card-header border-transparent">
							<h3 class="card-title">Top Music</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table m-0">
									<thead>
									<tr>
										<th>Order ID</th>
										<th>Item</th>
										<th>Artist</th>
										<th>Views</th>
									</tr>
									</thead>
									<tbody>
									<?php 
										$topMusic = mysqli_query($con, "SELECT * FROM songs ORDER BY plays DESC LIMIT 6");
										while($row = mysqli_fetch_array($topMusic)) {
											$song = new Song($con, $row['id']);
											$songArtist = $song->getArtist();
											echo "
												<tr>
													<td>" . $song->getId() . "</td>
													<td>" . $song->getTitle() . "</td>
													<td><span class='badge badge-success'>" . $songArtist->getName() . "</span></td>
													<td>
														" . $song->getPlays() . "
													</td>
												</tr>
											";
										}
									?>
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				<div class="col-md-4">
					<!-- Info Boxes Style 2 -->
					<div class="info-box mb-3 bg-warning">
						<span class="info-box-icon"><i class="fas fa-tag"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Upload</span>
							<span class="info-box-number">5,200</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
					<div class="info-box mb-3 bg-success">
						<span class="info-box-icon"><i class="far fa-heart"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Group Members</span>
							<span class="info-box-number">92,050</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
					<div class="info-box mb-3 bg-danger">
						<span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Downloads</span>
							<span class="info-box-number">114,381</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
					<div class="info-box mb-3 bg-info">
						<span class="info-box-icon"><i class="far fa-comment"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Direct Messages</span>
							<span class="info-box-number">163,921</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
			</div><!--/. container-fluid -->
		</section>
		<!-- /.content -->
  	</div>
<!-- /.content-wrapper -->
<?php 
	include("footer_admin.php")
?>