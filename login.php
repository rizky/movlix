<?php
    session_start();
	if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo']))
	{
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
	<?php $page_name="Login"; include('component/header.php'); ?>
	<body class="wrapper">
		<?php include('component/nav.php'); ?>
		<main>
			<h1>Login</h1>
			<form action="controller/people.php" method="POST">
				<input type="text" name="username" placeholder="Username" class="" value="">
				<input type="password" name="password" placeholder="Password" class="">
				<button type="submit" class="btn btn-default">Login</button>
				<input type="hidden" name="from" value="login">
				<input type="hidden" name="success" value="index">
				<p>Have not registered? <a href="register.php">Register here</a></p>
			</form>
		</main>
		<?php include('component/footer.php'); ?>
	<body>
</html>