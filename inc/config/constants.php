<?php
	// Root url for the site
	define('ROOT_URL', 'http://localhost/inventory-management-system/');
	
	
	// Database parameters
	// Data source name
	define('DSN', 'mysql:host=localhost:3306;dbname=shop_inventory');
	
	// Hostname
	define('DB_HOST', 'localhost:3306');
	
	// DB user
	define('DB_USER', 'root');
	
	// DB password
	define('DB_PASSWORD','');
	
	// DB name
	define('DB_NAME', 'shop_inventory');
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>