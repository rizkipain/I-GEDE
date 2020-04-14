<?php
include ('config.php');

	$waktulokal = $_GET['urutan'];
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

echo $pesan;
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.maxchat.id/demo8/api/messages",
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"to": "628990754408", "text": "'.$pesan.'"}',
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
