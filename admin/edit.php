<?php
	require_once '../includes/db.php';
	$errors = array();
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');
		exit;	
	}
	
	$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	$street_address = filter_input(INPUT_POST, 'street_address', FILTER_SANITIZE_STRING);
	$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
	$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if (empty($name)) {
			$errors['name'] = true;	
		}
		
		if (empty($street_address)) {
			$errors['street_address'] = true;	
		}
		
		if (empty($errors)) {
			
			
			$sql = $db->prepare('
				UPDATE tenniscourtlocator
				SET name = :name, street_address = :street_address, longitude = :longitude, latitude = :latitude
				WHERE id = :id
			');	
			
			$sql->bindValue(':name', $name, PDO::PARAM_STR);
			$sql->bindValue(':street_address', $street_address, PDO::PARAM_STR);
			$sql->bindValue(':latitude', $latitude, PDO::PARAM_STR);
			$sql->bindValue(':longitude', $longitude, PDO::PARAM_STR);
			$sql->bindValue(':id', $id, PDO::PARAM_INT);
			$sql->execute();
			
			header('Location: index.php');
			exit;
		}
		
	}else{
		
		$sql = $db->prepare('
			SELECT id, name, street_address, longitude, latitude
			FROM tenniscourtlocator
			WHERE id = :id
		');
		
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->execute();
		$results = $sql->fetch();
		
		$name = $results['name'];
		$street_address = $results['street_address'];
		$longitude = $results['longitude'];
		$latitude = $results['latitude'];	
	}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Edit a <?php echo $name; ?></title>
	<link href="../css/admin.css" rel="stylesheet">
</head>

<body>
	<div id="header"><img src="../images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<div id="map"><img src="../images/map.png" alt="Tennis Court Google Map" width="974" height="645"><div>
	

	<article class="edit-info">
		<form method="post" action="edit.php?id=<?php echo $id; ?>">
			<div>
				<label for="name">Tennis Court Name<?php if (isset($errors['name'])) : ?> <strong> is required</strong><?php endif; ?></label>
				<input id="name" name="name" value="<?php echo $name; ?>" required>
			</div>
			<div>
				<label for="street_address">Street Address<?php if(isset($errors['street_address'])) : ?> <strong> is required</strong><?php endif; ?></label>
				<input id="street_address" name="street_address" value="<?php echo $street_address; ?>" required>
			</div>
            <div>
				<label for="longitude">Longitude<?php if(isset($errors['longitude'])) : ?> <strong> is required</strong><?php endif; ?></label>
				<input id="longitude" name="longitude" value="<?php echo $longitude; ?>" required>
			</div>
            <div>
				<label for="latitude">Latitude<?php if(isset($errors['latitude'])) : ?> <strong> is required</strong><?php endif; ?></label>
				<input id="latitude" name="latitude" value="<?php echo $latitude; ?>" required>
			</div>
            
			<button type="submit">Edit</button>
		</form>
	</article>
</body>
</html>