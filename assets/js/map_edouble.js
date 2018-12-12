function initMap() {
    let name_map_center = 'mped';
    var map_center = new google.maps.LatLng(50.2, 87.5);
    if ($.cookie(name_map_center) != undefined) {
        cookie_map_center = new google.maps.LatLng(JSON.parse($.cookie(name_map_center)));
        if (!isNaN(cookie_map_center.lat()) && !isNaN(cookie_map_center.lng()))
            map_center = cookie_map_center;
    }

    var zoom = 15;
    if ($.cookie("map_zoom") && !isNaN(Number($.cookie("map_zoom")))) zoom = Number($.cookie("map_zoom"));

    var type_id = "hybrid";
    if ($.cookie("map_type") && ($.cookie("map_type") == 'hybrid' || $.cookie("map_type") == 'satellite' || $.cookie("map_type") == 'terrain'))
        type_id = $.cookie("map_type");

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        center: map_center,
        zoom: zoom,
        mapTypeId: type_id

    });

    // todo: update coordinate and check rule
    var mapBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(49.91578533447354, 88.06981615851522),
        new google.maps.LatLng(49.91229957549502, 88.07609658664707));
    var mapMinZoom = 15;
    var mapMaxZoom = 19;

    imageMapType = new google.maps.ImageMapType(
        {
            getTileUrl: function (coord, zoom) {
                var proj = map.getProjection();
                var z2 = Math.pow(2, zoom);
                var tileXSize = 256 / z2;
                var tileYSize = 256 / z2;
                var tileBounds = new google.maps.LatLngBounds(
                    proj.fromPointToLatLng(new google.maps.Point(coord.x * tileXSize, (coord.y + 1) * tileYSize)),
                    proj.fromPointToLatLng(new google.maps.Point((coord.x + 1) * tileXSize, coord.y * tileYSize))
                );
                if (mapBounds.intersects(tileBounds) && (mapMinZoom <= zoom) && (zoom <= mapMaxZoom))
                    return '/assets/google_tiles/' + zoom + '/' + coord.x + '/' + coord.y + '.png';
                else
                    return "https://www.maptiler.com/img/none.png";
            },

            tileSize: new google.maps.Size(256, 256),
            isPng: true,
            alt: "Aero",
            name: "Aero",
            maxZoom: 23
        });
    map.overlayMapTypes.insertAt(0, imageMapType);


    map.addListener('center_changed', function () {
        var d = new Date();
        d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
        var expires = ";expires=" + d.toUTCString();

        document.cookie = name_map_center + "=" + JSON.stringify(map.getCenter().toJSON()) + expires + ";path=/";
        //console.log(document.cookie);
    });
    map.addListener('zoom_changed', function () {
        var d = new Date();
        d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
        var expires = ";expires=" + d.toUTCString();

        document.cookie = "map_zoom=" + map.zoom + expires + ";path=/";
        //console.log(document.cookie);
    });
    map.addListener('maptypeid_changed', function () {
        var d = new Date();
        d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
        var expires = ";expires=" + d.toUTCString();

        document.cookie = "map_type=" + map.getMapTypeId() + expires + ";path=/";
    });
    initialize_markers(arr);

}

