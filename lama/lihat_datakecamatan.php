<?php
include ('config.php');

	$urutan = $_GET['urutan'];
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	//mengambil data pemohon di pemohon kalibrasi
	$query = $conn->prepare( "SELECT * FROM data_gempa WHERE no=:no" );
	$query->bindParam(':no', $urutan);
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
		$waktu_lokal=$row['waktu_lokal'];
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="gambar/bmkg.png">
    <title> Lihat Kecamatan </title>
</head>
<body>
    <div class="wadah">
        <label id="atas">Info Gempa Mag: <?php echo $magnitude;?> SR, <?php echo $waktu_lokal;?>, Lokasi: <?php echo $lat;?>-<?php echo $lon;?>  </label>
	<label id="bawah"><?php echo $pisah_kecamatan[0]; ?></label>
	<label id="bawah"><?php echo $pisah_kecamatan[1]; ?></label>
	<label id="bawah"><?php echo $pisah_kecamatan[2]; ?></label>
	<label id="bawah"><?php echo $pisah_kecamatan[3]; ?></label>
	<label id="bawah"><?php echo $pisah_kecamatan[4]; ?></label>

	<label id="bawah">Kedalaman: <?php echo $kedalaman; ?>::BMKG-PGRIV</label>
    </div>
</body>

<link rel="stylesheet" href="css/style_lihat_kecamatan.css">
</html>