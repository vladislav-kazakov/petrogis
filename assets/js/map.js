
function initMap() {
    var map_center = new google.maps.LatLng(50.2, 87.5);
    if ($.cookie("map_center") != undefined) {
        cookie_map_center = new google.maps.LatLng(JSON.parse($.cookie("map_center")));
        if ( !isNaN(cookie_map_center.lat()) && !isNaN(cookie_map_center.lng()) )
            map_center = cookie_map_center;
    }

    var zoom = 8;
    if ($.cookie("map_zoom") && !isNaN(Number($.cookie("map_zoom"))) ) zoom = Number($.cookie("map_zoom"));

    var type_id = "hybrid";
    if ($.cookie("map_type") && ($.cookie("map_type")=='hybrid' || $.cookie("map_type") == 'satellite' || $.cookie("map_type") == 'terrain'))
        type_id = $.cookie("map_type");

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        center: map_center,
        zoom: zoom,
        mapTypeId: type_id

    });
/*
    // Insert this overlay map type as the first overlay map type at
    // position 0. Note that all overlay map types appear on top of
    // their parent base map.
    map.overlayMapTypes.insertAt(
        0, new CoordMapType(new google.maps.Size(256, 256)));

    function CoordMapType(tileSize) {
        this.tileSize = tileSize;
    }

    CoordMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
        var div = ownerDocument.createElement('div');
        div.innerHTML = coord;
        div.style.width = this.tileSize.width + 'px';
        div.style.height = this.tileSize.height + 'px';
        div.style.fontSize = '10';
        div.style.borderStyle = 'solid';
        div.style.borderWidth = '1px';
        div.style.borderColor = '#AAAAAA';
        return div;

    }

    var imageBounds = {
        north: 49.918681,
        south: 49.912654,
        west: 88.059093,
        east: 88.078952
    };

    yandexOverlay = new google.maps.GroundOverlay(
        'assets/img/map2.png',
        imageBounds);
    yandexOverlay.setMap(map);
    yandexOverlay.setOpacity(1.0);
*/
    map.addListener('center_changed', function() {
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        var expires = ";expires="+ d.toUTCString();

        document.cookie = "map_center=" + JSON.stringify(map.getCenter().toJSON()) + expires + ";path=/";
        //console.log(document.cookie);
    });
    map.addListener('zoom_changed', function() {
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        var expires = ";expires="+ d.toUTCString();

        document.cookie = "map_zoom=" + map.zoom + expires + ";path=/";
        //console.log(document.cookie);
    });
    map.addListener('maptypeid_changed', function() {
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        var expires = ";expires="+ d.toUTCString();

        document.cookie = "map_type=" + map.getMapTypeId() + expires + ";path=/";
    } );
    initialize_markers(arr);
/*    map.addListener('projection_changed', function() {
        var coord1 = {lat: 49.918631, lng: 88.059193};
        var coord2 = {lat: 49.912604, lng: 88.079052};
        var projection = map.getProjection();
        var point = projection.fromLatLngToPoint(new google.maps.LatLng(coord1.lat, coord1.lng));
        console.log(point);
        var bounds = {
            17: [[PixelsToTile(LatLngToPixels(coord1, 17)).x, PixelsToTile(LatLngToPixels(coord2, 17)).x], [PixelsToTile(LatLngToPixels(coord1, 17)).y, PixelsToTile(LatLngToPixels(coord2, 17)).y]],
            18: [[PixelsToTile(LatLngToPixels(coord1, 18)).x, PixelsToTile(LatLngToPixels(coord2, 18)).x], [PixelsToTile(LatLngToPixels(coord1, 18)).y, PixelsToTile(LatLngToPixels(coord2, 18)).y]],
            19: [[PixelsToTile(LatLngToPixels(coord1, 19)).x, PixelsToTile(LatLngToPixels(coord2, 19)).x], [PixelsToTile(LatLngToPixels(coord1, 19)).y, PixelsToTile(LatLngToPixels(coord2, 19)).y]],
            20: [[PixelsToTile(LatLngToPixels(coord1, 20)).x, PixelsToTile(LatLngToPixels(coord2, 20)).x], [PixelsToTile(LatLngToPixels(coord1, 20)).y, PixelsToTile(LatLngToPixels(coord2, 20)).y]]
        };


        var imageMapType = new google.maps.ImageMapType({
            getTileUrl: function(coord, zoom) {
                if (zoom < 17 || zoom > 20 ||
                    bounds[zoom][0][0] > coord.x || coord.x > bounds[zoom][0][1] ||
                    bounds[zoom][1][0] > coord.y || coord.y > bounds[zoom][1][1]) {
                    return null;
                }

                return "assests/img/map2.png";
            },

            tileSize: new google.maps.Size(256, 256)
        });
        map.overlayMapTypes.push(imageMapType);

    } );*/

}

function initialize_markers(arr){
var markers = [];
for (var i =0; i<arr.length; i++)
{

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(arr[i]["lat"], arr[i]["lng"]),
        map: map,
        title: arr[i]["name"]
    });
    markers.push(marker);
    var infowindow = new google.maps.InfoWindow();
    //открывает infowindows при наведении курсора мыши
    marker.addListener('mouseover', (function(marker, infowindow, info) {
        return function() {
            var img_str = info["image"] != null ? '<div class="div-infowindow"><img class="img-infowindow" src="' + info["image"] + '"></div>':""
            infowindow.setContent('<p>' + info["name"]+'</p>' + img_str);
            infowindow.open(map, marker);
        }
    })(marker, infowindow, arr[i]));
    marker.addListener('mousedown', (function(marker, infowindow, info) {
        return function() {
            var img_str = info["image"] != null ? '<div class="div-infowindow"><img class="img-infowindow" src="' + info["image"] + '"></div>':""
            infowindow.setContent('<p>' + info["name"]+'</p>' + img_str);
            infowindow.open(map, marker);
        }
    })(marker, infowindow, arr[i]));
    //закрывает infowindows при отведении курсора мыши
    marker.addListener('mouseout', (function(marker, infowindow) {
        return function() {
            infowindow.close(map, marker);
        }
    })(marker, infowindow));
    marker.addListener('click', (function(marker, infowindow, info) {
        return function() {
            window.location.href = "petroglyph/" + info['id'];
        }
    })(marker, infowindow, arr[i]));
}
var markerClusterer = new MarkerClusterer(map, markers,
    {
        imagePath: '/assets/js/markerclusterer/images/m',
        maxZoom: 17,
        gridSize: 20,
        styles: null
    });
}