function initialize_markers(arr) {
    var markers = [];
    for (var i = 0; i < arr.length; i++) {

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(arr[i]["lat"], arr[i]["lng"]),
            map: map,
            title: arr[i]["name"],
            icon: arr[i]["icon"]
        });
        markers.push(marker);
        var infowindow = new google.maps.InfoWindow();
        //открывает infowindows при наведении курсора мыши
        marker.addListener('mouseover', (function (marker, infowindow, info) {
            return function () {
                var img_str = info["img_src"] != null ? '<div class="div-infowindow"><img class="img-infowindow" src="' + info["img_src"] + '"></div>' : ""
                infowindow.setContent('<p>' + info["name"] + '</p>' + img_str);
                infowindow.open(map, marker);
            }
        })(marker, infowindow, arr[i]));
        marker.addListener('mousedown', (function (marker, infowindow, info) {
            return function () {
                var img_str = info["img_src"] != null ? '<div class="div-infowindow"><img class="img-infowindow" src="' + info["img_src"] + '"></div>' : ""
                infowindow.setContent('<p>' + info["name"] + '</p>' + img_str);
                infowindow.open(map, marker);
            }
        })(marker, infowindow, arr[i]));
        //закрывает infowindows при отведении курсора мыши
        marker.addListener('mouseout', (function (marker, infowindow) {
            return function () {
                infowindow.close(map, marker);
            }
        })(marker, infowindow));
        marker.addListener('click', (function (marker, infowindow, info) {
            return function () {
                if ((!right.length && right.id == info.id) || left.id == info.id) {
                    return false;
                }

                let to = 'left';
                clearPetroglyph(to);
                left = info;
                console.log(left);
                fillPetroglyph(to, info);
            }
        })(marker, infowindow, arr[i]));
        marker.addListener('rightclick', (function (marker, infowindow, info) {
            return function () {
                if ((!left.length && left.id == info.id) || right.id == info.id) {
                    return false;
                }

                let to = 'right';
                clearPetroglyph(to);
                right = info;
                fillPetroglyph(to, info);
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

$('.transfer').click(function () {
    let to = $(this).attr('data-transfer'),
        from = to == 'right' ? 'left' : 'right',
        type = $(this).closest('tr').attr('data-type');

    switch (type) {
        case 'name':
            $("input[name='" + to + "[name]']").val($("input[name='" + from + "[name]']").val());
            break;
        case 'description':
            $("textarea[name='" + to + "[description]']").val($("textarea[name='" + from + "[description]']").val());
            break;
        case 'image':
            if (!$('tr[data-type=image] td.' + from + ' img').length
                || $('td.' + to + ' input[name=cloneImageFrom' + from[0].toUpperCase() + from.slice(1) + ']').length
                || $('td.' + from + ' input[name=cloneImageFrom' + to[0].toUpperCase() + to.slice(1) + ']').length) {
                break;
            }

            if ($('tr[data-type=image] td.' + to + ' img').length &&
                !$('td.' + to + ' input[name=imageToMaterial]').length) {
                let item = $('<div class="col-xs-6"></div>');
                item.append($('tr[data-type=image] td.' + to + ' img'));
                $('tr[data-type=image] td.' + to).append('<input type="hidden" name="imageToMaterial" value="' + to + '">');
                $('tr[data-type=materials] td.' + to + ' div.row').append(item);
            }

            $('tr[data-type=image] td.' + to).append('<input type="hidden" name="cloneImageFrom' + from[0].toUpperCase() + from.slice(1) + '">');
            $('tr[data-type=image] td.' + from + ' img').clone().prependTo($('tr[data-type=image] td.' + to));

            break;
        case 'materials':
            if (!$('tr[data-type=materials] td.' + from + ' div.row').length) {
                break;
            }

            let isSelected = $('tr[data-type=materials] td.' + from + ' img.selected').length > 0;

            $.each($('tr[data-type=materials] td.' + from + ' div.row div.col-xs-6'), function (i, item) {

                if ($('input.cloneMaterialFrom' + from[0].toUpperCase() + from.slice(1)).length) {
                    let check = false;

                    $.each($('input.cloneMaterialFrom' + from[0].toUpperCase() + from.slice(1)), function (j, jtem) {
                        if ($(jtem).val() == $(item).children().attr('id')) {
                            check = true;
                            return false;
                        }
                    });

                    if (check) {
                        return true;
                    }
                }

                if ($('input.cloneMaterialFrom' + to[0].toUpperCase() + to.slice(1)).length) {
                    let check = false;

                    $.each($('input.cloneMaterialFrom' + to[0].toUpperCase() + to.slice(1)), function (j, jtem) {
                        if ($(jtem).val() == $(item).children('img').attr('id')) {
                            check = true;
                            return false;
                        }
                    });

                    if (check) {
                        return true;
                    }
                }

                if (isSelected && $(item).children('img').hasClass('selected')) {
                    $(item).children('img').removeClass('selected');
                } else {
                    return true;
                }


                $('tr[data-type=materials] td.' + to).append('<input type="hidden" class="cloneMaterialFrom' + from[0].toUpperCase() + from.slice(1) + '" name="cloneMaterialFrom' + from[0].toUpperCase() + from.slice(1) + '[]" value="' + $(item).children().attr('id') + '">');

                $(item).clone().prependTo($('tr[data-type=materials] td.' + to + ' div.row'));
            });


            break;
    }
});

$('tr[data-type=materials]').on('click', 'img', function (e) {
    selectMaterial(this);
    selectMaterialAfter();
});

$('tr[data-type=id]').on('click', 'a.clear', function () {
    clearPetroglyph($(this).parent('td').attr('class'));
    return false;
});

$('.delete-materials').click(function () {
    if (confirm("Вы уверены, что хотите удалить выбранные элементы?")) {
        deleteMaterial();
        selectMaterialAfter();
    } else {
        return false;
    }
});

function selectMaterial(e) {
    if ($(e).hasClass('selected')) {
        $(e).removeClass('selected');
    } else {
        $(e).addClass('selected');
    }
}

function selectMaterialAfter() {
    if ($('tr[data-type=materials] img.selected').length) {
        $('.delete-materials:disabled').prop("disabled", false);
    } else {
        $('.delete-materials').prop("disabled", true);
    }
}

function fillPetroglyph(to, info) {
    $("tr[data-type=id] td." + to + " span").html('id: ' + info.id + '<input type="hidden" name="' + to + '[id]" value="' + info.id + '">');
    $("tr[data-type=id] td." + to).append('<a href="#" class="clear">Очистить</a>');
    $("tr[data-type=id] td." + to).append('<a href="/petroglyph/admin/' + info.id + '" class="pull-right">Индивидуальное редактирование</a>');
    $("input[name='" + to + "[name]']").val(info.name);
    $("textarea[name='" + to + "[description]']").val(info.description);

    if (info.image) {
        $('tr[data-type=image] td.' + to).append('<img class="img-responsive" src="' + info.img_src + '" id="i' + info.id + '">');
    }

    if (info.materials && info.materials.length) {
        $.each(info.materials, function (i, item) {
            $('tr[data-type=materials] td.' + to + ' .row').append('<div class="col-xs-6"><img class="img-responsive" src="' + item.img_src + '" alt="' + item.name + '" id="m' + item.id + '"></div>');
        });
    }
}

function clearPetroglyph(from) {
    $('tr[data-type=id] .' + from + ' span').html('');
    $('tr[data-type=id] .' + from + ' a').remove();
    $('.' + from + ' input[type=text]').val('');
    $('.' + from + ' textarea').val('');
    $('tr[data-type=image] .' + from).html('');
    $('tr[data-type=materials] .' + from + ' .row').html('');
    $('.' + from + ' input[type=hidden]').remove();

    if (from == 'left') {
        left = {};
    } else if (from == 'right') {
        right = {};
    }
}

function deleteMaterial() {
    if ($('tr[data-type=materials] img.selected').length) {
        $.each($('tr[data-type=materials] img.selected'), function (i, item) {
            if ($('input[name=imageToMaterial]').val() == $(item).closest('td').attr('class')) {
                alert('Невозможно удалить изображение, которая пока что является главной. Сохраните изменения.');
                return true;
            }

            if ($(item).closest('td').children('input[value=' + $(item).attr('id') + ']').length) {
                $(item).closest('td').children('input[value=' + $(item).attr('id') + ']').remove();
            } else {
                $(item).closest('td').append('<input type="hidden" name="deleteMaterial[]" value="' + $(item).attr('id') + '">');
            }
            $(item).parent().remove();
        });
    }
}