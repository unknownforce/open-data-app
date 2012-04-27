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
	
	if (!user_is_signed_in()) {
		header('Location: sign-in.php');
		exit;	
	}

	require_once '../includes/db.php';
	
	$results = $db->query('
		SELECT id, name, longitude, latitude, street_address FROM tenniscourtlocator
		ORDER BY id ASC
	');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Tennis Court Locator - Admin</title>
	<link href="../css/admin.css" rel="stylesheet">
	<script src="../js/modernizr.dev.js"></script>
</head>

<body>
	<div id="header"><img src="../images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<section>
		<div id="map"></div>
		
		<article>
			<p class="sign-out"><a href="sign-out.php">Sign Out</a></p>
			<nav>
				<a href="add.php">Add a Tennis Court</a>
			</nav>
			
			<div class="results">
				<ol>
					<?php foreach ($results as $tenniscourts) : ?>
						<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $tenniscourts['id']; ?>">
							<h3><a href="single.php?id=<?php echo $tenniscourts['id']; ?>" itemprop="name"><?php echo $tenniscourts['name']; ?></a></h3>
							<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
								<meta itemprop="latitude" content="<?php echo $tenniscourts['latitude']; ?>">
								<meta itemprop="longitude" content="<?php echo $tenniscourts['longitude']; ?>">
							</span>
							<p>
								<a href="edit.php?id=<?php echo $tenniscourts['id']; ?>">Edit</a>
								<a href="delete.php?id=<?php echo $tenniscourts['id']; ?>">Delete</a>
							</p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</article>
	
	</section>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAq1LN-YdGsIcRgf074Vtwmj2j3GoAbrCo&sensor=false"></script>
	<script src="../js/tclocator.js"></script>
</body>
</html>
