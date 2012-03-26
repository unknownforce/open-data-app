$(document).ready(function() {
	
	var locations = [];
	
	// Tennis Map
	if (document.getElementById('map')) {
		var gMap = {
			center : new google.maps.LatLng(45.424871,-75.699706)
			, zoom : 12
			, mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		var map = new google.maps.Map(document.getElementById('map'), gMap);
		
		var infoWindow;
		
		$('.results li').each(function () {
		
			var tennis = $(this).find('a').html();
		
			var info ='<div class="info-window">'
				+ '<strong>' + tennis + '</strong>'
				+ '<p>' + '<a href="single.php?id=' + $(this).attr('data-id') + '">Rate or Comment!</a>' + '<p>'
				+ '</div>'
			;
		
			var latitude = parseFloat($(this).find('meta[itemprop="latitude"]').attr('content'));
			var longitude = parseFloat($(this).find('meta[itemprop="longitude"]').attr('content'));
			var position = new google.maps.LatLng(latitude, longitude);
			
			locations.push({
				id : $(this).attr('data-id')
				, latitude : latitude
				, longitude : longitude
			});
			
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
			google.maps.event.addDomListener($(this).get(0), 'click', showInfoWindow);	
		});
	
	}
	
	//	Tennis Ratings
	
	var $rateTennisLi = $('.tennis-rating li');
	
	$rateTennisLi
    .on('mouseenter', function (ev) {
      var current = $(this).index();

      for (var i = 0; i < current; i++) {
        $rateTennisLi.eq(i).addClass('rated-hover');
      }
    })
    .on('mouseleave', function (ev) {
      $rateTennisLi.removeClass('rated-hover');
    })
 	;
	
});