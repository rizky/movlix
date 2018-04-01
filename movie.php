<?php
	session_start();
	if (!$_GET['id'] || !is_numeric($_GET['id']))
	{
        header('Location: browse.php');
        exit();
    }
    require_once ('models/products.php');
    $product = product_get_byid($_GET['id']);
	if (!$product)
	{
        header('Location: browse.php');
        exit();
    }
    $movie = (array) json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'?api_key=db663b344723dd2d6781aed1e2f7764d'));
    $credits = (array) json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'/credits?api_key=db663b344723dd2d6781aed1e2f7764d'));
?>
<!DOCTYPE html>
<html lang="en">
	<?php $page_name=$product['name']; include('components/header.php'); ?>
	<body class="wrapper">
		<?php include('components/nav.php'); ?>
		<main class="movie">
			<h1><?php echo $product['name']; ?></h1>
			<div class="description">
				<div class="thumbnail">
					<img src="http://image.tmdb.org/t/p/w185/<?php echo $product['picture']; ?>" alt="">
				</div>
				<div class="desc">
					<dl>
						<dt>Release Date</dt>
						<dd><?php echo isset($movie['release_date']) ? $movie['release_date'] : 'Unknown' ; ?></dd>
						<dt>Language</dt>
						<dd><?php echo isset($movie['original_language']) ? $movie['original_language'] : 'Unknown' ; ?></dd>
						<dt>Title</dt>
						<dd><?php echo isset($movie['original_title']) ? $movie['original_title'] : 'Unknown' ; ?></dd>
						<dt>Genre</dt>
						<dd>-</dd>
						<dt>Budget</dt>
						<dd><?php echo isset($movie['budget']) ? $movie['budget'].' $' : 'Unknown' ; ?></dd>
						<dt>Revenue</dt>
						<dd><?php echo isset($movie['revenue']) ? $movie['revenue'].' $' : 'Unknown' ; ?></dd>
						<dt>Producer</dt>
						<dd><?php
								if (isset($movie['production_companies'])) {
									foreach ($movie['production_companies'] as $v) {
										$v = (array)$v;
										echo $v['name'].', ';
									}
								}
							?>
						</dd>
						<dt>Country</dt>
						<dd><?php
								if (isset($movie['production_countries'])) {
									foreach ($movie['production_countries'] as $v) {
										$v = (array)$v;
										echo $v['name'].', ';
									}
								}
							?>
						</dd>
						<dt>Synopsys</dt>
						<dd><?php echo isset($movie['overview']) ? $movie['overview'] : 'Unknown' ; ?></dd>
					</dl>
					<div class="addtoCart">
						<form action="cart.php" method="post">
							<input type="number" name="quantity" value="1">
							/<?php echo $product['stock']; ?>
							<input type="hidden" name="id" value="<?php echo $product['id']; ?>">
							<button type="submit" class="btn btn-default">Add to Cart</button>
						</form>
					</div>
				</div>
			</div>
			<h3>Actors</h3>
			<div class="actors">
			<?php
			if (isset($credits['cast'])) {
				foreach ($credits['cast'] as $v) {
					$v = (array)$v;
					if (empty($v['profile_path']))
						echo '<div class="photo" style="background-image: url(img/avatar.png)">';
					else
						echo '<div class="photo" style="background-image: url(http://image.tmdb.org/t/p/w185/'.$v['profile_path'].')">';
							echo '<div class="title">';
								echo '<p class="name">'.$v['name'].'</p>';
								echo '<p>as</p>';
								echo '<p class="role">'.$v['character'].'</p>';
							echo '</div>';
						echo '</div>';
				}
			}
			?>
			</div>
			<h3>Details</h3>
			<div class="crews">
			<?php
			if (isset($credits['crew'])) {
				foreach ($credits['crew'] as $v) {
					$v = (array)$v;
					if (empty($v['profile_path']))
						echo '<div class="photo" style="background-image: url(img/avatar.png)">';
					else
						echo '<div class="photo" style="background-image: url(http://image.tmdb.org/t/p/w185/'.$v['profile_path'].')">';
							echo '<div class="title">';
								echo '<p class="name">'.$v['name'].'</p>';
								echo '<p>as</p>';
								echo '<p class="role">'.$v['job'].'</p>';
							echo '</div>';
						echo '</div>';
				}
			}
			?>
			</div>
		</main>
		<?php include('components/footer.php'); ?>
	<body>
</html>