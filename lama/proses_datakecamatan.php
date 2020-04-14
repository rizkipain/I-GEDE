<?php
include ('config.php');
$urutan = $_GET['urutan'];

$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

	//mengambil data pemohon di pemohon kalibrasi
	$query = $conn->prepare( "SELECT * FROM data_gempa WHERE no=:urutan" );
	$query->bindParam(':urutan', $urutan);
	$query->execute();
	while($row=$query->fetch(PDO::FETCH_BOTH)){
			$tanggal=$row['tanggal'];
			$waktu=$row['waktu'];
			$mode=$row['mode'];
			$phase=$row['phase'];
			$magnitude=$row['magnitude'];
			$stamag=$row['stamag'];
			$lat=$row['lat'];
			$lon=$row['lon'];
			$kedalaman=$row['kedalaman'];
	}
//| 2019-11-30 05:30:59 | manual | 9 | 2.8 | M | 5 | 3.42 S | 119.58 E | 10 km | Sulawesi, Indonesia
$isi = "| ".$tanggal." ".$waktu." | ".$mode. " | ".$phase." | ".$magnitude." | "."M". " | ".$stamag." | ".$lat." | ".$lon." | ".$kedalaman." | "."olah kecamatan";
echo $isi;
$myfile = fopen("gempa_proses.txt", "w") or die("Unable to open file!");
fwrite($myfile, $isi);
fclose($myfile);
header("Location:./notifikasi_prosesolah_kecamatan.php?urutan=".$urutan);
?>