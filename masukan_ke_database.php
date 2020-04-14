<?php
include ('config.php');
$file_pointer = 'simpan_ini.txt';
if (file_exists($file_pointer))  
{ 

  $fn = fopen("simpan_ini.txt","r");
  $result = fgets($fn);
  
  $pecahan = explode("| ",$result);
/*
  echo $pecahan[0];
  echo "<br>";
  echo $pecahan[1];
  echo "<br>";
  echo $pecahan[2];
  echo "<br>";
  echo $pecahan[3];
  echo "<br>";
  echo $pecahan[4];
  echo "<br>";
  echo $pecahan[5];
  echo "<br>";
  echo $pecahan[6];
  echo "<br>";
  echo $pecahan[7];
  echo "<br>";
  echo $pecahan[8];
  echo "<br>";
  echo $pecahan[9];
  echo "<br>";
  echo $pecahan[10];
  echo "<br>";
  echo $pecahan[11];
  echo "<br>";
  echo $pecahan[12];
  echo "<br>";
  echo $pecahan[13];
  echo "<br>";
  echo $pecahan[14];
*/
  $tanggal_jam = explode(" ",$pecahan[1]);
  date_default_timezone_set('Kuala Lumpur, Singapore');
  $timeutc = $tanggal_jam[0]."T".$tanggal_jam[1]."Z";
  $time1 = strtotime($timeutc.' UTC');

  $tanggal_wita = date("Y-m-d", $time1);
  $jam_wita = date("H:i:s", $time1);
 
  $magnitude = $pecahan[4];
  $metode = $pecahan[2];
  $latitude = $pecahan[7];
  $longitude = $pecahan[8];
  $kedalaman = $pecahan[9];
  $lokasi = $pecahan[10];
  $RMS = $pecahan[11];
  $azimuth_gap = $pecahan[12];

  $pecah_phase_arrival = explode(" ",$pecahan[13]);
  $phase_arrival_sta  = "" ;
  $phase_arrival_net  = "" ;
  $phase_arrival_dist = "" ;
  $phase_arrival_azi  = "" ;
  $phase_arrival_phase = "" ;
  $phase_arrival_time  = "" ;
  $phase_arrival_res = "" ;
  $phase_arrival_wt  = "" ;

  for ($x = 0; $x < $pecah_phase_arrival[0]; $x++) {
    $phase_arrival_sta = $phase_arrival_sta."++".$pecah_phase_arrival[12+$x*10];
    $phase_arrival_net = $phase_arrival_net."++".$pecah_phase_arrival[13+$x*10];
    $phase_arrival_dist = $phase_arrival_dist."++".$pecah_phase_arrival[14+$x*10];
    $phase_arrival_azi = $phase_arrival_azi."++".$pecah_phase_arrival[15+$x*10];
    $phase_arrival_phase = $phase_arrival_phase."++".$pecah_phase_arrival[16+$x*10];
    $phase_arrival_time = $phase_arrival_time."++".$pecah_phase_arrival[17+$x*10];
    $phase_arrival_res = $phase_arrival_res."++".$pecah_phase_arrival[18+$x*10];
    $phase_arrival_wt = $phase_arrival_wt."++".$pecah_phase_arrival[19+$x*10];
  }

  $pecah_magnitudes = explode(" ",$pecahan[14]);
  $magnitudes_sta = "" ;
  $magnitudes_net = "" ;
  $magnitudes_dist = "" ;
  $magnitudes_azi = "" ;
  $magnitudes_type = "" ;
  $magnitudes_value = "" ;
  $magnitudes_res = "" ;
  $magnitudes_amp = "" ;

  for ($x = 0; $x < $pecah_magnitudes[0]; $x++) {
    $magnitudes_sta = $magnitudes_sta."++".$pecah_magnitudes[12+$x*8];
    $magnitudes_net = $magnitudes_net."++".$pecah_magnitudes[13+$x*8];
    $magnitudes_dist = $magnitudes_dist."++".$pecah_magnitudes[14+$x*8];
    $magnitudes_azi = $magnitudes_azi."++".$pecah_magnitudes[15+$x*8];
    $magnitudes_type = $magnitudes_type."++".$pecah_magnitudes[16+$x*8];
    $magnitudes_value = $magnitudes_value."++".$pecah_magnitudes[17+$x*8];
    $magnitudes_res = $magnitudes_res."++".$pecah_magnitudes[18+$x*8];
    $magnitudes_amp = $magnitudes_amp."++".$pecah_magnitudes[19+$x*8];
  }

  fclose($fn);

		try {
    			$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    			// set the PDO error mode to exception
    			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			// prepare sql and bind parameters
    			$stmt = $conn->prepare("INSERT INTO database_utama (tanggal, jam, metode, magnitude, latitude, longitude, 
                                                                            kedalaman, lokasi, RMS, azimuthgap, phase_arrival_sta, phase_arrival_net,
									    phase_arrival_dist, phase_arrival_azi, phase_arrival_phase,
									    phase_arrival_time, phase_arrival_res, phase_arrival_wt, magnitudes_sta,
									    magnitudes_net, magnitudes_dist, magnitudes_azi, magnitudes_type, magnitudes_value, magnitudes_res, magnitudes_amp)
    			VALUES (:tanggal, :jam, :metode, :magnitude, :latitude, :longitude, 
                                :kedalaman, :lokasi, :RMS, :azimuthgap, :phase_arrival_sta, :phase_arrival_net,
				:phase_arrival_dist, :phase_arrival_azi, :phase_arrival_phase,
				:phase_arrival_time, :phase_arrival_res, :phase_arrival_wt, :magnitudes_sta,
		   		:magnitudes_net, :magnitudes_dist, :magnitudes_azi, :magnitudes_type, 
				:magnitudes_value, :magnitudes_res, :magnitudes_amp)");

    			$stmt->bindParam(':tanggal', $tanggal_wita);
			$stmt->bindParam(':jam', $jam_wita);
			$stmt->bindParam(':metode', $metode);
			$stmt->bindParam(':magnitude', $magnitude);
			$stmt->bindParam(':latitude', $latitude);
			$stmt->bindParam(':longitude', $longitude);
			$stmt->bindParam(':kedalaman', $kedalaman);
  			$stmt->bindParam(':lokasi', $lokasi);
			$stmt->bindParam(':RMS', $RMS);
			$stmt->bindParam(':azimuthgap', $azimuth_gap);
			$stmt->bindParam(':phase_arrival_sta', $phase_arrival_sta);
			$stmt->bindParam(':phase_arrival_net', $phase_arrival_net);
			$stmt->bindParam(':phase_arrival_dist', $phase_arrival_dist);
			$stmt->bindParam(':phase_arrival_azi', $phase_arrival_azi);
			$stmt->bindParam(':phase_arrival_phase', $phase_arrival_phase);
			$stmt->bindParam(':phase_arrival_time', $phase_arrival_time);
			$stmt->bindParam(':phase_arrival_res', $phase_arrival_res);
			$stmt->bindParam(':phase_arrival_wt', $phase_arrival_wt);
			$stmt->bindParam(':magnitudes_sta', $magnitudes_sta);
			$stmt->bindParam(':magnitudes_net', $magnitudes_net);
			$stmt->bindParam(':magnitudes_dist', $magnitudes_dist);
			$stmt->bindParam(':magnitudes_azi', $magnitudes_azi);
			$stmt->bindParam(':magnitudes_type', $magnitudes_type);
			$stmt->bindParam(':magnitudes_value', $magnitudes_value);
			$stmt->bindParam(':magnitudes_res', $magnitudes_res);
			$stmt->bindParam(':magnitudes_amp', $magnitudes_amp);
			
			$stmt->execute();
		}
		catch(PDOException $e){
            		echo "Koneksi Gagal ".$e->getMessage();
		}

  echo "data tersimpan";
  unlink($file_pointer); 
}

else 
{ 
    echo "Tidak ada data baru\n"; 
} 
?>