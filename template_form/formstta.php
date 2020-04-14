<?php
function convert_to_rupiah($angka)
	{
		return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
	}

include ('../config.php');

$tanggal = $_GET['tanggal'];
$jam = $_GET['jam'];
$petugas = $_GET['petugas'];
$tanggal_stta = $_GET['tanggalstta'];

//memasukkan tanggal STTA kedalam database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("UPDATE pemohon_kalibrasi SET tanggal_stta=:tanggal_stta WHERE tanggal=:tanggal AND jam=:jam ");
		$stmt->bindParam(':tanggal_stta', $tanggal_stta);
		$stmt->bindParam(':jam', $jam);
		$stmt->bindParam(':tanggal', $tanggal);
		$stmt->execute();
}
catch(PDOException $e){
            echo "Koneksi Gagal ".$e->getMessage();
}

//pengambilan NIP
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


//pengambilan data lengkap pemohon kalibrasi
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

	//mengambil data pemohon di pemohon kalibrasi
	$query = $conn->prepare( "SELECT * FROM pemohon_kalibrasi WHERE jam=:jam AND tanggal=:tanggal" );
	$query->bindParam(':jam', $jam);
	$query->bindParam(':tanggal', $tanggal);
	$query->execute();
	while($row=$query->fetch(PDO::FETCH_BOTH)){
			$data_no_order=$row['no_order'];
			$data_noid_awal=$row['no_id_awal'];
			$data_noid_akhir=$row['no_id_akhir'];
			$tanggal=$row['tanggal'];
			$nama=$row['nama'];
			$perusahaan=$row['perusahaan'];
			$alamat=$row['alamat'];
			$telepon=$row['telepon'];
			$data_jenisalat=$row['jenisalat'];
			$data_jumlahalat=$row['jumlahalat'];
			$data_noseri=$row['noseri'];
			$data_statusaalat=$row['statusalat'];
			$data_satuanharga=$row['satuanharga'];
			$data_jumlahharga=$row['jumlahharga'];
			$data_jenisalat=$row['jenisalat'];
			$data_keterangan_tambahan=$row['keterangan_tambahan'];
			$data_persetujuan=$row['persetujuan'];
		}

	$jenisalat_pisah = explode("++", $data_jenisalat);
	$jumlahalat_pisah = explode("++",$data_jumlahalat);
	$noseri_pisah = explode("++", $data_noseri);
	$satuanharga_pisah = explode("++", $data_satuanharga);
	$persetujuan_pisah = explode("++",$data_persetujuan);

	$item = 0; //banyaknya item berdasarkan jenis ALAT
	for ($indeksarray=0 ; $indeksarray<=sizeof($jenisalat_pisah)-1 ; $indeksarray++){
		if($jenisalat_pisah[$indeksarray]!="-----Pilih Jenis Alat-----"){
				$item++;
		}
	}



?>

<html>
<head>
<body>

	<div class="isiheader" id="isiheader">
		<table id="atas">
		<tr>
			<td rowspan="6" id="kolom_logobmkg"><img name="logobmkg" src="../gambar/bmkg.png"></td>
			<td><label id="h1">BADAN METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA</label></td>
		</tr>
		<tr>
			<td><label id="h2">BALAI BESAR METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA WILAYAH IV MAKASSAR</label></td>
		</tr>
		<tr>
			<td><label id="h3">LABORATORIUM KALIBRASI BMKG</label></td>
		</tr>
		<tr>
			<td><label id="h4">Jl. Prof. Dr. H. Abdurrahman Basalamah, SE., M.Si. No.4 Panaikang, Kotak Pos 1351, Makassar 90231</label></td>
		</tr>
		<tr>
			<td><label id="h4">Telp. (0411) 456493, 437331 ext.421 Fax. (0411) 455019, 449286 Website : http://balai4.makassar.bmkg.go.id,</label></td>
		</tr>
		<tr>
			<td><label id="h5">Email address : inskal.bbmkg4@bmkg.go.id</label></td>
		</tr>
		</table>
	</div>

<div class="judulatas">
	<label id="judulspka"><b>SURAT TANDA TERIMA ALAT</b></label>
</div>

<div class="pemisah">
<label id="mengajukan">Telah terima dari: Lab. KALIBRASI BMKG, dengan rincian sebagai berikut:<label>
</div>


<table id="isistta">
	<tr>
		<th>No</th>
		<th>Nama Alat</th>
		<th>Jumlah</th>
		<th>Pemilik</th>
		<th>Keterangan</th>
	</tr>
<?php
	for ($x = 0; $x < $item; $x++) {
		echo "<tr>";
		echo '<td>'.($x+1).'.</td>';
		echo '<td id="kolom_jenisalat">'.$jenisalat_pisah[$x].'</td>';
		echo '<td>'.$jumlahalat_pisah[$x].' Unit</td>';
		echo '<td>'.$perusahaan.'</td>';
		echo '<td>Sudah Dikalibrasi</td>';
		echo "</tr>";
	}
?>
</table>

<table id="tandatangan">
	<tr>
		<td></td>
		<td><label id="tanggalnya"><label></td>
	</tr>
		<td> Yang Menerima </td>
		<td> Yang Menyerahkan </td>
	<tr>
		<td id="isi1"> </td>
		<td id="isi3"> </td>
	</tr>
	<tr>
		<td><b><?php echo $nama ?></b></td>
		<td><b><?php echo $petugas ?></b></td>
	</tr>
	<tr>
		<td></td>
		<td><b>NIP. <?php echo $nip ?></b></td>
	</tr>
</table>

<table id="nomorkertas">
	<tr>
		<td id="kiri" align="left">F.7.4.3</td>
		<td id="kanan" align="right">Revisi 0</td>
	</tr>
</table>

</body>
<script>
	function cetaktanggal(kalender) {
		var kalender_pisah = kalender.split("-");
		var bulan = kalender_pisah[1];
		var tanggal = kalender_pisah[2];
		var tahun = kalender_pisah[0];

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

	document.getElementById("tanggalnya").innerHTML = cetaktanggal(<?php echo json_encode($tanggal_stta); ?>);
	function codeAddress() {
			window.print();
	}

window.onload = codeAddress();
</script>
</head>
<link rel="stylesheet" href="styleformstta.css">
</html>
