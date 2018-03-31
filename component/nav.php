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
	if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo']))
		echo '<li><i class="fa fa-user-circle-o"></i> .$_SESSION["pseudo"].| <a href="logout.php">Logout</a></li>';
	else
		echo '<li><i class="fa fa-user-circle-o"></i> Account</li>';
	?>
</ul>
</header>