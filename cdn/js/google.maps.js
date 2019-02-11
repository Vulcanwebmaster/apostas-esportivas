/*
 
 https://maps.google.com/maps/api/js
 
 */

$('[data-gmap]').each(function (event) {
    var valores = $(this).attr('data-gmap').split(',');
    if (valores.length == 3) {
        var positions = $(this).children('[data-position]');
        try {
            var options = $(this).attr('data-options') ? $.parseJSON($(this).attr('data-options')) : {};
        } catch (e) {
            alert('Não foi possível recuperar os valores JSON.');
        }
        var Mapa = new GoogleMaps(this, valores[0], valores[1], valores[2], options);
        $(this).data('mapa', Mapa);
        if (positions.length == 0) {
            $(this).data('mapa-marker', Mapa.addMarker(valores[0], valores[1], $(this).attr('title'), $(this).attr('data-html') || ''));
        } else {
            positions.each(function () {
                var valores = $(this).attr('data-position').split(',');
                Mapa.addMarker(valores[0], valores[1], $(this).attr('title') || '', $(this).attr('data-html'));
            });
        }
    }
});

$('form[data-fgmap]').each(function (event) {

    var form = $(this);
    var div = $(form.attr('data-fgmap'));
    var mapa = div.data('mapa');
    var marker = mapa.getMarker(div.data('mapa-marker'));

    form.submit(function (event) {
        if (!form.data('buscando')) {
            form.data('buscando', true);
            var input = $(this).find('[type=text]').first();
            input.attr('disabled', true);
            input.data('value', input.val()).val('traçando rota...');
            mapa.calcRoute(input.data('value') + ', brasil', marker.position, function (result) {
                input.attr('disabled', false);
                input.val(input.data('value'));
                form.data('buscando', false);
                if (!result) {
                    marker.setMap(mapa.MAP);
                }
            });
        }
        return false;
    }).data('buscando', false);

});


function GoogleMaps(container, _latitude, _longitude, _zoom, options) {

    this.directionsDisplay = new google.maps.DirectionsRenderer();
    this.directionsService = new google.maps.DirectionsService();
    this.zoom = parseInt(_zoom == undefined ? 5 : _zoom);
    this.zoom = isNaN(this.zoom) ? 0 : this.zoom;
    this.latitude = Number(_latitude == undefined ? 0 : _latitude);
    this.latitude = isNaN(this.latitude) ? 0 : this.latitude;
    this.longitude = Number(_longitude == undefined ? 0 : _longitude);
    this.longitude = isNaN(this.longitude) ? 0 : this.longitude;
    this.markers = new Array();
    this.myOptions = $.extend({zoom: this.zoom, center: new google.maps.LatLng(this.latitude, this.longitude), mapTypeId: google.maps.MapTypeId.ROADMAP}, options || {});
    this.MAP = new google.maps.Map($(container)[0], this.myOptions);
    this.infoWindow = new google.maps.InfoWindow();
    this.directionsDisplay.setMap(this.MAP);

    /* Funções publicas */
    GoogleMaps.prototype.addMarker = function (_latitude, _longitude, _title, _html) {
        this.infoWindow.close();
        var latitude = this.getNumber(_latitude == undefined ? 0 : _latitude);
        var longitude = this.getNumber(_longitude == undefined ? 0 : _longitude);
        var latlng = new google.maps.LatLng(latitude, longitude);
        var title = _title == undefined ? '' : _title;
        var marker = new google.maps.Marker({position: latlng, title: String(_title), id: this.markers.length, infoWindow: this.infoWindow, html: String(_html)});
        if (_html != undefined) {
            google.maps.event.addListener(marker, 'click', function (event) {
                this.infoWindow.setContent(this.html);
                this.infoWindow.open(this.getMap(), this);
            });
        }
        marker.setMap(this.MAP);
        this.markers.push(marker);
        return marker.id;
    }
    
    /** @returns {array|google.maps.Marker} */
    GoogleMaps.prototype.getMarkers = function () {
        return this.markers;
    }

    GoogleMaps.prototype.getMarker = function (markerId) {
        var marker = this.markers[markerId];
        if (marker) {
            return marker;
        }
        return undefined;
    }

    GoogleMaps.prototype.viewMarker = function (markerId) {
        this.infoWindow.close();
        var marker = this.getMarker(markerId);
        if (marker) {
            this.MAP.setCenter(marker.getPosition());
            if (this.html != 'undefined') {
                this.infoWindow.setContent(marker.html);
                this.infoWindow.open(marker.getMap(), marker);
            }
        } else {
            alert('Ponto inexistente!');
        }
    }

    GoogleMaps.prototype.setCenter = function (_latitude, _longitude, _zoom) {
        var zoom = this.getNumber(_zoom == undefined ? this.MAP.getZoom() : _zoom);
        var latitude = this.getNumber(_latitude == undefined ? 0 : _latitude);
        var longitude = this.getNumber(_longitude == undefined ? 0 : _longitude);
        this.MAP.setCenter(new google.maps.LatLng(latitude, longitude));
        this.MAP.setZoom(zoom);
    }

    GoogleMaps.prototype.setLatLng = function (value) {
        this.MAP.setCenter(value);
    }

    GoogleMaps.prototype.getConfig = function () {
        var mapType = this.MAP.getMapTypeId();
        var centro = this.MAP.getCenter();
        var latitude = centro.lat();
        var longitude = centro.lng();
        var zoom = this.MAP.getZoom();
        var result = {mapType: mapType, latitude: latitude, longitude: longitude, zoom: zoom};
        return result;
    }

    GoogleMaps.prototype.getNumber = function (numero) {
        var result = Number(numero);
        if (isNaN(result)) {
            result = 0;
        }
        return result;
    }

    GoogleMaps.prototype.clearMarkers = function () {
        if (this.markers) {
            for (i in this.markers) {
                this.markers[i].setMap(null);
            }
        }
        this.markers.length = 0;
    }

    GoogleMaps.prototype.calcRoute = function (start, end, complete) {
        var GdirectionsDisplay = this.directionsDisplay;
        $.each(this.markers, function (index, element) {
            this.setMap(null);
        });
        if (start == '') {
            alert('Preencha o campo com seu endereço.');
        } else {
            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            this.directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    GdirectionsDisplay.setDirections(response);
                } else {
                    alert('Não foi possível encontrar seu endereço.');
                }
                if (complete != undefined && $.isFunction(complete)) {
                    complete(status == google.maps.DirectionsStatus.OK ? true : false);
                }
            });
        }
    }
}

function GoogleMapsBusca(endereco, map) {
    loading('open');
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({address: endereco + ', Brasil'}, completeBuscaGeocoder);
    function completeBuscaGeocoder(response, status) {
        if (status != google.maps.GeocoderStatus.OK) {
            alerta("Nenhum endereço foi encontrado para sua busca.");
        } else {
            point = response[0].geometry.location;
            map.setLatLng(point);
        }
        loading('close');
    }
}