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
	// A self-contained file that holds all the functions we need for user authentication
	
	function user_create ($db, $email, $password) {
		$hashed_password = get_hashed_password($password);
		
		$sql = $db->prepare('
			INSERT INTO users (email, password)
			VALUES (:email, :password)
		');
		
		$sql->bindValue(':email', $email, PDO::PARAM_STR);
		$sql->bindValue(':password', $hashed_password, PDO::PARAM_STR);
		$sql->execute();
		
		// checks to see what the problem is
		// var_dump($sql->errorInfo());
	}
	
	function get_hashed_password ($password) {
		// Generates a random salt to be stored with the password
		// It helps with security and the Blowfish Algorithm requires it
		$rand = substr(strtr(base64_encode(openssl_random_pseudo_bytes(16)), '+', '.'), 0, 22);
		$salt = '$2a$12$' . $rand;
		
		return crypt($password, $salt);
	}
	
	function user_is_signed_in() {
		session_start();
		
		if (isset($_SESSION['id']) && !empty($_SESSION['id']) && isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] == get_fingerprint($_SESSION['id'])) {
			return true;
		}
		
		return false;
		
	}
	
	function get_fingerprint($id) {
		return sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] .  $id . session_id());	
	}
	
	function user_get($db, $email) {
		$sql = $db->prepare('
			SELECT id, email, password
			FROM users
			WHERE email = :email
		');
		
		$sql->bindValue(':email', $email, PDO::PARAM_STR);
		$sql->execute();
		
		return $sql->fetch();
	}
	
	function passwords_match($password, $stored_hash) {
		return crypt($password, $stored_hash) == $stored_hash;	
	}
	
	function user_sign_in ($id) {
		session_regenerate_id();
		
		$_SESSION['id'] = $id;
		$_SESSION['fingerprint'] = get_fingerprint($id);
	}
	
	function user_sign_out () {
		session_start();
		$_SESSION = array();
		session_destroy();	
	}