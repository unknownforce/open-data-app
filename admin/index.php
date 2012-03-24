<?php
	require_once '../includes/db.php';
	
	$results = $db->query('
		SELECT id, name, longitude, latitude, street_address FROM tenniscourtlocator
		ORDER BY id ASC
	');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Tennis Court Locator</title>
	<link href="../css/admin.css" rel="stylesheet">
</head>

<body>
	<div id="header"><img src="../images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<div id="map"><img src="../images/map.png" alt="Tennis Court Google Map" width="974" height="645"><div>
	
	<article>
		<nav>
			<a href="add.php">Add a Tennis Court</a>
		</nav>
		<input id="search">
		
		<div class="results">
			<ol>
				<?php foreach ($results as $tenniscourts) : ?>
					<li>
						<h3><a href="single.php?id=<?php echo $tenniscourts['id']; ?>"><?php echo $tenniscourts['name']; ?></a></h3>
						<p>
							<a href="edit.php?id=<?php echo $tenniscourts['id']; ?>">Edit</a>
							<a href="delete.php?id=<?php echo $tenniscourts['id']; ?>">Delete</a>
						</p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</article>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="js/open-data-app.js"></script>

</body>
</html>