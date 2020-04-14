<?php
function convert_to_rupiah($angka)
	{
		return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
	}

include ('../config.php');

$tanggal = $_GET['tanggal'];
$jam = $_GET['jam'];
$petugas = $_GET['petugas'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  	$query = $conn->prepare( "SELECT * FROM petugas_layanan WHERE nama=:nama " );
		$query->bindParam(':nama', $petugas);
  	$query->execute();
    while($row=$query->fetch(PDO::FETCH_BOTH)){
      $nip=$row['nip'];
    }
}
catch(PDOException $e){
            echo "Koneksi Gagal ".$e->getMessage();
}

$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

	//mengambil data pemohon di pemohon kalibrasi
	$query = $conn->prepare( "SELECT * FROM pemohon_datin_2020 WHERE jam=:jam AND tanggal=:tanggal " );
	$query->bindParam(':jam', $jam);
	$query->bindParam(':tanggal', $tanggal);
	$query->execute();
	while($row=$query->fetch(PDO::FETCH_BOTH)){
			$data_nama=$row['nama'];
			$data_perusahaan=$row['perusahaan'];
			$data_alamat=$row['alamat'];
			$data_telepon=$row['telepon'];
			$data_jenisdatin=$row['jenisdatin'];
			$data_jenissatuan1=$row['jenissatuan1'];
			$data_jenissatuan2=$row['jenissatuan2'];
			$data_jenissatuan3=$row['jenissatuan3'];
			$data_jumlahsatuan1=$row['jumlahsatuan1'];
			$data_jumlahsatuan2=$row['jumlahsatuan2'];
			$data_jumlahsatuan3=$row['jumlahsatuan3'];
			$data_satuanharga=$row['satuanharga'];
			$data_keterangan=$row['keterangan'];
			$data_totalharga=$row['totalharga'];
			$data_tandatangan=$row['tandatangan'];
			$data_fotoktp=$row['fotoktp'];
		}

		$pisah_jenisdatin = explode("++",$data_jenisdatin);
		$pisah_jenissatuan1 = explode("++",$data_jenissatuan1);
		$pisah_jenissatuan2 = explode("++",$data_jenissatuan2);
		$pisah_jenissatuan3 = explode("++",$data_jenissatuan3);
		$pisah_jumlahsatuan1 = explode("++",$data_jumlahsatuan1);
		$pisah_jumlahsatuan2 = explode("++",$data_jumlahsatuan2);
		$pisah_jumlahsatuan3 = explode("++",$data_jumlahsatuan3);
		$pisah_satuanharga = explode("++",$data_satuanharga);
		$pisah_keterangan = explode("++",$data_keterangan);

$jumlah_terpilih = sizeof($pisah_jenisdatin);
?>

<html>
<head>
<body>

