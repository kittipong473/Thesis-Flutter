<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Google Map</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <center><h1>Access Google Map API in PHP</h1></center>
        <div id="map"></div>
    </div>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places">
</script>
    
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', intilize);
    function intilize() {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('txtautocomplete'));

            gogole.maps.event.addListener(autocomplete, 'place_changed', function () {

var place = autocomplete.getPlace();
var location = "<b>Address</b>: " + place.formatted_address + "<br>";
location += "<b>Latitude</b>: " + place.geometry.location.A + "<br>";
location += "<b>Longitude</b>: " + place.geometry.location.F;
document.getElementById('lblResult').innerHTMK = location
        });
    };
</script>
<span>Location:</span><input type="text" id="txtautocomplete" style="width:200px" placeholder="Enter the address">
<label id="lblResult"></label>
</body>
</html>