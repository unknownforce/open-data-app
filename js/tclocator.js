$(document).ready(function() {
	
	var gMap = {
		center : new google.maps.LatLng(45.424871,-75.699706)
		, zoom : 12
		, mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById('map'), gMap);
	
	var infoWindow;
	
	$('.results ol li').each(function () {
	
		var tennis = $(this).find('a').html();
	console.log(tennis);
		var info ='<div class="info-window">'
			+ '<strong>' + tennis + '</strong>'
			+ '</div>'
		;
	
		var latitude = $(this).find('meta[itemprop="latitude"]').attr('content');
		var longitude = $(this).find('meta[itemprop="longitude"]').attr('content');
		var position = new google.maps.LatLng(latitude, longitude);
		
		console.log(position);
		
		var marker = new google.maps.Marker({
			position : position,
			map : map,
			title : tennis,
			icon : 'images/tcl-icon.png',
			animation: google.maps.Animation.DROP		
		});
	
		function showInfoWindow (ev) {
			if (ev.preventDefault) {
				ev.preventDefault();	
			}
			
			if (infoWindow) {
				infoWindow.close();	
			}
			
			infoWindow = new google.maps.InfoWindow({
				content : info
			});
			
			infoWindow.open(map, marker);
		}
		
		google.maps.event.addListener(marker, 'click', showInfoWindow);
		google.maps.event.addDomListener($(this).find('a').get(0), 'click', showInfoWindow);	
	});
});