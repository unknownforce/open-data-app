<?php
/**
* Displays the list and map for the Open Data Set
*
* @package Tennis Court Locator
* @copyright 2012 Petrus Chan
* @author Petrus Chan <admin@petruschan.com>
* @link https://github.com/unknownforce/open-data-app
* @license New BSD License
* @version 1.0.0
*/

	// A small utility file for us to create
	// THIS FILE SHOULD NEVER BE PUBLICLY ACCESSIBLE!
	
	require_once 'includes/db.php';
	require_once 'includes/users.php';
	
	$email = 'bradlet@algonquincollege.com';
	$password = 'password';
	
	user_create($db, $email, $password);
	
	