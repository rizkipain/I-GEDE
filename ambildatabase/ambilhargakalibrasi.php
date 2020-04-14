<?php
include ('./config.php');
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$jenisalat[0]="-----Pilih Jenis Alat-----";
$tarifkalibrasi[0]=0;
//$tarif[0]="0";

$indeks=1;
	$query = $conn->prepare( "SELECT * FROM harga_kalibrasi ORDER by jenis_alat ASC" );
	$query->execute();
	while($row=$query->fetch(PDO::FETCH_BOTH)){
		$jenisalat[$indeks]=$row['jenis_alat'];
    $satuankalibrasi[$indeks]=$row['satuan'];
    $tarifkalibrasi[$indeks]=$row['harga'];
    $indeks++;
  }

?>
