<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<?php $page_name="Home"; include('components/header.php'); ?>
	<body class="wrapper">
		<?php include('components/nav.php'); ?>
		<main class="landing">
			<div id="carousel">
				<div class="hideLeft" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/eF1oi474qPVJROPlSy5zyKKUwDE.jpg">
				</div>
				<div class="prevLeftSecond" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/8jEbkCRz5PFf3LzwZ505W5qJHIC.jpg">
				</div>
				<div class="prev" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/mYsoCOq82b08juHGxd3WnotiCAh.jpg">
				</div>
				<div class="selected" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/cwG6uUC9vClzWBdUjjAxloHohLq.jpg">
				</div>
				<div class="next" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/kOVEVeg59E0wsnXmF9nrh6OmWII.jpg">
				</div>
				<div class="nextRightSecond" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/krQkZ4fGdyOMEpa6mBFHd3G5i0X.jpg">
				</div>
				<div class="hideRight" onclick="moveToSelected(this)">
					<img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/rgxCujyIPH6K2m7sWZMPbzR78YB.jpg">
				</div>
			</div>
		</main>
		<?php include('components/footer.php'); ?>
	</body>
</html>