<div class="borderluar">
		<div id="judul">
			<label id="judulspka">FORMULIR PERMINTAAN JASA INFORMASI DATA</label>
		</div>

		<table id="isi_identitas">
			<tr class="kolom">
				<td id="awal1">NAMA PEMOHON</td>
				<td id="tengah1">:</td>
				<td id="akhir1"><?php echo $data_nama ?></td>
			</tr>
			<tr class="kolom">
				<td id="awal2">NAMA PERUSAHAAN/INSTANSI</td>
				<td id="tengah2">:</td>
				<td id="akhir2"><?php echo $data_perusahaan ?></td>
			</tr>
			<tr class="kolom">
				<td id="awal3">ALAMAT</td>
				<td id="tengah3">:</td>
				<td id="akhir3"><?php echo $data_alamat ?></td>
			</tr>
			<tr class="kolom">
				<td id="awal4">NO.TELP/HP</td>
				<td id="tengah4">:</td>
				<td id="akhir4"><?php echo $data_telepon ?></td>
			</tr>
			<tr class="kolom">
				<td id="awal5">BIAYA <br> <label id="pengecualian">(Berdasarkan PP No. 47 tahun 2018)</label></td>
				<td id="tengah5" rowspan="2">:</td>
				<td id="akhir5" rowspan="2"><?php echo convert_to_rupiah($data_totalharga) ?></td>
			</tr>

		</table>

		<?php
		echo '<table id="isi_permintaandatin">';
		echo '<th>Jenis Datin</th>';
		echo '<th colspan="3">Satuan</th>';
		echo '<th>Keterangan/Periode</th>';
		echo '<th>Biaya</th>';

		for ($indekstabel=0 ; $indekstabel<$jumlah_terpilih ; $indekstabel++){
			echo '<tr>';
			echo '<td id="kolom2">' .$pisah_jenisdatin[$indekstabel]. "</td>";
			
			if($pisah_jenissatuan2[$indekstabel]==""){
				echo '<td id="kolom3" colspan="3">' .$pisah_jumlahsatuan1[$indekstabel].' '.$pisah_jenissatuan1[$indekstabel]."</td>";
			}
			elseif($pisah_jenissatuan3[$indekstabel]==""){
				echo '<td id="kolom3">' .$pisah_jumlahsatuan1[$indekstabel].' '.$pisah_jenissatuan1[$indekstabel]."</td>";
				echo '<td id="kolom4" colspan="2">' .$pisah_jumlahsatuan2[$indekstabel].' '.$pisah_jenissatuan2[$indekstabel]."</td>";
			}
			else{
				echo '<td id="kolom3">' .$pisah_jumlahsatuan1[$indekstabel].' '.$pisah_jenissatuan1[$indekstabel]."</td>";
				echo '<td id="kolom4">' .$pisah_jumlahsatuan2[$indekstabel].' '.$pisah_jenissatuan2[$indekstabel]."</td>";
				echo '<td id="kolom5">' .$pisah_jumlahsatuan3[$indekstabel].' '.$pisah_jenissatuan3[$indekstabel]."</td>";
			}

			echo '<td id="kolom6">' .$pisah_keterangan[$indekstabel]."</td>";
			echo '<td id="kolom7">' .convert_to_rupiah($pisah_satuanharga[$indekstabel]). "</td>";
			echo '</tr>';
		}

		echo '</table>';
		?>


		<table id="tandatangan_pemohon">
			<tr>
				<td><label id="tanggalnya"><label></td>
			</tr>
				<td>Pemohon</td>
			<tr>
				<td id="isi"> <?php echo '<img id="tantangan_pemohon" src="'.$data_tandatangan.'">'; ?> </td>
			</tr>
				<td><b><?php echo $data_nama ?></b></td>
		</table>

</div>
		<table id="tandatangan_petugas">
			<tr>
				<td>Mengetahui:</td>
			</tr>
				<td>Petugas Unit Pelayanan Jasa</td>
			<tr>
			</tr>
				<td id="isi"></td>
			<tr>
				<td><b><?php echo $petugas ?></b></td>
			</tr>
				
		</table>
</body>
<script>
function cetaktanggal(kalender) {
		var kalender_pisah = kalender.split("/");
		var bulan = kalender_pisah[1];
		var tanggal = kalender_pisah[0];
		var tahun = kalender_pisah[2];

		if(bulan=="01"){
			var bulanku = "Januari";
		}
		else if(bulan=="02"){
			var bulanku = "Februari";
		}
		else if(bulan=="03"){
			var bulanku = "Maret";
		}
		else if(bulan=="04"){
			var bulanku = "April";
		}
		else if(bulan=="05"){
			var bulanku = "Mei";
		}
		else if(bulan=="06"){
			var bulanku = "Juni";
		}
		else if(bulan=="07"){
			var bulanku = "Juli";
		}
		else if(bulan=="08"){
			var bulanku = "Agustus";
		}
		else if(bulan=="09"){
			var bulanku = "September";
		}
		else if(bulan=="10"){
			var bulanku = "Oktober";
		}
		else if(bulan=="11"){
			var bulanku = "November";
		}
		else if(bulan=="12"){
			var bulanku = "Desember";
		}

		var kalenderku = "Makassar, "+tanggal+" "+bulanku+" "+tahun;
				return kalenderku;
		}
		function codeAddress() {
				window.print();
		}
		document.getElementById("tanggalnya").innerHTML = cetaktanggal(<?php echo json_encode($tanggal); ?>);
		window.onload = codeAddress();
</script>
</head>
	<link rel="stylesheet" href="styleformpermintaandatin.css">
</html>
