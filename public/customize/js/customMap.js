var mapId = "googlemaps";
var latitude = 40.986809;
var longitude = 29.021807;
var mapName = "Zone";
var zoomLevel = 16;
var iconUrl = '';
var scrollable = false;
var disableDefaultUI = false;
var draggableMarker = false;
var marker;
var map;
var contentString = '';
var styles = [
   
];





function initialize() {
    var mapOptions = {
        zoom: zoomLevel,
        scrollwheel: scrollable,
        center: new google.maps.LatLng(40.979743,29.044075,17),
        mapTypeControlOptions: {
            mapTypeIds: [mapName]
        },
        disableDefaultUI: disableDefaultUI,
        panControl: false,
        zoomControl: true,
        scaleControl: true
    };
    var div = document.getElementById(mapId);
    var map = new google.maps.Map(div, mapOptions);
    var styledMapType = new google.maps.StyledMapType(styles, { name: mapName });
    map.mapTypes.set(mapName, styledMapType);
    map.setOptions({styles: styles});



    /***************** MARKER *********************************/
    marker = new google.maps.Marker({
        map:map,
        draggable:draggableMarker,
        icon: iconUrl,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(40.979743,29.044075,17)
    });
    // google.maps.event.addListener(marker, 'click', toggleBounce);


    
}



function toggleBounce() {
    if (marker.getAnimation() != null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

google.maps.event.addDomListener(window, 'load', initialize);