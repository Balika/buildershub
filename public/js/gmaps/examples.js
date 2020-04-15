$(function ()
{
    $('#map').gMap();

    $('#map_controls').gMap(
            {
                latitude: 5.6273266,
                longitude: -0.087395,
                maptype: 'HYBRID', // 'HYBRID', 'SATELLITE', 'ROADMAP' or 'TERRAIN'
                zoom: 8,
                controls: {
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                    streetViewControl: false,
                    overviewMapControl: false
                }
            });


    // Detect user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position)
        {
            $('#map_controls').gMap('addMarker', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                content: 'You are here!',
                icon: {
                    image: "images/gmap_pin.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                },
                popup: true
            });
            $('#map_controls').gMap('centerAt', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                zoom: 8
            });
        }, function ()
        {
            //console.log('Couldn\'t find you :(');
        });
    }

    $('#map_addresses').gMap({
        address: "Batsoona Total, Ghana",
        zoom: 5,
        markers: [
            {
                latitude: 5.6273266,
                longitude: -0.087395,
                html: "_latlng"
            },
            {
                address: "Guayaquil, Ecuador",
                html: "My Hometown",
                popup: true
            },
            {
                address: "Galapagos, Ecuador",
                html: "_address"
            }
        ]
    });

    $("#map_extended").gMap({
        controls: true,
        scrollwheel: true,
        maptype: 'HYBRID',
        markers: [
            {
                latitude: 5.6273266,
                longitude: -0.087395,
                icon: {
                    image: "images/gmap-pin-red.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                }
            },
            {
                latitude: 47.65197522925437,
                longitude: 9.47845458984375
            },
            {
                latitude: 47.594996,
                longitude: 9.600708,
                icon: {
                    image: "images/gmap-pin-green.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                }

            }

        ],
        icon: {
            image: "images/gmap-pin-blue.png",
            iconsize: [26, 46],
            iconanchor: [12, 46]
        },
        latitude: 47.58969,
        longitude: 9.473413,
        zoom: 10
    });





    $('#map_controls_hybrid').gMap(
            {
                latitude: -2.206,
                longitude: -79.897,
                maptype: 'HYBRID', // 'HYBRID', 'SATELLITE', 'ROADMAP' or 'TERRAIN'
                zoom: 8,
                controls: {
                    panControl: true,
                    zoomControl: false,
                    mapTypeControl: true,
                    scaleControl: false,
                    streetViewControl: false,
                    overviewMapControl: false
                }
            });


    // Detect user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position)
        {
            $('#map_controls_hybrid').gMap('addMarker', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                content: 'You are here!',
                icon: {
                    image: "images/gmap_pin.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                },
                popup: true
            });
            $('#map_controls_hybrid').gMap('centerAt', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                zoom: 8
            });
        }, function ()
        {
            //console.log('Couldn\'t find you :(');
        });
    }






    $('#map_controls_satellite').gMap(
            {
                latitude: -2.206,
                longitude: -79.897,
                maptype: 'SATELLITE', // 'HYBRID', 'SATELLITE', 'ROADMAP' or 'TERRAIN'
                zoom: 8,
                controls: {
                    panControl: true,
                    zoomControl: false,
                    mapTypeControl: true,
                    scaleControl: false,
                    streetViewControl: false,
                    overviewMapControl: false
                }
            });


    // Detect user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position)
        {
            $('#map_controls_satellite').gMap('addMarker', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                content: 'You are here!',
                icon: {
                    image: "images/gmap_pin.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                },
                popup: true
            });
            $('#map_controls_satellite').gMap('centerAt', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                zoom: 8
            });
        }, function ()
        {
            //console.log('Couldn\'t find you :(');
        });
    }




    $("#map_extended_full").gMap({
        controls: false,
        scrollwheel: true,
        maptype: 'TERRAIN',
        markers: [
            {
                latitude: 47.670553,
                longitude: 9.588479,
                icon: {
                    image: "images/gmap-pin-red.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                }
            },
            {
                latitude: 47.65197522925437,
                longitude: 9.47845458984375
            },
            {
                latitude: 47.594996,
                longitude: 9.600708,
                icon: {
                    image: "images/gmap-pin-green.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                }
            }
        ],
        icon: {
            image: "images/gmap-pin-blue.png",
            iconsize: [26, 46],
            iconanchor: [12, 46]
        },
        latitude: 47.58969,
        longitude: 9.473413,
        zoom: 10
    });







});
