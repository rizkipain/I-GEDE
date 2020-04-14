<?php
function convert_to_rupiah($angka)
	{
		return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
	}

include ('..\config.php');

$tanggal = $_GET['tanggal'];
$jam = $_GET['jam'];
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

	//mengambil data pemohon di pemohon kalibrasi
	$query = $conn->prepare( "SELECT * FROM pemohon_kalibrasi WHERE jam=:jam AND tanggal=:tanggal " );
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
			<td rowspan="6" id="logobmkg" ><img name="logobmkg" src="../gambar/bmkg.png"></td>
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
		<hr id="garisheader">

<table id="tabeljudul">
	<tr>
		<th colspan="3">SURAT PERINTAH KERJA KALIBRASI ALAT (SPKKA)</th>
	</tr>
	<tr>
		<td id="awal1"> NO. SPKA</td>
		<td id="tengah1">:</td>
		<td><label id="spka_order" name="spka_order">
				<?php 	if ($data_no_order < 100 AND $data_no_order >= 10 ) {
											echo "0".$data_no_order;}
								elseif ($data_no_order < 10){
											echo "00".$data_no_order;}
								else {echo $data_no_order;} ?>
				<label></td>
	</tr>
	<tr>
		<td id="awal2">Nama Pelanggan</td>
		<td id="tengah2">:</td>
		<td><?php echo $perusahaan ?></td>
	</tr>
</table>

<table id="tabelsatu">
	<tr>
		<th></th>
		<th>Petugas Layanan Pelanggan</th>
		<th>Kepala Sub Bidang</th>
		<th>Petugas Kalibrasi</th>
	</tr>
	<tr>
		<td>Tanggal Masuk <br><br><br><br> </td>
		<td class="atasparaf"><?php ?></td>
		<td class="atasparaf">Hartanto, S.Si</td>
		<td></td>
	</tr>
	<tr>
		<td>Tanggal Selesai <br><br><br><br> </td>
		<td></td>
		<td class="atasparaf">Hartanto, S.Si</td>
		<td></td>
	</tr>
</table>

<table id="tabeldua">
	<tr>
		<th>No.</th>
		<th>Nama Alat</th>
		<th>Jumlah</th>
		<th>No. Kalibrasi</th>
		<th>Petugas Kalibrasi</th>
		<th>Paraf Selesai</th>
	</tr>
	<?php
		$tambah=0;
		for ($x = 0; $x < $item; $x++) {
			for ($y = 0; $y < $jumlahalat_pisah[$x]; $y++){
					if($y==0){
					echo '<tr>';
						echo '<td rowspan="'.$jumlahalat_pisah[$x].'">'.($x+1).'.</td>';
						echo '<td rowspan="'.$jumlahalat_pisah[$x].'">'.$jenisalat_pisah[$x].'</td>';
						echo '<td rowspan="'.$jumlahalat_pisah[$x].'">'.$jumlahalat_pisah[$x].' Unit</td>';
						if(($data_noid_awal+$tambah)<100 AND ($data_noid_awal+$tambah)>=10){		//cetak jika no id kurang dari 100
							echo '<td>0'.($data_noid_awal+$tambah).'</td>';
						}
						else if(($data_noid_awal+$tambah)<10){
							echo '<td>00'.($data_noid_awal+$tambah).'</td>';
						}
						else{
							echo '<td>'.($data_noid_awal+$tambah).'</td>';
						}
					echo '<td rowspan="'.$jumlahalat_pisah[$x].'"></td>';
					echo '<td rowspan="'.$jumlahalat_pisah[$x].'"></td>';
					echo '</tr>';
					}
					else{
						echo '<tr>';
						if(($data_noid_awal+$tambah)<100 AND ($data_noid_awal+$tambah)>=10){		//cetak jika no id kurang dari 100
							echo '<td>0'.($data_noid_awal+$tambah).'</td>';
						}
						else if(($data_noid_awal+$tambah)<10){
							echo '<td>00'.($data_noid_awal+$tambah).'</td>';
						}
						else{
							echo '<td>'.($data_noid_awal+$tambah).'</td>';
						}
					}
					$tambah++;
			}
		}
	?>
</table>
<table id="nomorkertas">
	<tr>
		<td id="kiri" align="left">F.7.1.2</td>
		<td id="kanan" align="right">Revisi 0</td>
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

			var kalenderku = tanggal+" "+bulanku+" "+tahun;
            return kalenderku;
        }
		window.onload = window.print();
        </script>
</head>
	<link rel="stylesheet" href="styleformspkka_baru.css">
</html>
