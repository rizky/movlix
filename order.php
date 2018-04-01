<?php
    session_start();
    require_once('models/user.php');
    require_once('models/orders.php');
    require_once('models/ord_has_prod.php');
    require_once('models/products.php');

	if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

    $people = people_exist($_SESSION['username']);
    if ($people === null) {
        header('Location: index.php');
        exit();
	}
	$basket = array();
	$orders = prod_get_byord(intval($_GET['order_id']));
	foreach ($orders as $o) {
		$basket[$o['products_id']] = $o['quantity'];
	}
?>
<html lang="en">
	<?php $page_name="Order"; include('components/header.php'); ?>
	<body class="wrapper" onload="window.print();">
		<main class="cart">
			<h1 class="title">Order #<?php echo $_GET['order_id']; ?></h1>
			<?php
			if ($basket) {
				?>
				<table class="basket">
					<thead>
					<tr>
						<td>ID</td>
						<td>Name</td>
						<td></td>
						<td class="right">Price</td>
						<td class="right">Quantity</td>
						<td class="right">Total TTC</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($basket as $k => $v) {
						$movies = product_get_byid($k);
						?>
						<tr>
							<td><a href="movie.php?id=<?php echo $k; ?>"><?php echo $k; ?></a></td>
							<td><a href="movie.php?id=<?php echo $k; ?>"><img
										src="http://image.tmdb.org/t/p/w185/<?php echo $movies['picture']; ?>"
										alt=""></a>
							</td>
							<td class="title"><a
									href="movie.php?id=<?php echo $k; ?>"><?php echo $movies['name']; ?></a>
							</td>
							<td class="right"><?php echo number_format($movies['price'], 2); ?> €</td>
							<td class="right"><?php echo $v ?></td>
							<td class="right">
							<?php echo number_format($movies['price'] * $v, 2); 
									$total += $movies['price'] * $v ;
							?> €</td>
							<td class="right">
								<a href='cart.php?removemovie=<?php echo $k; ?>&removecount=<?php echo $v; ?>' class='button' style="background-color:red">Remove</a>
							</td>
						</tr>
						<?php
					}
					?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="5"></td>
						<td><?php echo $total; ?>
							€
						</td>
					</tr>
					</tfoot>
				</table>
				<div class="checkout">
					<div>
						<a href='account.php' class='button' style="background-color:red">Back</a>
					</div>
				</div>
				<?php
			}
			?>
			</main>
	</body>
</html>
