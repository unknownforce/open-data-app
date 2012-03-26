<?php
	require_once 'includes/db.php';
	
	$results = $db->query('
		SELECT id, name, longitude, latitude, street_address, rate_count, rate_total FROM tenniscourtlocator
		ORDER BY id ASC
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
					<?php 
						
						if ($tenniscourts['rate_count'] > 0) {
							$rating = round($tenniscourts['rate_total'] / $tenniscourts['rate_count']);
						} else {
							$rating = 0;	
						}
					?>
						<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $tenniscourts['id']; ?>">
							<h3><a href="single.php?id=<?php echo $tenniscourts['id']; ?>" itemprop="name"><?php echo $tenniscourts['name']; ?></a></h3>
							<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
								<meta itemprop="latitude" content="<?php echo $tenniscourts['latitude']; ?>">
								<meta itemprop="longitude" content="<?php echo $tenniscourts['longitude']; ?>">
							</span>
							<meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter>
							<ol class="tennis-rater">
							<?php for ($i = 1; $i <= 5; $i++) : ?>
								<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
								<li class="tennis-rater-lvl <?php echo $class; ?>">★</li>
							<?php endfor; ?>
							</ol>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</article>				
	</section>
	
<?php
	include 'includes/index-bottom.php';
?>