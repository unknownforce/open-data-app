<?php
	
	require_once 'includes/db.php';
	
	$places_xml = simplexml_load_file('2009_tennis_courts.kml');
	
	$sql = $db->prepare('
		INSERT INTO tenniscourtlocator (name, longitude, latitude)
		VALUES (:name, :longitude, :latitude)
	');
	
	foreach ($places_xml->Document->Folder[0]->Placemark as $place) {
		$coords = explode(',', trim($place->Point->coordinates));
		
		//$adr = '';
		
		/*
		foreach ($place->ExtendedData->SchemaData->SimpleData as $civic) {
			if ($civic->attributes()->name == 'LEGAL_ADDR') {
				$adr = $civic;	
			}
		}
		*/
		
		$sql->bindValue(':name', $place->name, PDO::PARAM_STR);
		$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
		$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
		//$sql->bindValue(':street_address', $adr, PDO::PARAM_STR);
		$sql->execute();
	}
	
// Lets us to debug errors in our SQL code
// REMOVE FROM PRODUCTION CODE!!
var_dump($sql->errorInfo());