<?php
    session_start();
    require_once('model/categories.php');
    require_once('model/products.php');
    $categories = category_get_all();
    $movie = product_get_filtre($_GET['cat'], (float)$_GET['min'], (float)$_GET['max'], $_GET['name']);
?>
<!DOCTYPE html>
<html lang="en">
	<?php $page_name="Browse"; include('component/header.php'); ?>
	<body class="wrapper">
		<?php include('component/nav.php'); ?>
		<main class="browse">
			<div class="filter">
				<h2>Filter</h2>
				<form action="">
					<input type="text" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ; ?>" placeholder="Film Name">
					<input type="number" name="min" value="<?php echo isset($_GET['min']) ? $_GET['min'] : '' ; ?>" placeholder="Minimum Price" style="width:49%;">
					<input type="number" name="max" value="<?php echo isset($_GET['max']) ? $_GET['max'] : '' ; ?>" placeholder="Maximum Price" style="width:49%;">
					<input type="hidden" name="cat" value="<?php echo $_GET['cat']; ?>">
					<button type="submit" class="btn btn-default">Search</button>
				</form>
				<h2 style="margin-top:30px;">Categories</h2>
				<ul>
					<?php
						foreach ($categories as $v) {
							$filtre = '';
							$filtre .= isset($_GET['name']) ? "&name=".$_GET['name'] : '' ;
							$filtre .= isset($_GET['min']) ? "&min=".$_GET['min'] : '' ;
							$filtre .= isset($_GET['max']) ? "&max=".$_GET['max'] : '' ;
							if ($v['id'] == $_GET['cat'])
								echo "<a href='browse.php?".$filtre."'><li";
							else
								echo "<a href='browse.php?cat=" . $v['id'] . "".$filtre."'><li";
							echo $_GET['cat'] == $v['id'] ? " class='selected'" : '';
							echo ">" . $v['name'] . "</li></a>";
						}
					?>
				</ul>
			</div>
			<div class="movies">
				<?php
				foreach ($movie as $v) {
				?>
				<div class="movie">
					<a href="movie.php?id=<?php echo $v['id']; ?>">
						<div class="movie"
							style="background-image: url('http://image.tmdb.org/t/p/w185/<?php echo $v['picture']; ?>')">
							<div class="price"><?php echo number_format($v['price'], 2); ?> ‎€</div>
							<div class="title"><?php echo $v['name']; ?></div>
						</div>
					</a>
				</div>
				<?php
				}
				?>
			</div>
		</main>
		<?php include('component/footer.php'); ?>
	</body>
</html>
