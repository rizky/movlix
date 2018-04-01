<?php
    session_start();

    require_once ('models/user.php');
    require_once ('models/categories.php');
    require_once ('models/products.php');

    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

    $people = admin_exist($_SESSION['username']);
    if ($people === null) {
        header('Location: index.php');
        exit();
    }
    
    $peoples = people_get_all();
    $categories = category_get_all();
    $products = products_get();
?>
<html lang="en">
	<?php $page_name="Admin"; include('components/header.php'); ?>
	<body class="wrapper">
		<?php include('components/nav.php'); ?>
		<main class="admin">
			<div class="user">
				<h2>User</h2>
				<h5>Add</h5>
				<form action="controllers/people.php" method="POST">
					<input type="text" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<input type="email" name="email" placeholder="Email">
					<input type="text" name="firstname" placeholder="First Name">
					<input type="text" name="lastname" placeholder="Last Name">
					<input type="text" name="address" placeholder="Address">
					<input type="hidden" name="from" value="register">
					<input type="hidden" name="success" value="admin">
					<input type="hidden" name="error" value="admin">
					<button type="submit" class="btn btn-default">Add</button>
				</form>
				<h5>Delete</h5>
				<form action="controllers/people.php" method="POST">
					<select name="username">
					<?php
						foreach($peoples as $v) {
							echo "<option value='".$v['username']."'>".$v['username']." - ".$v['firstname']." ".$v['lastname']."</option>";
						}
					?>
					</select>
					<input type="hidden" name="from" value="unregister">
					<input type="hidden" name="success" value="admin">
					<input type="hidden" name="error" value="admin">
					<button type="submit" class="btn btn-default">Delete</button>
				</form>
				<h5>Modify</h5>
				<form action="controllers/people.php" method="POST">
					<select name="username">
					<?php
						foreach($peoples as $v) {
							echo "<option value='".$v['username']."'>".$v['username']." - ".$v['firstname']." ".$v['lastname']."</option>";
						}
					?>
					</select>
					<input type="password" name="password" placeholder="Password">
					<input type="text" name="firstname" placeholder="First Name">
					<input type="text" name="lastname" placeholder="Last Name">
					<input type="text" name="address" placeholder="Address">
					<input type="hidden" name="from" value="update">
					<input type="hidden" name="success" value="admin">
					<input type="hidden" name="error" value="admin">
					<button type="submit" class="btn btn-default">Modify</button>
				</form>
			</div>
			<div class="categories">
				<h2>Categories</h2>
				<h5>Add</h5>
				<form action="controllers/categories.php" method="POST">
					<input type="text" name="name">
					<input type="hidden" name="from" value="addcategorie">
					<input type="hidden" name="success" value="admin">
					<button type="submit" class="btn btn-default">Add</button>
				</form>
				<h5>Delete</h5>
				<form action="controllers/categories.php" method="POST">
					<select name="name">
						<?php
						foreach($categories as $v) {
							echo "<option value='".$v['name']."'>".$v['name']."</option>";
						}
						?>
					</select>
					<input type="hidden" name="from" value="removecategory">
					<input type="hidden" name="success" value="admin">
					<button type="submit" class="btn btn-default">Delete</button>
				</form>
				<h5>Modify</h5>
				<form action="controllers/categories.php" method="POST">
					<select name="oldname">
						<?php
							foreach($categories as $v) {
								echo "<option value='".$v['name']."'>".$v['name']."</option>";
							}
						?>
					</select>
					<input type="text" name="name" placeholder="New Category">
					<input type="hidden" name="from" value="updatecategorie">
					<input type="hidden" name="success" value="admin">
					<button type="submit" class="btn btn-default">Modify</button>
				</form>
			</div>
			<div class="movies">
				<h2>Movies</h2>
				<h5>Add</h5>
				<form action="controllers/products.php" method="POST">
					<input type="text" name="name" placeholder="Movie Title">
					<input type="number" name="databaseid" placeholder="ID api">
					<input type="number" name="price" placeholder="Price">
					<input type="number" name="stock" placeholder="Stock">
					<input type="hidden" name="isAdult" value="0">
					<input type="hidden" name="from" value="addproduct">
					<input type="hidden" name="success" value="admin">
					<button type="submit" class="btn btn-default">Add</button>
				</form>
				<h5>Delete</h5>
				<form action="controllers/products.php" method="POST">
					<select name="id">
						<?php
							foreach($products as $v) {
								echo "<option value='".$v['id']."'>".$v['name']."</option>";
							}
						?>
					</select>
					<input type="hidden" name="from" value="removeproduct">
					<input type="hidden" name="success" value="admin">
					<button type="submit" class="btn btn-default">Delete</button>
				</form>
				<h5>Modify</h5>
				<form action="controllers/products.php" method="POST">
					<select name="id">
						<?php
						foreach($products as $v) {
							echo "<option value='".$v['id']."'>".$v['name']."</option>";
						}
						?>
					</select>
					<input type="text" name="name" placeholder="Movie Title">
					<input type="number" name="databaseid" placeholder="ID api">
					<input type="number" name="price" placeholder="Price">
					<input type="number" name="stock" placeholder="Stock">
					<input type="hidden" name="isAdult" value="0">
					<input type="hidden" name="from" value="updateproduct">
					<input type="hidden" name="success" value="admin">
					<button type="submit" class="btn btn-default">Modify</button>
				</form>
			</div>
		</main>
		<?php include('components/footer.php'); ?>
	<body>
</html>
