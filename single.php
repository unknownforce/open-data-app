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
	
	include 'includes/index-top.php';

?>

	<div id="header"><img src="images/tcl-title.png" alt="Tennis Court Locator Logo"></div>
	
	<div id="court-info">
		<div class="ratings">
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
				<li class="tennis-rater-lvl"><a href="rate.php?id=<?php echo $results['id']; ?>&rate=<?php echo $i; ?>">★</a></li>
				<?php endfor; ?>
			</ol>
			
			<?php endif; ?>
		</div>
        
        <div id="disqus_thread"></div>
		<script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'tc-locator'; // required: replace example with your forum shortname
        	var disqus_developer = 1; // developer mode is on
            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
        
	</div>
	
<?php
	include 'includes/index-bottom.php';
?>