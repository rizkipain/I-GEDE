<?php
include ('config.php');

	$waktulokal = $_GET['waktu_lokal'];
	$lat_terima = $_GET['lat'];
	$lon_terima = $_GET['lon'];
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	//asda
	$query = $conn->prepare( "SELECT * FROM data_gempa WHERE waktu_lokal=:waktu_lokal" );
	$query->bindParam(':waktu_lokal', $waktulokal);
	$query->execute();
	while($row=$query->fetch(PDO::FETCH_BOTH)){
		$magnitude=$row['magnitude'];
		$tanggal=$row['tanggal'];
		$waktu=$row['waktu'];
		$lat=$row['lat'];
		$lon=$row['lon'];
		$kedalaman=$row['kedalaman'];
		$event=$row['event'];
		$kecamatan=$row['kecamatan'];
	}

$pisah_kecamatan = (explode("|",$kecamatan));
$pisah_lat = (explode(" ",$lat));
$pisah_lon = (explode(" ",$lon));

if($pisah_lat[1]=='S'){
	$pisah_lat[1]=' LS';
}
else{
	$pisah_lat[1]=' LU';
}

if($pisah_lon[1]=='E'){
	$pisah_lon[1]=' BT';
}
else{
	$pisah_lon[1]=' BB';
}

$lat = $pisah_lat[0].$pisah_lat[1];
$lon = $pisah_lon[0].$pisah_lon[1];


//kirim data
$pesan = "Info Gempa Mag: ".$magnitude." SR, ".$waktulokal.", Lokasi: ".$lat."-".$lon.'\n\n'.$pisah_kecamatan[0].'\n'.$pisah_kecamatan[1].'\n'.$pisah_kecamatan[2].'\n'.$pisah_kecamatan[3].'\n'.$pisah_kecamatan[4].'\n\n'."Kedalaman: ".$kedalaman."::BMKG-PGRIV";

//echo $pesan;
$b64image = base64_encode(file_get_contents('https://api.mapbox.com/styles/v1/rizkipain/ck429io6v0qu91cphdi09ccdt/static/url-https%3A%2F%2Fi.ibb.co%2FzhMXNCN%2Ficonfinder-epicenter-r-86195.png('.$lon_terima.','.$lat_terima.')/'.$lon_terima.','.$lat_terima.',7/700x700?logo=false&attribution=false&access_token=pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrNDBscnA1OTAydG0zaW9hOGtxbHBseWsifQ.KR832-MFWx9UWqqpPPXcQg'));
//echo $b64image;

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.maxchat.id/demo8/api/messages/image",
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 30,
  CURLOPT_TIMEOUT => 60,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"to": "628114104205-1561774523", "image": "data:image/jpeg;base64,'.$b64image.'",
    "filename": "asdasdasd.gif",
    "caption": "'.$pesan.'"}',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer V6Cyiqy4SQfHwkCfqXoHdf",
    "Content-Type: application/json",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}


?>
