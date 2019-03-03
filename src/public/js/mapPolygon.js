// $('#mapid').height(window.innerHeight);

var wifiRM = L.layerGroup();
var municipiRM = L.layerGroup();

var mapUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

var streets = L.tileLayer(mapUrl, { id: 'mapbox.streets' }),
    satellite = L.tileLayer(mapUrl, { id: 'mapbox.satellite' });

var map = L.map('mapid', {
    center: [41.90538325169503, 12.466210126876831],
    zoom: 11,
    layers: [satellite, streets],
    zoomControl: false
});

var baseLayers = {
    "Satellite": satellite,
    "Streets": streets,
};

var overlays = {
    "WiFi(RM)": wifiRM,
    "Municipi(RM)": municipiRM
};
L.control.layers(baseLayers, overlays).addTo(map);

// map.doubleClickZoom.disable();
// map.boxZoom.disable();
// map.keyboard.disable();
// $(".leaflet-control-zoom").css("visibility", "hidden");
var marker = L.marker([ 41.9064,12.4132]).addTo(map);
map.on('click',function(e){
    var newMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    L.Routing.control({
        waypoints: [
            L.latLng(41.9064,12.4132),
            L.latLng(e.latlng.lat,e.latlng.lng)
    ]}).on('routesfound', function(e){
        var routes = e.routes;
        // alert('Found' + routes.length + 'route(s).');
        console.log(routes);
        e.routes[0].coordinates.forEach(function(coord,index){
            setTimeout(function(){
                marker.setLatLng([coord.lat,coord.lng]);
            },100*index)

        })
    }).addTo(map);
});

//PLUGIN---DRAW-CONTROL-------------------------------------------------------------------------------------------------------------------------------------------------
var featureGroup = new L.FeatureGroup();
map.addLayer(featureGroup);

var drawControl = new L.Control.Draw({
    position: 'topleft',
    draw: {
        circlemarker: false,
    },
    edit: {
        featureGroup: featureGroup,
        zoom: false,
    }
});
map.addControl(drawControl);

map.on('draw:created', function(e) {
    featureGroup.addLayer(e.layer);
});
//-----------------------------------------------------------------------------------------------------------------------------------------------------------;
// document.getElementById('salva').setAttribute('download', 'JSONData');

$(document).ready(function() {
    // $('#slide-in').height(window.innerHeight);
    $('#salva').on('click', function() {
        debugger;
        var dataMap = featureGroup.toGeoJSON();
        var JSONData = JSON.stringify(dataMap);
        var data = {
            "message": {
                "action": "addPolygon",
                "idUtente": 1,
                "data": JSONData
            }
        }
        dataManagerA.setData(data);
        dataManagerA.send(gestEsitoAdd);
    });

    $('#info').on('click', function() {
        if ($('#slide-in').hasClass('in')) {
            $('#slide-in').removeClass('in')
        } else {
            $('#slide-in').addClass('in')
        }
    });
});


function gestEsitoAdd(dataReturn) {
    if (dataReturn.ESITO.number === 0) {
        infoDialog.showDialog('SUCCESS', 'Poligono Aggiunto', '', infoDialog.errorType.SUCCESS);
    } else {
        infoDialog.showDialog('ERROR', dataReturn.ESITO.description, dataReturn.MESSAGE, infoDialog.errorType.ERROR);
    }
}
console.log(wifi);

var wifiRoma = L.geoJSON(wifi, {
    style: function(feature) {
        return {
            fillOpacity: 0.3,
            fillColor: 'red',
            color: 'red',
            opacity: 0.6,
            weight: 0.3,
        };
    },
    pointToLayer: function(geoJsonPoint, latlng) {
        var html = '';
        for (var prop in geoJsonPoint.properties) {
            html += '<strong>' + prop + '</strong>' + ': ' + geoJsonPoint.properties[prop] + '<br/>';
        }
        return L.circle(latlng, 100).bindPopup(html);
    }
}).addTo(wifiRM);

//Loop to get district
var htmlToAdd = '';
municipi.features.forEach(function(feature) {
    $('#district-select').append('<option value="' + feature.properties.municipio + '">' + feature.properties.quartiere + '</option>')
    
});



var municipiRoma = L.geoJSON(municipi, {
    style: function(feature) {
        return {
            fillOpacity: 0.2,
            fillColor: 'black',
            color: 'black',
            opacity: 0.3,
            weight: 0.5,
        };
    },
    onEachFeature: function(feature, layer) {
        layer.on('mouseover', function() {
            layer.setStyle({ fillOpacity: 0.4 })
            $('#district-information').html(layer.feature.properties.quartiere + '(' + layer.feature.properties.etichetta + ')');
        })
        layer.on('mouseout', function() {
            layer.setStyle({ fillOpacity: 0.2 })
            $('#district-information').html('');
        })
    },
    
}).addTo(municipiRM);


$(document).on('keyup', '#searchWifi', function(e) {
    var userInput = e.target.value;
    wifiRoma.eachLayer(function(layer) {
        
        if (layer.feature.properties.Denominazione.indexOf(userInput) > -1) {
            layer.addTo(wifiRM);
        } else {
            map.removeLayer(layer);
        }
        console.log(layer);
    })
})
$(document).on('keyup', '#searchMunicipio', function(e) {
    var userInput = e.target.value;
    municipiRoma.eachLayer(function(layer) {
        
        if (layer.feature.properties.zone_urb.indexOf(userInput) > -1) {
            layer.addTo(municipiRM);
        } else {
            map.removeLayer(layer);
        }
        console.log(layer);
    })
})
$(document).on('change', '#district-select', function(e) {
    debugger
    var newDistrict = e.target.value;
    if (newDistrict !== '') {
        municipiRoma.eachLayer(function(layer) {
            if (layer.feature.properties.zone_urb === e.target.value) {
                $('#district-information').html(layer.feature.properties.zone_urb + '(' + layer.feature.properties.etichetta + ')');
            }
        });
    } else {
        $('#district-information').html('');
    }
});


//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
