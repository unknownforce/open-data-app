<?php

	require_once 'includes/db.php';
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');	
		exit;
	}
	
	$sql = $db->prepare('
		INSERT INTO tenniscourtlocator (id, rating)
		VALUES (:id, :rating)
	');
	
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	$sql->bindValue(':rating', $rating, PDO::PARAM_INT);
	
	$sql->execute();
	
	header('Location: index.php');
	exit;