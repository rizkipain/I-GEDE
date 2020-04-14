<?php
include ('config.php');
$file_pointer = 'simpan_ini.txt';
if (file_exists($file_pointer))  
{ 

  $fn = fopen("simpan_ini.txt","r");
  $result = fgets($fn);
  
  $pecahan = explode("| ",$result);

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
  $RMS = $pecahan[10];
  $azimuth_gap = $pecahan[11];

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

  echo "data tersimpan"; 
}

else 
{ 
    echo "Tidak ada data baru\n"; 
} 
?>