<?php
	include("includes/includedFiles.php");
?>
		<div class="container">
			<div class="slick-list">
				<div class="slick-track">
					<img src="/slotify_app/assets/images/slide/slide1.jpg" alt="">
				</div>
				<div class="slick-track">
					<img src="/slotify_app/assets/images/slide/slide2.jpg" alt="">
				</div>
				<div class="slick-track">
					<img src="/slotify_app/assets/images/slide/slide3.jpg" width="1026px" height="343px" alt="">
				</div>
			</div>
			<?php 
				include("listMusic.php")
			?>
			<?php
				include("zingchart.php")
			?>
			<?php 
				include("zingrelease.php")
			?>
		<script type="text/javascript" src="/slotify_app/assets/slick/slick.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.slick-list').slick({
					autoplay: true,
					autoplaySpeed: 2000, //DELAY BEFORE NEXT SLIDE IN MILISECONDS
					speed: 800 //SPEED OF THE SLIDER CHANGE
				});

				$('.album-list').slick({
					infinite: true,
					slidesToShow: 5,
					slidesToScroll: 5
				})
			});
		</script>
	</main>
	<?php 
		include("includes/footer.php");
	?>
	<?php include("nowPlayingBar.php"); ?>