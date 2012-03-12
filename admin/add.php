<?php
	
	$errors = array();
	
	$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	$street_address = filter_input(INPUT_POST, 'street_address', FILTER_SANITIZE_STRING);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (empty($name)) {
			$errors['name'] = true;	
		}
		
		if (empty($street_address)) {
			$errors['street_address'] = true;	
		}
		
		if (empty($errors)) {
			require_once '../includes/db.php';
			
			$sql = $db->prepare('
				INSERT INTO tenniscourtlocator (name, street_address)
				VALUES (:name, :street_address)
			');	
			
			$sql->bindValue(':name', $name, PDO::PARAM_STR);
			$sql->bindValue(':street_address', $street_address, PDO::PARAM_STR);
			$sql->execute();
			
			header('Location: index.php');
			exit;
		}
	}


?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Add a Tennis Court</title>
	<link href="../css/admin.css" rel="stylesheet">
</head>

<body>
	<div id="header"><img src="../images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<div id="map"><img src="../images/map.png" alt="Tennis Court Google Map" width="974" height="645"><div>
	
	<article class="edit-info">
		<form method="post" action="add.php">
			<div>
				<label for="name">Tennis Court Name<?php if (isset($errors['name'])) : ?> <strong> is required</strong><?php endif; ?></label>
				<input id="name" name="name" value="<?php echo $name; ?>" required>
			</div>
			<div>
				<label for="street_address">Street Address<?php if(isset($errors['street_address'])) : ?> <strong> is required</strong><?php endif; ?></label>
				<input id="street_address" name="street_address" value="<?php echo $street_address; ?>" required>
			</div>
			<button type="submit">Add</button>
		</form>
	</article>
</body>
</html>