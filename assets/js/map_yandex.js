ymaps.ready(init);
var map;

function init(){
    var map_center = [50.2, 87.5];

    if ($.cookie("map_center") != undefined) {
        cookie_map_center = JSON.parse($.cookie("map_center"));
        if ( !isNaN(cookie_map_center['lat']) && !isNaN(cookie_map_center['lng']) )
            map_center = [cookie_map_center['lat'], cookie_map_center['lng']];
    }

    var zoom = 8;
    if ($.cookie("map_zoom") && !isNaN(Number($.cookie("map_zoom"))) ) zoom = Number($.cookie("map_zoom"));

    var type_id = "yandex#hybrid";
    if ($.cookie("map_type") == 'satellite') type_id = "yandex#sattelite";
    if ($.cookie("map_type") == 'terrain') type_id = "yandex#map";


 /*   map = new ymaps.Map("map_canvas", {
        center: map_center,
        zoom: zoom,
        type: type_id
    }); */

     var options = {
            tileUrlTemplate: "/assets/corona_tiles/%z/%x/%y.png",
            controls: {
                typeControl: true,
                miniMap: false,
                toolBar: false,
                scaleLine: false
            },
            //scrollZoomEnabled: true,
            mapCenter: map_center,
            backgroundMapType: 'yandex#satellite',
            mapZoom: zoom,
            mapID: map_canvas,
            isTransparent: true,
            smoothZooming: false,
            layerKey: "my#layer",
            mapType: {
                name: "Aerophoto + satellite layer",
                textColor: "#000000"
            },
            copyright: ""
        };

    map = (new TilerConverter(options)).getMap();

    map.events.add('boundschange', function() {
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        var expires = ";expires="+ d.toUTCString();

        var cookie_map_center = {'lat': map.getCenter()[0], 'lng': map.getCenter()[1]};
        document.cookie = "map_center=" + JSON.stringify(cookie_map_center) + expires + ";path=/";
        document.cookie = "map_zoom=" + map.getZoom() + expires + ";path=/";
    });
    map.events.add('typechange', function() {
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        var expires = ";expires="+ d.toUTCString();

        if (map.getType() == "yandex#sattelite") document.cookie = "map_type=sattelite" + expires + ";path=/";;
        if (map.getType() == "yandex#hybrid") document.cookie = "map_type=hybrid" + expires + ";path=/";;
        if (map.getType() == "yandex#map") document.cookie = "map_type=terrain" + expires + ";path=/";;
    } );
    initialize_markers(arr);
}
function  initialize_markers(arr){
    var markers = [];
    for (var i =0; i<arr.length; i++) {
        var img_str = arr[i]["image"] != null ? '<div class="div-infowindow"><img class="img-infowindow" src="' + arr[i]["image"] + '"></div>':""
        var marker = new ymaps.Placemark([ parseFloat(arr[i]["lat"]), parseFloat(arr[i]["lng"])], {
            hintContent: '<p>' + arr[i]["name"]+'</p>' + img_str
        });
        map.geoObjects.add(marker);
        markers.push(marker);

        marker.events.add('click', (function(marker, info) {
            return function() {
                window.location.href = "petroglyph/" + info['id'];
            }
        })(marker, arr[i]));

    }

    var clusterer = new ymaps.Clusterer({ clusterDisableClickZoom: true , maxZoom: 17});
    clusterer.add(markers);
    map.geoObjects.add(clusterer);
}

