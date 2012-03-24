<?php
	
	$user = getenv('DB_USER'); 
	$pass = getenv('DB_PASS');
	$dsn = stripslashes(getenv('DB_DSN'));

	$db = new PDO($dsn, $user, $pass);

	$db->exec('SET NAMES utf8');