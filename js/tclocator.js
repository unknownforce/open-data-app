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
		
		$('.results > ol > li').each(function () {
		
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
				'position' : position,
				'map' : map,
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
			google.maps.event.addDomListener($(this).find('h3 a').get(0), 'click', showInfoWindow);	
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
	
	
	// Geo-Location
	
	var userMarker;
	
	function displayUserLoc (latitude, longitude) {
		var locDistances = []
		, totalLocs = locations.length
		, userLoc = new google.maps.LatLng(latitude, longitude);
		
		;
		
		if (userMarker) {
			userMarker.setPosition(userLoc);	
		} else {
			userMarker = new google.maps.Marker({
				position : userLoc
				, map : map
				, title : 'You are Here.'
				, icon : 'images/tcl-user.png'
				, animation : google.maps.Animation.DROP		
			});
		
		}
		
		map.setCenter(userLoc);
		
		var current = new LatLon(latitude, longitude);
		
		for (var i = 0; i < totalLocs; i++) {
			locDistances.push({
				id : locations[i].id
				, distance : parseFloat(current.distanceTo(new LatLon(locations[i].latitude, locations[i].longitude)))
			});
		}
		
		locDistances.sort(function (a, b) {
			return a.distance - b.distance;
		});
		
		var $tennisList = $('.results > ol');
		
		for (var j = 0; j< totalLocs; j++) {
			var $li = $tennisList.find('[data-id="' + locDistances[j].id + '"]');
			
			$li.find('.distance').html(locDistances[j].distance.toFixed(1) + ' km');	
			
			$tennisList.append($li);
		}
		
	}
		
		
		if (navigator.geolocation) {
			$('#geo').click(function () {
				navigator.geolocation.getCurrentPosition(function (position) {
					displayUserLoc(position.coords.latitude, position.coords.longitude);
				});
				
			});
		}
		
		$('#geo-form').on('submit', function (ev) {
			ev.preventDefault();
			
			var geocoder = new google.maps.Geocoder();
			
			geocoder.geocode({
				address : $('#address').val() + ', Ottawa, ON'
				, region : 'CA'
				
			}, function (results, status) {
					if (status == google.maps.GeocoderStatuse.OK) {
						displayUserLoc(results[0].geometry.location.latitude(), results[0].geometry.location.longitude());	
					}
				}
			);
		
		});
		
		var ratingsTennis = '';
		var indoorsTennis = '';
		var outdoorsTennis = '';
		
		$('.ratings').on('click', function (ev) {
			ev.preventDefault();
			if (!ratingsTennis) {
				$('.results > ol').load('ratings.php', {}, function (data) {
					ratingsTennis = data;
				});
			} else {
				$('.results > ol').html(ratingsTennis);
			}	
		});
		
		$('.indoors').on('click', function (ev) {
			ev.preventDefault();
			
			if (!indoorsTennis) {
				$('.results > ol').load('indoors.php', {}, function (data) {
					indoorsTennis = data;	
				});
			} else {
				$('.results > ol').html(indoorsTennis);
			}
			
		});
		
		$('.outdoors').on('click', function (ev) {
			ev.preventDefault();
			
			if (!outdoorsTennis) {
				$('.results > ol').load('outdoors.php', {}, function (data) {
					outdoorsTennis = data;	
				});	
			} else {
				$('.results > ol').html(outdoorsTennis);
			}
			
		});
		
});