/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
define([
  'jquery'
],
  function($) {

    return function (config) {
      $.getScript('https://maps.googleapis.com/maps/api/js?key=' + config.apiKey + "&region=GB&libraries=geometry", function () {
          initialise();
      });

      function initialise() {
        var geocoder = new google.maps.Geocoder();
        var styledMapType = [];
        var selectedId = -1;
        
        if (config.mapStyle) {
          styledMapType = new google.maps.StyledMapType(config.mapStyle);
        }
        map = new google.maps.Map(document.getElementById('map'), {
          center: {
            lat: parseFloat(config.lat),
            lng: parseFloat(config.lon)
          },
          zoom: parseInt(config.zoom),
          disableDefaultUI: true,
          zoomControl: true
        });
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');

        infoWindow = new google.maps.InfoWindow;

        $.each(config.resellers, function(index, reseller) {
          var point = new google.maps.LatLng(reseller.lat, reseller.lon);

          var infowincontent = document.createElement('div');
          infowincontent.setAttribute('id', index);

          var beforeend = '';

          if (reseller.company) {
            beforeend += '<div class="infowindowCompany">';
            if (reseller.website) {
              beforeend += '<a class="infowindowComnpany_Link" href="' + reseller.website + '" target="_blank">' + reseller.company + '</a></div>';
            } else {
              beforeend += reseller.company + '</div>';
            }
          }

          beforeend +=
              '<div class="infowindowType">' + reseller.type + '</div>' +
              '<div class="infowindowLocation"><span>' + reseller.city + '</span><span>' + ', ' + reseller.postcode + '</span></div>' +
              '<div class="infowindowContact">';
          if (reseller.telephone) {
            beforeend +=
              '<div class="infowindowTelephone">' +
                '<a class="infowindowTelephone_Link" href="tel:' + reseller.telephone + '" target="_blank">' + reseller.telephone + '</a>' +
              '</div>'
          }
          if (reseller.email) {
            beforeend +=
              '<div class="infowindowEmail">' +
                '<a class="infowindowEmail_Link" href="mailto:' + reseller.email + '" target="_blank">' + reseller.email + '</a>' +
              '</div>';
          }
          beforeend += '</div>';

          infowincontent.insertAdjacentHTML('beforeend', beforeend);

          var marker;
          if (reseller.marker_color) {
            var pinImage = new google.maps.MarkerImage(
              "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + reseller.marker_color,
              new google.maps.Size(21, 34),
              new google.maps.Point(0,0),
              new google.maps.Point(10, 34)
            );

            marker = new google.maps.Marker({
              map: map,
              position: point,
              icon: pinImage
            });
          } else {
            marker = new google.maps.Marker({
              map: map,
              position: point
            });
          }

          markers.push(marker);

          marker.addListener('click', function() {
            var index = infowincontent.getAttribute('id');
            var listWindow = $('#resellerContainer_List');
            var resellerContainer = $('.resellerContainer#' + index);
            $('.resellerContainer.highlight').toggleClass('highlight');
            $('li.highlight').toggleClass('highlight');
            resellerContainer.toggleClass('highlight');
            resellerContainer.parent().toggleClass('highlight');
            $('.resellerContainer#' + index)[0].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            infoWindow.setContent(infowincontent);
            infoWindow.open(map, marker);
          });
        });

        google.maps.event.addListener(infoWindow,'closeclick',function() {
          selectedId = -1;
          $('.resellerContainer.highlight').toggleClass('highlight');
          $('li.highlight').toggleClass('highlight');
        });

        $('.resellerContainer').mouseover(function () {
          if (selectedId < 0) {
            google.maps.event.trigger(markers[this.id], 'click');
          }
        });

        $('.resellerContainer').click(function () {
          if (selectedId == this.id) {
            selectedId = -1;
            map.setZoom(parseInt(config.zoom));
          } else {
            selectedId = this.id;
            map.setZoom(10);
          }
          map.setCenter(markers[this.id].position);
          google.maps.event.trigger(markers[this.id], 'click');
        });

        $('.installmap_Nearest_Search').click(function () {
          geocoder.geocode( { 'address': $('.installmap_Nearest_Input').val()}, function(results, status) {
            if (status == 'OK') {
              var closest;
              for( i = 0; i < markers.length; i++ ) {
                var distance = google.maps.geometry.spherical.computeDistanceBetween(results[0].geometry.location, markers[i].position);
                if(!closest || closest.distance > distance) {
                  closest = {index:i, distance:distance}
                }
              }
              map.setCenter(markers[closest.index].position);
              map.setZoom(10);
              selectedId = closest.index;
              google.maps.event.trigger(markers[closest.index], 'click');
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });
        });
      }

      function rad(x) {return x*Math.PI/180;}
    }
  }
)