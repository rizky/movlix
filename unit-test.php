<?php
	require_once('./models/user.php');
	require_once('./models/hash.php');
	// $key = get_valid_key('admin');
	// people_create('admin', 'admin@movlix.com',  'admin123456', 'Admin', 'Movlix', $key, 1);
	people_get('admin', 'admin123456');
?>
