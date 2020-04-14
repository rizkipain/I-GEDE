<?php
include ('config.php');
//$output = shell_exec("/var/www/html/tes.sh");
//echo "<pre>$output</pre>";

$date = new DateTime("now", new DateTimeZone('UTC') );
//echo $date->format('Y-m-d H:i:s');
$file_tahun = $date->format('Y');
$file_bulan = $date->format('m');
$file_tanggal = $date->format('d');

//$file_tahun = "2019";
//$file_bulan = "12";
//$file_tanggal = "02";
//echo $file_tahun.$file_bulan.$file_tanggal;
	//membuka data gempa yang terakhir diupload ke dalam database
	$fn = fopen('datagempa_lastupload.txt',"r") or die("fail to open file");
	$gempa_lastupload =  fgets($fn);
	fclose( $fn );

//cek jika file atau tidak
$file_datagempa = 'data/'.$file_tahun.$file_bulan.$file_tanggal.'.txt';
if (!file_exists($file_datagempa))  
{ 
    $myfile = fopen($file_datagempa, "w") or die("Unable to open file!");
    fclose($myfile);
} 


//membuka data gempa di tanggal itu
$fn = fopen('data/'.$file_tahun.$file_bulan.$file_tanggal.'.txt',"r") or die("fail to open file");
$baris=0;
$data_gempa=array(); 
$tanggal=array(); 
$waktu=array(); 
$mode=array(); 
$phase=array(); 
$magnitude=array();
$stamag=array();
$latitude=array();
$longtitude=array();
$kedalaman=array();  
$daerah=array();    

while($row = fgets($fn)) {
  list( $txt_waktu, $txt_mode, $txt_phase, $txt_mag, $txt_M, $txt_stamag, $txt_lat, $txt_lon, $txt_kedalaman, $txt_daerah  ) = explode( " | ", $row );
  $baris++;
  if($baris==1){
	$last_kirim = $row;
  }
  array_push($data_gempa, $row); 

  $pisah_txt_waktu = explode( " ", $txt_waktu );
  array_push($tanggal, $pisah_txt_waktu[1]); 
  array_push($waktu, $pisah_txt_waktu[2]); 
  array_push($mode, $txt_mode); 
  array_push($phase, $txt_phase); 
  array_push($magnitude, $txt_mag); 
  array_push($stamag, $txt_stamag); 
  array_push($latitude, $txt_lat); 
  array_push($longtitude, $txt_lon); 
  array_push($kedalaman, $txt_kedalaman); 
  array_push($daerah, $txt_daerah); 
}

fclose( $fn );

$tanda = $baris;
for ($i = 0; $i < $baris; $i++) {
    if($gempa_lastupload == $data_gempa[$i]){
    	$tanda = $i;
	break;
    }
}
echo $i;
echo $tanda;
echo "////";

//proses upload data gempa
if($tanda!=0){
	for ($j = 0; $j <= $tanda-1; $j++) {
		
		try {
    			$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    			// set the PDO error mode to exception
    			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			// prepare sql and bind parameters
    			$stmt = $conn->prepare("INSERT INTO data_gempa (tanggal, waktu, mode, phase, magnitude, stamag, lat, lon, kedalaman, daerah)
    			VALUES (:tanggal, :waktu, :mode, :phase, :magnitude, :stamag, :lat, :lon, :kedalaman, :daerah)");

    			$stmt->bindParam(':tanggal', $tanggal[$j]);
			$stmt->bindParam(':waktu', $waktu[$j]);
			$stmt->bindParam(':mode', $mode[$j]);
			$stmt->bindParam(':phase', $phase[$j]);
        		$stmt->bindParam(':magnitude', $magnitude[$j]);
			$stmt->bindParam(':stamag', $stamag[$j]);
			$stmt->bindParam(':lat', $latitude[$j]);
			$stmt->bindParam(':lon', $longtitude[$j]);
			$stmt->bindParam(':kedalaman', $kedalaman[$j]);
			$stmt->bindParam(':daerah', $daerah[$j]);
			$stmt->execute();
		}
		catch(PDOException $e){
            		echo "Koneksi Gagal ".$e->getMessage();
		}
	}
	//proses menuliskan last upload data gempanya
	$myfile = fopen("datagempa_lastupload.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $last_kirim);
	fclose($myfile);
}
echo "Data Updated\n";
?>