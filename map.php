<?php
  require_once 'core/init.php';

  $client_id = $_GET['client'];
  $my_id = $_GET['my_id'];

  $myLoc = $db->query("SELECT * FROM reg_db WHERE id = '$my_id';");
  $mylocation = mysqli_fetch_assoc($myLoc);

  $mylocation_lng = $mylocation['longitude'];
  $mylocation_lat = $mylocation['latitude'];

  $ctLoc = $db->query("SELECT * FROM reg_db WHERE id = '$client_id';");
  $ctlocation = mysqli_fetch_assoc($ctLoc);

  $ctlocation_lng = $ctlocation['longitude'];
  $ctlocation_lat = $ctlocation['latitude'];
?>
<title>Map</title>
<script src="admin/plugins/jquery/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvYzz9Qhl2NLOQrSfYqyJboUmGog1e1Ow"></script>
<input type="button" id="routebtn" value="route" />
<div id="map-canvas"></div>
<style>
  html,
body,
#map-canvas {
  height: 90%;
  width: 90%;
  margin: auto;
  padding: 0px;
  margin-top:  2%;
}
#routebtn{
  display: none;
}
</style>
<script>
  function mapLocation() {
  var directionsDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;

  var myLng = '<?=$mylocation_lng?>';
  var myLat = '<?=$mylocation_lat?>';

  var ctLng = '<?=$ctlocation_lng?>';
  var ctLat = '<?=$ctlocation_lat?>';

  function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var centerDirection = new google.maps.LatLng(myLng, myLat);
    var mapOptions = {
      zoom: 10,
      center: centerDirection, 
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    google.maps.event.addDomListener(document.getElementById('routebtn'), 'click', calcRoute);
  }

  function calcRoute() {
    var start = new google.maps.LatLng(myLng, myLat);
    var end = new google.maps.LatLng(ctLng, ctLat);
    var directionRequest = {
      origin: start,
      destination: end,
      provideRouteAlternatives: true,
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC
    };
    directionsService.route(directionRequest, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
          for (var i = 0, len = response.routes.length; i < len; i++) {
                new google.maps.DirectionsRenderer({
                    map: map,
                    directions: response,
                    routeIndex: i
                });
          }
      } else {
        alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
      }
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);
}
mapLocation();
$(document).ready(function(){
  var timeleft = 2;
  var downloadTimer = setInterval(function(){
    if(timeleft <= 0){
      clearInterval(downloadTimer);
      $('#routebtn').click();
    } else {
      $('#routebtn').click();
    }
    timeleft -= 1;
  }, 1000);
  
});
$('#routebtn').click();
</script>