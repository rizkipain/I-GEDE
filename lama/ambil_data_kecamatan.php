<?php
include ('config.php');
$urutan = $_GET['urutan'];

$fn = fopen('gempa_hasil.txt',"r") or die("fail to open file");
while($row = fgets($fn)) {
$ambil_data = $row;
}
fclose( $fn );
$pisah_data = (explode("|",$ambil_data));

//echo $pisah_data[4];
//echo "<br>";
//echo $pisah_data[5];
//echo "<br>";
//echo $pisah_data[6];
//echo "<br>";
//echo $pisah_data[7];
//echo "<br>";
//echo $pisah_data[8];
//echo "<br>";
//echo $pisah_data[9];

$semua_kec = $pisah_data[5]."|".$pisah_data[6]."|".$pisah_data[7]."|".$pisah_data[8]."|".$pisah_data[9];
$waktu_lokal = $pisah_data[1];
//echo $semua_kec;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("UPDATE data_gempa SET event=:event, kecamatan=:kecamatan, waktu_lokal=:waktu_lokal  WHERE  no=:urutan ");
    $stmt->bindParam(':event', $pisah_data[4]);
    $stmt->bindParam(':kecamatan', $semua_kec);
    $stmt->bindParam(':urutan', $urutan);
    $stmt->bindParam(':waktu_lokal', $waktu_lokal);
    $stmt->execute();
    header("Location: utama_datagempa.php");
}
catch(PDOException $e){
    echo "Koneksi Gagal ".$e->getMessage();
}
?>
