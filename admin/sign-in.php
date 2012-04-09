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
	require_once '../includes/users.php';
	require_once '../includes/db.php';
	
	// INPUT_GET is when it's in a query string
	// INPUT_POST is when it's in a form.
	
	if (user_is_signed_in()) {
		header('Location: index.php');
		exit;	
	}
	
	
	$errors = array();
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = true;	
		}
		
		if (empty($password)) {
			$errors['password'] = true;	
		}
		
		if (empty($errors)) {
			$user = user_get($db, $email);	
			
			if (!empty($user)) {
				if (passwords_match($password, $user['password'])) {
					user_sign_in($user['id']);
					header('Location: index.php');
					exit;
				} else {
					$errors['password-no-match'] = true;	
				}
			} else {
				$errors['user-non-existent'] = true;
			}
		}
	}
?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign in</title>
	<link href="../css/admin.css" rel="stylesheet">
</head>

<body>

	<div id="header"><img src="../images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	
	<form id="sign-in" method="post" action="sign-in.php">
		<div>
			<h1>Sign in</h1>
		</div>
		<div>
			<label for="email">E-mail Address</label>
			<input type="email" id="email" name="email" required>
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" id="password" name="password" required>
		</div>
		<div>
		<button type="submit">Sign In</button>
		</div>
	</form>
</body>
</html>