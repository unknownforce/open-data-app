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
	require_once '../includes/filter-wrapper.php';
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');
		exit;	
	}
	
	require_once '../includes/db.php';
	
	$sql = $db->prepare('
		DELETE FROM tenniscourtlocator
		WHERE id = :id
		LIMIT 1
	');
	
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	
	$sql->execute();
	
	header('Location: index.php');
	exit;