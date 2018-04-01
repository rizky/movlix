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
    $orders = order_get_bypeopleid($people['id']);

?>
<!DOCTYPE html>
<html lang="en">
	<?php $page_name=$_SESSION['username']; include('components/header.php'); ?>
	<body class="wrapper">
		<?php include('components/nav.php'); ?>
		<main class="account">
			<div class="modify">
				<h2>Modify my informations</h2>
				<form action="controllers/user.php" method="POST">
					<input type="password" name="password" placeholder="New password" value=""
						class="<?php echo isset($_GET['password']) ? 'error' : ''; ?>">
					<input type="text" name="firstname" placeholder="First name" value="<?php echo $people['firstname']; ?>"
						class="<?php echo isset($_GET['firstname']) ? 'error' : ''; ?>">
					<input type="text" name="lastname" placeholder="Last name" value="<?php echo $people['lastname']; ?>"
						class="<?php echo isset($_GET['lastname']) ? 'error' : ''; ?>">
					<input type="text" name="address" placeholder="Address" value="<?php echo $people['address']; ?>"
						class="<?php echo isset($_GET['address']) ? 'error' : ''; ?>">
					<button type="submit" class="btn btn-default">Modify</button>
					<input type="hidden" name="username" value="<?php echo $people['username']; ?>">
					<input type="hidden" name="success" value="account">
					<input type="hidden" name="from" value="update">
					<input type="hidden" name="error" value="account">
				</form>
			</div>
			<div class="orders">
				<h2>My Orders</h2>
				<?php
				if ($orders) {
					foreach ($orders as $o) {
						echo "<h5>Order of " . $o['date_order'] . "</h5>";
						?>
						<table class="basket">
							<tbody>
							<?php
								$products = prod_get_byord(intval($o['id']));
								foreach ($products as $p2) {
									$p = product_get_byid($p2['products_id']);
									?>
									<tr>
										<td><a href="movie.php?id=<?php echo $p['id']; ?>"><?php echo $p['id']; ?></a>
										</td>
										<td class="title"><a
												href="movie.php?id=<?php echo $p['id']; ?>"><?php echo $p['name']; ?></a>
										</td>
										<td class="right"><?php echo number_format($p2['quantity'], 0); ?></td>
										<td class="right"><?php echo number_format($p2['price'] * $p2['quantity'], 2); ?> €</td>
									</tr>
									<?php
								}

							?>
							</tbody>
						</table>
						<?php
					}
					echo "</div>";
				}
				?>
			</div>
		</main>
		<?php include('components/footer.php'); ?>
	<body>
</html>
