<?php
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');
		exit;	
	}
	
	require_once '../includes/db.php';
	
	$sql = $db->prepare('
		SELECT id, name, longitude, latitude, street_address
		FROM tenniscourtlocator
		WHERE id = :id
	');
	
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	
	$sql->execute();  
	
	$results = $sql->fetch();
	
	if (empty($results)) {
		header('Location: index.php');
		exit;	
	}

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
	<title><?php echo $results['name']; ?> in Ottawa!</title>
	<link href="../css/admin.css" rel="stylesheet">
</head>

<body>
	<div id="header"><img src="../images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<div id="court-info">
		<div class="info">
			<h1><?php echo $results['name']; ?></h1>
			<p class="street"><?php echo $results['street_address']; ?></p>
			<p>Longitude: <?php echo $results['longitude']; ?></p>
			<p>Latitude: <?php echo $results['latitude']; ?></p>
		</div>
	</div>

</body>
</html>