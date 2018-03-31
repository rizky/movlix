<header>
    <div class="logo">
        <a href="index.php"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="menu">
        <a href="index.php">Home</a> |
        <a href="browse.php">Discover Movies</a> |
        <a href="cart.php">
		<?php 
			echo isset($_SESSION['cartCount']) ? $_SESSION['cartCount']  : "0";
			echo " Cart - ";
			echo isset($_SESSION['cartTotal']) ? number_format($_SESSION['cartTotal'], 2) : '0.00';
			echo "€";
		?>
		</a>
    </div>
    <div class="account">
        <?php
            if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo']))
                echo '<a href="member.php">Hello '.$_SESSION['pseudo'].'</a> | <a href="logout.php">Logout</a>';
            else
                echo '<a href="register.php">Register</a> | <a href="login.php">Login</a>';
        ?>
    </div>
</header>