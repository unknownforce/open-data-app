<?php
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($id)) {
		header('Location: index.php');
		exit;	
	}
	
	require_once 'includes/db.php';
	require_once 'includes/functions.php';
	
	$sql = $db->prepare('
		SELECT id, name, longitude, latitude, street_address, rate_count, rate_total
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
	
	$title = $results['name'];
	
	if ($results['rate_count'] > 0) {
		$rating = round($results['rate_total'] / $results['rate_count']);
	} else {
		$rating = 0;	
	}
	
	$cookie = get_rate_cookie();
	
	include 'includes/theme-top.php';

?>

<body>
	<div id="header"><img src="images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<div id="court-info">
		<div class="info">
			<h1><?php echo $results['name']; ?></h1>
			<p class="street"><?php echo $results['street_address']; ?></p>
			<p>Longitude: <?php echo $results['longitude']; ?></p>
			<p>Latitude: <?php echo $results['latitude']; ?></p>
			<p>Average Rating: <meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter></p>
		</div>
		
		<?php if (isset($cookie[$id])) : ?>
		
		<h2>Your Rating</h2>
		<ol class="tennis-rater tennis-rating">
			<?php for ($i = 1; $i <= 5; $i++) : ?>
				<?php $class = ($i <= $cookie[$id]) ? 'is-rated' : ''; ?>
				<li class="tennis-rater-lvl <?php echo $class; ?>">★</li>
			<?php endfor; ?>
		</ol>
		<?php else : ?>
		
		<h2>Rate</h2>
		<ol class="tennis-rater tennis-rating">
			<?php for ($i = 1; $i <= 5; $i++) : ?>
			<li class="tennis-rater-lvl"><a href="rate.php?id=<?php echo $results['id']; ?>&rater=<?php echo $i; ?>">★</a></li>
			<?php endfor; ?>
		</ol>
		
		<?php endif; ?>
	</div>
	
<?php
	include 'includes/theme-bottom.php';
?>