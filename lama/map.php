<?php

$lat = "-0.96";
$lon = "123.38";

// header( 'Location: menu.php'  );
?>

<html>
<head>
<link rel="shortcut icon" href="gambar/bmkg.png">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.js"></script>
<script src="https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.js"></script>
<script src="https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css" />
<link rel="stylesheet" href="https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />
<script type="text/javascript" src="html2canvas-master/dist/html2canvas.js"></script>
</head>

<body>
	<div id="map"></div>
</body>
<link rel="stylesheet" href="css/style_berita_gempa.css">
<script>
      var map = L.map('map', { zoomControl: false, renderer: L.canvas(), attributionControl: false}).setView([<?php echo $lat ?>, <?php echo $lon ?>], 7);
	  var gl = L.mapboxGL({
        attribution: '',
        accessToken: 'pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrMXZncnEyNjAzaWcza3RrY3U4a2N2MGUifQ.dQZ4lan3VDlKfywUEIKyww',
        style: 'https://api.maptiler.com/maps/hybrid/style.json?key=5OP1Uj3UEhVX2RqboyOf',
      }).addTo(map);
	  var marker = L.marker([<?php echo $lat ?>, <?php echo $lon ?>]).addTo(map);
</script>
</html>
