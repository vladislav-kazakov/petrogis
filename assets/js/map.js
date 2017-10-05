
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
    if ($.cookie("map_type")) type_id = $.cookie("map_type")

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        center: map_center,
        zoom: zoom,
        mapTypeId: type_id

    });
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

    map.addListener('center_changed', function() {
        document.cookie = "map_center=" + JSON.stringify(map.getCenter().toJSON());
        //console.log(document.cookie);
    });
    map.addListener('zoom_changed', function() {
        document.cookie = "map_zoom=" + map.zoom;
        //console.log(document.cookie);
    });
    map.addListener('maptypeid_changed', function() {
        document.cookie = "map_type=" + map.getMapTypeId();
    } );

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