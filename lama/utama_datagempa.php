<?php
//$lat_map = "-0.96";
//$lon_map = "123.38";
include ('config.php');
include ('update_datagempa.php');
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$query = $conn->prepare( "SELECT * FROM data_gempa ORDER BY tanggal DESC, waktu DESC LIMIT 20" );
	$query->execute();
?>


<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.js"></script>
<script src="https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.js"></script>
<script src="https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css" />
<link rel="stylesheet" href="https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />
<body>
	<table id="tabelutama">
		<tr class="kepalatabel">
			<th>No</th>
			<th>Tanggal (UTC)</th>
			<th>Waktu (UTC)</th>
			<th>Mode</th>
			<th>Magnitude</th>
			<th>Sinyal Phase</th>
			<th>Sinyal Magnitude</th>
			<th>Latitude</th>
			<th>Longtitude</th>
			<th>Kedalaman</th>
			<th>Generate Kecamatan</th>
			<th>Peta</th>
			<th>Gambar</th>
		</tr>
		<?php
		$x=0;
		$lat = array();
		$long = array();
		while($row=$query->fetch(PDO::FETCH_ASSOC)) {
			if($x%2==0){ $classbaris="satu";}
			else{$classbaris="dua";}
			echo '<tr class="'.$classbaris.'">';
			$angka=$x+1;
			//membuat array
			
			array_push($lat,$row['lat']);
			array_push($long,$row['lon']);
			echo "<td>".$angka."</td>";
			echo "<td>".$row['tanggal']."</td>";
			echo "<td>".$row['waktu']."</td>";
			echo "<td>".$row['mode']."</td>";
			echo "<td><b>".$row['magnitude']." SR</b></td>";
			echo "<td>".$row['phase']."</td>";
			echo "<td>".$row['stamag']."</td>";
			echo "<td>".$row['lat']."</td>";
			echo "<td>".$row['lon']."</td>";
			echo "<td>".$row['kedalaman']."</td>";
			//echo "<td>".'<button id="tombol_hapus" class="tombol" onclick=""><b>X</b></button>'."</td>";
			if($row['kecamatan']==null){
				echo "<td>".'<button id="tombol_generate_kecamatan" class="tombol" onclick="generate_kecamatan('.$row['no'].')">Generate</button>'."</td>";
			}
			else{
				echo "<td>".'<button id="tombol_lihat_kecamatan" class="tombol" onclick="lihat_kecamatan('.$row['no'].')">Lihat</button>'."</td>";
			}
			echo "<td>".'<button id="tombol_cek_detail_peta" class="tombol" onclick="lihat_peta('.$x.')">Cek Detail</button>'."</td>";
			echo "<td>".'<button id="tombol_cek_detail_gambar" class="tombol" onclick="lihat_gambar('.$x.')">Cek</button>'."</td>";
			echo "</tr>";
			$x++;
		}
		//$lat = array_reverse($lat);
		//$long = array_reverse($long);
		?>
	</table>

<!-- =================================================== halaman peta ==============================================  -->
<div id="halaman_dasar_peta" class="modal_dasar">
	<div class="modal_isi_peta animate">
	<div id="map"></div>
	</div>
</div>
<!-- =================================================== halaman peta ==============================================  -->

<!-- =================================================== halaman gambar ==============================================  -->
	<div id="wadah_gambar" class="modal_isi_gambar animate">
		<img id="peta" src="" ></img>
	  	<div class="kumpul_logo">
      			<img id="logo_bmkg" src="gambar/bmkg.png"></img>
      			<label>PGR IV Makassar</label>
  		</div>
		<div class="kumpul_peta_kecil">
      			<img id="peta_kecil" src="" ></img>
  		</div>
	</div>
<!-- =================================================== halaman gambar ==============================================  -->


<script>
	var modal_dasar_peta = document.getElementById('halaman_dasar_peta');
	var modal_dasar_gambar = document.getElementById('halaman_dasar_gambar');
	var latitude = <?php echo json_encode($lat); ?>;
	var longtitude = <?php echo json_encode($long); ?>;
	var greenIcon = L.icon({
    		iconUrl: 'epic.png',

    		iconSize:     [32, 32], // size of the icon
	});


	function generate_kecamatan(urutan) {
              window.open('/proses_datakecamatan.php?urutan='+urutan,'_self');	
	}
	function lihat_kecamatan(urutan) {
              window.open('/lihat_datakecamatan.php?urutan='+urutan,'_self');	
	}

	function lihat_peta(urutan) {
		var latitude_benar = latitude[urutan].split(" ");
		var longtitude_benar = longtitude[urutan].split(" ");
		
		if(latitude_benar[1]=="S"){
			latitude_benar[0] = "-"+latitude_benar[0];
		}
		if(longtitude_benar[1]=="W"){
			longtitude_benar[0] = "-"+longtitude_benar[0];
		}

		var latLng = L.latLng([latitude_benar[0], longtitude_benar[0]]); 
              	document.getElementById('halaman_dasar_peta').style.display = 'block';

		var map = L.map('map', { zoomControl: false, renderer: L.canvas(), attributionControl: false}).setView(latLng, 7);
      		var gl = L.mapboxGL({
        		attribution: '',
        		accessToken: 'pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrNDBscnA1OTAydG0zaW9hOGtxbHBseWsifQ.KR832-MFWx9UWqqpPPXcQg',
        		style: 'mapbox://styles/rizkipain/ck429io6v0qu91cphdi09ccdt',
      				}).addTo(map);

	  	var marker = L.marker(latLng, {icon: greenIcon}).addTo(map);
	}
	function lihat_gambar(urutan) {
		var latitude_benar = latitude[urutan].split(" ");
		var longtitude_benar = longtitude[urutan].split(" ");
		if(latitude_benar[1]=="S"){
			latitude_benar[0] = "-"+latitude_benar[0];
		}
		if(longtitude_benar[1]=="W"){
			longtitude_benar[0] = "-"+longtitude_benar[0];
		}

              document.getElementById('wadah_gambar').style.display = 'block';
	      document.getElementById("peta").src = "https://api.mapbox.com/styles/v1/rizkipain/ck429io6v0qu91cphdi09ccdt/static/url-https%3A%2F%2Fi.ibb.co%2FzhMXNCN%2Ficonfinder-epicenter-r-86195.png("+longtitude_benar[0]+","+latitude_benar[0]+")/"+longtitude_benar[0]+","+latitude_benar[0]+",7/700x700?logo=false&attribution=false&access_token=pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrNDBscnA1OTAydG0zaW9hOGtxbHBseWsifQ.KR832-MFWx9UWqqpPPXcQg";
	      document.getElementById("peta_kecil").src = "https://api.mapbox.com/styles/v1/rizkipain/ck429io6v0qu91cphdi09ccdt/static/url-https%3A%2F%2Fi.ibb.co%2FzhMXNCN%2Ficonfinder-epicenter-r-86195.png("+longtitude_benar[0]+","+latitude_benar[0]+")/"+longtitude_benar[0]+","+latitude_benar[0]+",6/900x900?logo=false&attribution=false&access_token=pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrNDBscnA1OTAydG0zaW9hOGtxbHBseWsifQ.KR832-MFWx9UWqqpPPXcQg";
	}

	window.onclick = function(event){
		if(event.target == modal_dasar_peta){
			location.reload();
		}
		if(event.target == modal_body){
			location.reload();
		}

	}
</script>
</body>
</head>
	<link rel="stylesheet" href="css/style_utama_datagempa.css" >
<script>
</script>
</html>
