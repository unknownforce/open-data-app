<?php
	require_once 'includes/db.php';
	
	
	$results = $db->query('
		SELECT id, name, longitude, latitude, street_address FROM tenniscourtlocator
		ORDER BY id ASC
		LIMIT 21
	');
	
	include 'includes/index-top.php';

?>

	<div id="header"><img src="images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<section>
	
		<div id="map"></div>
		
		<article>
			<nav>
				<button class="ratings">Ratings</button>
				<button class="indoors">Indoors</button>
				<button class="outdoors">Outdoors</button>
			</nav>
			
			<input id="search">
			
			<div class="results">
				<ol>
					<?php foreach ($results as $tenniscourts) : ?>
						<li itemscope itemtype="http://schema.org/TouristAttraction">
							<h3><a href="single.php?id=<?php echo $tenniscourts['id']; ?>" itemprop="name"><?php echo $tenniscourts['name']; ?></a></h3>
							<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
								<meta itemprop="latitude" content="<?php echo $tenniscourts['latitude']; ?>">
								<meta itemprop="longitude" content="<?php echo $tenniscourts['longitude']; ?>">
							</span>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</article>
	
	</section>
	
<?php
	include 'includes/index-bottom.php';
?>