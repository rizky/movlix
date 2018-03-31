<header>
<?
$cartCount = isset($_SESSION['cartCount']) ? $_SESSION['cartCount']  : "Empty";
?>
<ul class="nav">
	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="browse.php"><i class="fa fa-film"></i> Movies</a></li>
	<li class="nav_logo">Movlix</li>
	<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> <? echo $cartCount." Cart";?></a></li>
	<? 
	if (isset($_SESSION['username']) && !empty($_SESSION['username']))
		echo '
		<li class="nav_account">
			<span><i class="fa fa-user-circle-o"></i> '.$_SESSION["username"].'</span>
			<ul class="ani">
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</li>
		';
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