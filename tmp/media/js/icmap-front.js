/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-06-08
 * @since       1.0
 *------------------------------------------------------------------------------
*/

var lat
var lng
var id

function iCmapToolTip(marker, message, mapid) {
	var infowindow = new google.maps.InfoWindow({content: message});
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(mapid,marker);
	});
}

function initialize(lat, lng, id){
	var latlng = new google.maps.LatLng(lat, lng);
	var mapOptions = {
		zoom: 16,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var mapid = 'map'+id;
	var mapid = new google.maps.Map(document.getElementById('map_canvas'+id), mapOptions);

	var geocoder = new google.maps.Geocoder();

	// Marker
	// Note: Marker shadows were removed in version 3.14 of the Google Maps JavaScript API.
	// Any shadows specified programmatically will be ignored.
	var icagendaimage = new google.maps.MarkerImage('http://www.google.com/mapfiles/marker.png',
		new google.maps.Size(40, 35),
		new google.maps.Point(0,0),
		new google.maps.Point(20, 35));
//	var shadow = new google.maps.MarkerImage('http://www.google.com/mapfiles/shadow50.png',
//		new google.maps.Size(62, 35),
//		new google.maps.Point(0,0),
//		new google.maps.Point(20, 35));
	var shape = {
		coord: [1, 1, 1, 40, 40, 40, 40, 1],
		type: 'poly'
	};

	var marker = new google.maps.Marker({
		map: mapid,
//		shadow: shadow,
//		icon: icagendaimage,
//		shape: shape,
		draggable: false,
		position: latlng
	});

	// In Dev. : displays tooltip with info of the event
//	var title = 'title test';
//	var desc = 'description test';

//	marker.setTitle('title'.toString());
//	iCmapToolTip(marker, '<div>'+title+'</div><div>'+desc+'</div>', mapid);
}

