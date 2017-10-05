<div id="map_canvas" style="width:800px; height:600px; float:left; margin-right: 20px;"></div>
<div id="search_container">
    <form method="post">
        <input type="text" name="name" placeholder="название...">
        <button type="submit" name="filter" class="btn btn-default">Показать</button>
    </form>
</div>

<script type="text/javascript" src="assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src = "assets/js/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeYhPhJAnwj95GXDg5BRT7Q2dTj303dQU&callback=initMap"
        type="text/javascript"></script>
<script type="text/javascript" src="assets/js/markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript">
    var arr = <?=$json_petroglyphs?>;
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
                var img_str = info["image"] != null ? '<img src="' + info["image"] + '" width="170" height="120">':""
                infowindow.setContent('<p>' + info["name"]+'</p>' + img_str);
                infowindow.open(map, marker);
            }
        })(marker, infowindow, arr[i]));
        marker.addListener('mousedown', (function(marker, infowindow, info) {
            return function() {
                var img_str = info["image"] != null ? '<img src="' + info["image"] + '" width="170" height="120">':""
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
    }
    var markerClusterer = new MarkerClusterer(map, markers,
        {
            imagePath: 'assets/js/markerclusterer/images/m',
            maxZoom: 17,
            gridSize: 20,
            styles: null
        });
</script>