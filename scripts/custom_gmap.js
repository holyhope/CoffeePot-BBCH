/**
 * Created by Pierre Péronnet on 20/10/2015.
 **/

/**
 * Launched when page loaded
 */
google.maps.event.addDomListener(window, 'load', function () {
    const canvas = jQuery("#gmap").find(".canvas")[0];

    function createMap(position) {
        var mapOptions = {
            "zoom": 17,
            "center": position,
            "mapTypeId": google.maps.MapTypeId.ROADMAP,
            "scrollwheel": false,
            "disableDefaultUI": true,
            "styles": [
                {
                    "stylers": [
                        {"saturation": -100}
                    ]
                }, {
                    "featureType": "poi",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                }
            ]
        };
        var map = new google.maps.Map(canvas, mapOptions);
        new google.maps.Marker({
            position: mapOptions.center,
            map: map,
            icon: gmap_values.marker
        });
    }

    function init() {
        if (typeof gmap_values.location == 'undefined') {
            new google.maps.Geocoder().geocode(gmap_values.position, function (results, status) {
                if (google.maps.GeocoderStatus.OK == status) {
                    const location = results[0].geometry.location;
                    createMap(new google.maps.LatLng(location.lat, location.lng));
                } else {
                    console.log(status);
                    setTimeout(init, 500);
                }
            });
        } else {
            createMap(new google.maps.LatLng(gmap_values.location.lat, gmap_values.location.lng));
        }
    }

    init();
});
