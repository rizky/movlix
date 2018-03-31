<?php
	session_start();

	require_once ('models/user.php');
	$cartCount = isset($_SESSION['cartCount']) ? $_SESSION['cartCount']  : "Empty";
	$admin = admin_exist($_SESSION['username']);
?>
<header>
<ul class="nav">
	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="browse.php"><i class="fa fa-film"></i> Movies</a></li>
	<li class="nav_logo">Movlix</li>
	<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> <?php echo $cartCount." Cart";?></a></li>
	<?php
	if (isset($_SESSION['username']) && !empty($_SESSION['username']))
	{
		echo '
		<li class="nav_account">
			<span><i class="fa fa-user-circle-o"></i> '.$_SESSION["username"].'</span>
			<ul class="ani">';
		if ($admin !== null)
			echo '<li><a href="admin.php">Manage</a></li>';
		echo '<li><a href="logout.php">Logout</a></li>
			</ul>
		</li>
		';
	}
	else
	{
		echo '
		<li class="nav_account">
			<span><i class="fa fa-user-circle-o"></i> Account</span>
			<ul class="ani">
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
			</ul>
		</li>';
	}
	?>
</ul>
</header>