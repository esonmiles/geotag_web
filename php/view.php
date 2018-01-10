<?php
session_start();
include "../classes/get.php";
$get = new Get();
$path = "/geotag_web/";
$projectId = $_GET['projectId'];
$surveyId = $_GET['surveyId'];

if ($surveyId == '')
    $surveyId = 0;
$getSurveys = $get->getSurveysApproved($projectId);
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
$ctr = 0;
$coordinaes = '';
foreach ($getSurveys as $id => $record):
    $coordinates .= $record['latitude'] . ', ' . $record['longitude'] . ', ' . $record['survey_name'] . '>';
    $ctr++;
endforeach;

$getSurvey = $get->getSurvey($surveyId);
foreach ($getSurvey as $id => $record):
    $lat = $record['latitude'];
    $lang = $record['longitude'];
endforeach;

if ($surveyId == 0) {
    $lat = '11.727330939813882';
    $lang = '122.7777099609375';
}
?>
<input type="hidden" value="<?php echo $coordinates ?>" id="coordinates">
<input type="hidden" value="<?php echo $ctr ?>" id="ctr">
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="UTF-8">

        <!-- Bootstrap -->
        <link href="<?php echo $path ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $path; ?>images/philrice_presence_logo.png" />
        <link href="<?php echo $path ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo $path ?>build/css/custom.min.css" rel="stylesheet">
        <script src="<?php echo $path ?>vendors/jquery/dist/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw9gkI_fue67hEQdngZ1Ut7Z33ddiaCH0&libraries=places,drawing,geometry" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo $path ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <style type="text/css">
            #map, html, body{
                padding: 0;
                margin: 0;
                width:100%;
                height: 100%;
            }

            #panel {
                width: 100%;
                font-family: Arial, sans-serif;
                font-size: 13px;
                float: right;
                margin: 10px;
            }

            .color-button {
                width: 14px;
                height: 14px;
                font-size: 0;
                margin: 2px;
                float: left;
                cursor: pointer;
            }

            #delete-button {
                margin-top: 5px;
            }
            .col-md-6{width:50%;}
            .col-md-8{width:66.6666666%;}
            .col-md-12{width:100%;}
            .col-md-4{width:33.33333333%;}
        </style>

        <script type="text/javascript">

            var drawingManager;
            var bounds = new google.maps.LatLngBounds();
            var i;
            var selectedShape;
            var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
            var selectedColor;

            function clearSelection() {
                if (selectedShape) {
                    selectedShape.setEditable(false);
                    selectedShape = null;
                }
            }

            function setSelection(shape) {
                clearSelection();
                selectedShape = shape;
                shape.setEditable(true);

                google.maps.event.addListener(shape.getPath(), 'set_at', calcar);
                google.maps.event.addListener(shape.getPath(), 'insert_at', calcar);
            }

            function deleteSelectedShape() {
                if (selectedShape) {
                    selectedShape.setMap(null);
                    // To show:
                    drawingManager.setOptions({
                        drawingControl: true
                    });
                }
            }

            function calcar() {
                var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
                parent.$("#soil_area").val(area);
                parent.$("#area").val(area);
            }
            function setSelectedShapeColor(color) {
                if (selectedShape) {
                    if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
                        selectedShape.set('strokeColor', color);
                    } else {
                        selectedShape.set('fillColor', color);
                    }
                }
            }

            function makeColorButton(color) {
                var button = document.createElement('span');
                button.className = 'color-button';
                button.style.backgroundColor = color;
                google.maps.event.addDomListener(button, 'click', function () {
                    setSelectedShapeColor(color);
                });

                return button;
            }

            var geocoder;
            function initialize() {
                geocoder = new google.maps.Geocoder();
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 6,
                    center: new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lang ?>),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: true
                });
                google.maps.Polygon.prototype.getBounds = function () {
                    var bounds = new google.maps.LatLngBounds();
                    var paths = this.getPaths();
                    var path;
                    for (var i = 0; i < paths.getLength(); i++) {
                        path = paths.getAt(i);
                        for (var ii = 0; ii < path.getLength(); ii++) {
                            bounds.extend(path.getAt(ii));
                        }
                    }
                    return bounds;
                };

                var markers2 = [];
                var contents = [];
                var infowindows = [];
                var ctr = $("#ctr").val();
                var coordinates = $("#coordinates").val();
                var exp = coordinates.split(">");
                for (i = 0; i < ctr; i++) {
                    var split = exp[i].split(", ");
                    var lat = split[0];
                    var lang = split[1];
                    markers2[i] = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, lang),
                        map: map,
                        title: split[2]
                    });
                    markers2[i].index = i;
                    contents[i] = '<div class="popup_container"><h4>' + split[2] + '</h4><br>' +
                            '</div>';

                    infowindows[i] = new google.maps.InfoWindow({
                        content: contents[i],
                        maxWidth: 500
                    });

//                    google.maps.event.addListener(markers2[i], 'mouseover', function () {
//                        infowindows[this.index].open(map, markers2[this.index]);
//                        map.panTo(markers2[this.index].getPosition());
//                    });
//
//                    google.maps.event.addListener(markers2[i], 'mouseout', function () {
//                        infowindows[this.index].close(map, markers2[this.index]);
//                    });

                    google.maps.event.addListener(markers2[i], 'click', function () {
                        infowindows[this.index].open(map, markers2[this.index]);
                        map.panTo(markers2[this.index].getPosition());
                    });
                    codeLatLng(lat, lang);
                }

            }

            function codeLatLng(lat, lng) {

                var latlng = new google.maps.LatLng(lat, lng);
                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        //console.log(results);
                        if (results[1]) {
                            var indice = 0;
                            for (var j = 0; j < results.length; j++)
                            {
                                if (results[j].types[0] == 'locality')
                                {
                                    indice = j;
                                    break;
                                }
                            }
                            //alert('The good number is: ' + j);
                            //console.log(results[j]);
                            for (var i = 0; i < results[j].address_components.length; i++)
                            {
                                if (results[j].address_components[i].types[0] == "locality") {
                                    //this is the object you are looking for
                                    city = results[j].address_components[i];
                                }
                                if (results[j].address_components[i].types[0] == "administrative_area_level_1") {
                                    //this is the object you are looking for
                                    region = results[j].address_components[i];
                                }
                                if (results[j].address_components[i].types[0] == "country") {
                                    //this is the object you are looking for
                                    country = results[j].address_components[i];
                                }
                            }

                            //city data
                            //alert(city.long_name + " || " + region.long_name + " || " + country.short_name);


                        } else {
                            //alert("No results found");
                        }
                        //}
                    } else {
                        //alert("Geocoder failed due to: " + status);
                    }
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div id="map" style="width: 100%;height: 100%;"></div> 
                </div>
            </div>
        </section>
    </body>
</html>
