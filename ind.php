<?php

if(isset($_POST['lat'], $_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
	
    $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s", $lat, $lng);
      
    $content = file_get_contents($url); // get json content

    $metadata = json_decode($content, true); //json decoder

    if(count($metadata['results']) > 0) {
        // for format example look at url
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452
        $result = $metadata['results'][0];

        // save it in db for further use
        echo $result['formatted_address'];

    }
    else {
        // no results returned
		echo "unable to display";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Geocoding Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script>
  function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
      } else {
          //Geolocation is not supported by this browser
      }
  }

  // handle the error here
  function positionError(error) {
      var errorCode = error.code;
      var message = error.message;

      alert(message);
  }

  function savePosition(position) {
            $.post("<?php echo $PHP_SELF;?>", {lat: position.coords.latitude, lng: position.coords.longitude});
  }
  
  </script>
</head>
<body>
    <button onclick="getLocation();">Get My Location</button>
</body>
</html>
<?php
echo $lat;
echo $long;
?>