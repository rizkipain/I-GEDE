
<?php
include ('./config.php');
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$kategoridatin[0]="-----Pilih Kategori Data dan Informasi-----";
//$tarif[0]="0";
$indekskategori=1;
	$query = $conn->prepare( "SELECT * FROM judul_harga_datin ORDER by id ASC" );
	$query->execute();
	while($row=$query->fetch(PDO::FETCH_BOTH)){
		$kategoridatin[$indekskategori]=$row['list'];
    $indekskategori++;
  }


$jenisdatin[0]="Pilih Kategori Data dan Informasi";
$tarif[0]="0";
$indeks=1;

//kategori1
$query = $conn->prepare( "SELECT * FROM harga_datin1 ORDER by jenis_informasi ASC" );
$query->execute();
while($row=$query->fetch(PDO::FETCH_BOTH)){
  $jenisdatin[$indeks]=$row['jenis_informasi'];
  $satuandatin1[$indeks]=$row['satuan1'];
  $satuandatin2[$indeks]=$row['satuan2'];
  $satuandatin3[$indeks]=$row['satuan3'];
  $tarifdatin[$indeks]=$row['harga'];
  $indeks++;
}
$kategori[1]=$indeks-1;
//echo $kategori[1];
//kategori2
$query = $conn->prepare( "SELECT * FROM harga_datin2 ORDER by jenis_informasi ASC" );
$query->execute();
while($row=$query->fetch(PDO::FETCH_BOTH)){
  $jenisdatin[$indeks]=$row['jenis_informasi'];
  $satuandatin1[$indeks]=$row['satuan1'];
  $satuandatin2[$indeks]=$row['satuan2'];
  $satuandatin3[$indeks]=$row['satuan3'];
  $tarifdatin[$indeks]=$row['harga'];
  $indeks++;
}
$kategori[2]=$indeks-1;
//echo $kategori[2];
//kategori3
$query = $conn->prepare( "SELECT * FROM harga_datin3 ORDER by jenis_informasi ASC" );
$query->execute();
while($row=$query->fetch(PDO::FETCH_BOTH)){
  $jenisdatin[$indeks]=$row['jenis_informasi'];
  $satuandatin1[$indeks]=$row['satuan1'];
  $satuandatin2[$indeks]=$row['satuan2'];
  $satuandatin3[$indeks]=$row['satuan3'];
  $tarifdatin[$indeks]=$row['harga'];
  $indeks++;
}
$kategori[3]=$indeks-1;
//echo $kategori[3];
?>
