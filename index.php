<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<?php $page_name="Home"; include('component/header.php'); ?>
	<body class="wrapper">
		<?php include('component/nav.php'); ?>
		<main class="landing">
		<div id="carousel">
			<div class="hideLeft" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/vklrwoxtx/cover9.jpg">
			</div>
			<div class="prevLeftSecond" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/cgsggckzp/cover8.jpg">
			</div>
			<div class="prev" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/emmrauog5/cover7.jpg">
			</div>
			<div class="selected" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/9drqcz611/cover1.jpg">
			</div>
			<div class="next" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/pnhwfvgp1/cover6.jpg">
			</div>
			<div class="nextRightSecond" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/edp6kxbnp/cover4.jpg">
			</div>
			<div class="hideRight" onclick="moveToSelected(this)">
				<img src="https://s16.postimg.org/fij8qay4l/cover3.jpg">
			</div>
			</div>
		</main>
		<?php include('component/footer.php'); ?>
	</body>
</html>