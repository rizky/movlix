#!/usr/bin/php
<?php
	require_once('models/products.php');
	require_once('models/categories.php');
	require_once('models/prod_has_cat.php');
	require_once('models/user.php');
	require_once('models/hash.php');
	// $hostname = "127.0.0.1"; //for debugging
	$hostname = "db";
	$user = "root";
	$pass = "root";

	$mysqli = mysqli_connect($hostname, $user, $pass);
	if (mysqli_connect_errno($mysqli))
	{
		echo "Failed to connect to database : " . mysqli_connect_error();
		$db = (NULL);
	}
	$db = $mysqli;
	$sql = "DROP DATABASE `rush`;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));

	$sql = "CREATE DATABASE `rush`;";
	$req = mysqli_query($db, $sql);

	var_dump(mysqli_error($db));

	$db = database_connect();
	$sql = "CREATE DATABASE `rush`;";
	$req = mysqli_query($db, $sql);

	$db = database_connect();
	$sql = "SET FOREIGN_KEY_CHECKS=0;";
	$req = mysqli_query($db, $sql);

	$sql = "CREATE TABLE `categories`(
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(45) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `id_UNIQUE` (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));

	$sql = "CREATE TABLE `orders` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`date_order` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`peoples_id` int(10) unsigned NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `id_UNIQUE` (`id`),
			KEY `fk_orders_peoples1_idx` (`peoples_id`),
			CONSTRAINT `fk_orders_peoples1` FOREIGN KEY (`peoples_id`) REFERENCES `peoples` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
			) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));

	$sql = "CREATE TABLE `orders_has_products` (
			`orders_id` int(10) unsigned NOT NULL,
			`products_id` int(10) unsigned NOT NULL,
			`price` double unsigned NOT NULL,
			`quantity` int(10) unsigned NOT NULL,
			PRIMARY KEY (`orders_id`,`products_id`),
			KEY `fk_orders_has_products_products1_idx` (`products_id`),
			KEY `fk_orders_has_products_orders1_idx` (`orders_id`),
			CONSTRAINT `fk_orders_has_products_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
			CONSTRAINT `fk_orders_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));

	$sql = "CREATE TABLE `peoples` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`username` varchar(45) NOT NULL,
			`email` varchar(255) NOT NULL,
			`password` varchar(300) NOT NULL,
			`isAdmin` tinyint(1) DEFAULT '0',
			`firstname` varchar(45) NOT NULL,
			`lastname` varchar(45) NOT NULL,
			`address` varchar(100) NOT NULL,
			`cookie` varchar(100) DEFAULT NULL,
			`valid` varchar(45) DEFAULT NULL COMMENT 'empty if user is valid\nfilled with a key if user have to get registered',
			PRIMARY KEY (`id`),
			UNIQUE KEY `id_UNIQUE` (`id`),
			UNIQUE KEY `username_UNIQUE` (`username`),
			UNIQUE KEY `email_UNIQUE` (`email`)
			) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));
	
	people_create('admin', 'admin@movlix.com',  'admin123456', 'Admin', 'Movlix', 'Paris', 1);

	$sql = "CREATE TABLE `products` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			`price` double unsigned NOT NULL,
			`databaseid` int(10) unsigned NOT NULL,
			`isAdult` tinyint(1) DEFAULT '0',
			`picture` varchar(50) DEFAULT NULL,
			`stock` int(10) unsigned DEFAULT 10,
			PRIMARY KEY (`id`),
			UNIQUE KEY `id_UNIQUE` (`id`),
			UNIQUE KEY `databaseid_UNIQUE` (`databaseid`)
			) ENGINE=InnoDB AUTO_INCREMENT=3677 DEFAULT CHARSET=utf8;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));

	$sql = "CREATE TABLE `products_has_categories` (
			`products_id` int(10) unsigned NOT NULL,
			`categories_id` int(10) unsigned NOT NULL,
			PRIMARY KEY (`products_id`,`categories_id`),
			KEY `fk_products_has_categories_categories1_idx` (`categories_id`),
			KEY `fk_products_has_categories_products_idx` (`products_id`),
			CONSTRAINT `fk_products_has_categories_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
			CONSTRAINT `fk_products_has_categories_products` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$req = mysqli_query($db, $sql);
	var_dump(mysqli_error($db));

	$db = database_connect();
	$req = mysqli_query($db, $req);
	$api_key = '?api_key=48c1e38beaccdbb33002349cb57e5d60';
	$request_base = 'http://api.themoviedb.org/3/movie/';
	$time = microtime(TRUE);
	echo "\nFilling movie database. This may take several minutes<br \>\n";
	$start = 500;
	$max = $start + 10;
	$movieids = array();
	
	for ($i = $start; $i < $max; $i++)
	{
		$movieids[] = $i;
	}
	$movieids[] = 399055;
	$movieids[] = 272;
	$movieids[] = 297762;
	$movieids[] = 181808;
	$movieids[] = 198663;
	$movieids[] = 13230;
	$movieids[] = 7453;
	$movieids[] = 13230;
	for ($i = 0; $i < count($movieids); $i++)
	{
		$ids = $movieids[$i];
		$price = (float)(mt_rand(80, 260) / 10);
		$a = @file_get_contents($request_base . $ids . $api_key);
		if ($a)
			$data = (array)json_decode($a);
		else
		{
			$max++;
			$data = NULL;
		}
		if ($data)
		{
			if (isset($data['status_code']) && $data['status_code'] != 1)
				echo 'The API returned an error :' . $data['status_message'] . '\n';
			else
			{
				$genre = ((array)((array)($data['genres'])[0]))['name'];
				$price = (mt_rand(80, 300) / 10);
				if ($genre && !category_get($genre))
				{
					category_create($genre);
				}
				$isAdult = $data['adult'] ? 1 : 0;
				$ret = product_create($data['original_title'], $data['poster_path'], $isAdult, $price, $ids);
				if ($ret === TRUE && $genre)
				{
					$cat = category_get($genre);
					if ($cat)
					{
						$prod = product_get_byname($data['original_title']);
						category_add_toprod($cat['id'], $prod['id']);
					}
				}
			}
		}
		if ($i % 40 == 0)
		{
			$wait = 1000 + $time - microtime(true);
			if ($wait > 0)
				usleep($wait);
			$time = microtime(TRUE);
		}
	}
?>