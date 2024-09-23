var ERE_NEARBY_PLACES = ERE_NEARBY_PLACES || {};
(function ($) {
    "use strict";
    ERE_NEARBY_PLACES = function (element) {
        this.$element = $(element);
        this.element = element;
        this.$map = this.$element.find('.ere__map-canvas');
        this.$content = this.$element.find('.ere__nbp-content-inner');
        if ((this.$map.length === 0) || (this.$content.length === 0)) {
            return;
        }
        this.options = this.$map.data('nearby-options');
        this.init();
    };

    ERE_NEARBY_PLACES.prototype.init = function () {
        this.setupMap();
        this.nearByPlaces();
    };

    ERE_NEARBY_PLACES.prototype.setupMap = function (){
        var mapId = this.$map.attr('id');
        if (mapId === '') {
            return;
        }
        var t = ERE_MAP.getInstance(mapId);
        this.map = t.instance;
        this.position =   new ERE_MAP.LatLng(this.options.position.lat, this.options.position.lng);
        this.placesService = new ERE_MAP.PlacesService({
            maxResultCount: 20,
            includedTypes: this.options.types,
            radius: this.options.radius,
            rankPreference: this.options.rankPreference,
            position : this.position,
            map: this.map,
        });
    };

    ERE_NEARBY_PLACES.prototype.nearByPlaces = function (){
        var self = this;
        this.placesService.nearbySearch(function (response) {
            if (response) {
                self.map.trigger("updating_markers");
                $.each(response,function (index, value){
                    var place  = self.getPlace(value);
                    self.createMarker(place);
                    self.createPlace(place);
                });

                if (self.map.markers.length === 1) {
                    self.map.setCenter(self.map.markers[0].getPosition());
                }

                if (self.map.markers.length > 1) {
                    self.map.fitBounds(self.map.bounds);
                }

                self.map.trigger("updated_markers");
            } else  {
                self.$content.append('<span>' + self.options.i18n.no_result + '</span>');
            }
        });
    };

    ERE_NEARBY_PLACES.prototype.getPlace = function (place){
        var self = this;
        var type = '';
        $.each(place.types, function (index, value){
            if ($.inArray( value, self.options.types ) !== -1) {
                type = value;
                return false;
            }
        });
        var typeInfo = self.options.fields[type];
        return {
            typeLabel : typeInfo.label,
            typeIcon: typeInfo.icon,
            displayName: place.displayName,
            lat: place.lat,
            lng: place.lng
        }
    };

    ERE_NEARBY_PLACES.prototype.createMarker = function (place){
        var self = this;
        var position = new ERE_MAP.LatLng(place.lat, place.lng) ;
        var marker_option = {
            position: position,
            map: self.map,
            template: {
                marker : {
                    'type' : 'image',
                    'html' : '<img src="' + place.typeIcon +'" >'
                }
            }
        };
        var template = wp.template('ere__map_popup_simple_template');
        var content_popup = template({
            content: '<strong>' + place.typeLabel + ': ' + '</strong>' + place.displayName
        });

        marker_option.popup = new ERE_MAP.Popup({
            content: content_popup,
            type: 'simple'
        });

        var marker = new ERE_MAP.Marker(marker_option);
        self.map.markers.push(marker);
        self.map.bounds.extend(marker.getPosition());
    }

    ERE_NEARBY_PLACES.prototype.createPlace = function (place){
        var self = this;
        var distant = self.getDistance(place);
        var template = wp.template('ere__nearby_place_item_template');
        var content = template({
            type: place.typeLabel,
            name: place.displayName,
            distant: distant,
            unit: self.options.unit
        });
        self.$content.append(content);
    };

    ERE_NEARBY_PLACES.prototype.getDistance = function (place) {
        var lat1 = this.options.position.lat;
        var lng1 = this.options.position.lng;
        var lat2 = place.lat;
        var lng2 = place.lng;
        var radlat1 = Math.PI * lat1 / 180;
        var radlat2 = Math.PI * lat2 / 180;
        var theta = lng1 - lng2;
        var radtheta = Math.PI * theta / 180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist);
        dist = dist * 180 / Math.PI;
        dist = dist * 60 * 1.1515;
        if (this.options.unit === "km") {
            dist = dist * 1.609344;
        } else if (this.options.unit === "m") {
            dist = dist * 1.609344 * 1000;
        }
        var result = Math.round(dist * 100) / 100;
        result = result.toLocaleString().replace(/[^\d.]/ig, this.options.separator);
        return result;
    };



    $(document).on('maps:loaded', function () {
        $('.ere__nearby-places').each(function () {
            new ERE_NEARBY_PLACES(this);
        });
    });
})(jQuery);
