<?php
function convert_to_rupiah($angka)
	{
		return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
	}

include ('../config.php');

$tanggal = $_GET['tanggal'];
$jam = $_GET['jam'];
$petugas = $_GET['petugas'];
$pemeriksa = $_GET['pemeriksa'];
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

	//mengambil data pemohon di pemohon kalibrasi
	$query = $conn->prepare( "SELECT * FROM pemohon_kalibrasi_2020 WHERE jam=:jam AND tanggal=:tanggal " );
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
			$data_tandatangan=$row['tandatangan'];
			$data_fotoktp=$row['fotoktp'];
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
			<td rowspan="6" id="logobmkg" ><img name="logobmkg" src="../img/bmkg.png"></td>
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


<div class="judulatas">
	<label id="judulspka">SURAT PERMOHONAN KALIBRASI ALAT (SPKA)</label>
</div>

	<table id="tablesatu">
	<tr>
		<td id="awal1"><label>No. Order</label></td>
		<td><label>:</label></td>
		<td><label id="spka_order" name="spka_order">
				<?php 	if ($data_no_order < 100 AND $data_no_order >= 10 ) {
											echo "0".$data_no_order;}
								elseif ($data_no_order < 10){
											echo "00".$data_no_order;}
								else {echo $data_no_order;} ?>
				<label></td>
	</tr>
	<tr>
		<td id="awal2"><label>Nama Pemohon</label></td>
		<td><label>:</label></td>
		<td><label id="spka_nama" name="spka_nama"><?php echo $nama ?><label></td>
	</tr>
		<tr>
		<td id="awal3"><label>Nama Pemilik</label></td>
		<td><label>:</label></td>
		<td><label id="spka_pemilik" name="spka_pemilik"><?php echo $perusahaan ?><label></td>
	</tr>
	<tr>
		<td id="awal4"><label>Alamat</label></td>
		<td><label>:</label></td>
		<td><label id="spka_alamat" name="spka_alamat"><?php echo $alamat ?><label></td>
	</tr>
	<tr>
		<td id="awal5"><label>No. Telp/Fax</label></td>
		<td><label>:</label></td>
		<td><label id="spka_tlp" name="spka_tlp"><?php echo $telepon ?><label></td>
	</tr>
	</table>

		<div class="pemisah">
		<label id="mengajukan">Mengajukan permohonan untuk kalibrasi alat sebagai berikut:<label>
		</div>

	<table id="tabledua">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Nama Alat</th>
			<th rowspan="2">Jumlah</th>
			<th rowspan="2">No. Seri</th>
			<th rowspan="2">No. ID</th>
			<th colspan="5">Kaji Ulang</th>
			<th rowspan="2">Biaya Satuan</th>
			<th rowspan="2">Keterangan</th>
		</tr>
		<tr>
			<th>A</th>
			<th>B</th>
			<th>C</th>
			<th>D</th>
			<th>E</th>
		</tr>

		<?php
		$tambah = 0;
			for ($x = 0; $x < $item; $x++) {
				$noseri_pisahku = explode(";", $noseri_pisah[$x]);
				for ($y = 0; $y < $jumlahalat_pisah[$x]; $y++){
					if($y==0){
					echo '<tr>';
						echo '<td rowspan="'.$jumlahalat_pisah[$x].'">'.($x+1).'.</td>';
						echo '<td rowspan="'.$jumlahalat_pisah[$x].'">'.$jenisalat_pisah[$x].'</td>';
						echo '<td rowspan="'.$jumlahalat_pisah[$x].'">'.$jumlahalat_pisah[$x].' Unit</td>';
						echo '<td>'.$noseri_pisahku[$y].'</td>';
						if(($data_noid_awal+$tambah)<100 AND ($data_noid_awal+$tambah)>=10){		//cetak jika no id kurang dari 100
							echo '<td>0'.($data_noid_awal+$tambah).'</td>';
						}
						else if(($data_noid_awal+$tambah)<10){
							echo '<td>00'.($data_noid_awal+$tambah).'</td>';
						}
						else{
							echo '<td>'.($data_noid_awal+$tambah).'</td>';
						}
					echo '<td>v</td><td>v</td><td>v</td><td>v</td><td>v</td>';
					echo '<td>'.convert_to_rupiah($satuanharga_pisah[$x]/$jumlahalat_pisah[$x]).'</td>';
					echo '<td rowspan="'.$jumlahalat_pisah[$x].'"></td>';
					echo '</tr>';
					}
					else{
						echo '<tr>';
						echo '<td>'.$noseri_pisahku[$y].'</td>';
						if(($data_noid_awal+$tambah)<100 AND ($data_noid_awal+$tambah)>=10){		//cetak jika no id kurang dari 100
							echo '<td>0'.($data_noid_awal+$tambah).'</td>';
						}
						else if(($data_noid_awal+$tambah)<10){
							echo '<td>00'.($data_noid_awal+$tambah).'</td>';
						}
						else{
							echo '<td>'.($data_noid_awal+$tambah).'</td>';
						}
						echo '<td>v</td><td>v</td><td>v</td><td>v</td><td>v</td>';
						echo '<td>'.convert_to_rupiah($satuanharga_pisah[$x]/$jumlahalat_pisah[$x]).'</td>';
						echo '</tr>';
					}
					$tambah++;
			}
			}
		?>

	</table>

	<div class="wadah_tabeltiga">
			<table id="tabletiga_kiri">
			<tr>
				<td colspan="3"><label><b><i>Note:</b></i></label></td>
			</tr>
			<tr>
				<td colspan="2"><label><b><u>Syarat dan Ketentuan:</b></u></label></td>
			</tr>
			<tr>
				<td valign="top"><label>1.</label></td>
				<td align="justify"><label>Pembayaran dapat dilakukan di Pelayanan Terpadu Satu Pintu (PTSP)</label></td>
			<tr>
				<td valign="top"><label>2.</label></td>
				<td align="justify"><label>Alat dan sertifikat kalibrasi dapat diambil dengan menunjukkan bukti pesanan dan kwitansi pembayaran yang sah atau berdasarkan perjanjian
							tambahan yang telah disetujui oleh kedua belah pihak</label></td>
			</tr>
			<tr>
				<td valign="top"><label>3.</label></td>
				<td align="justify"><label>Laboratorium Kalibrasi BMKG <b>tidak bertanggung jawab</b> atas alat yang tidak diambil dalam waktu <b>3 bulan sejak diterima</b> dan
							apabila terjadi <b>force majeure selama proses kalibrasi</b></label></td>
			</tr>
			<tr>
				<td colspan="2"><label><b><u>Tambahan:</b></u></label></td>
			</tr>
			<tr>
				<td valign="top"><label>1.</label></td>
				<td align="justify">Laboratorium kalibrasi BMKG menjamin kerahasiaan data pelanggan, kecuali diminta berdasarkan hukun</td>
			</tr>
			<tr>
				<td valign="top"><label>2.</label></td>
				<td align="justify">Pelanggan <label id="persetujuan"><b>menyetujui</label>/<label id="ketidaksetujuan">tidak menyetujui</b></label> pelaksanaan kalibrasi ulang, jika <i>adjustment</i> diperlukan dan biaya kalibrasi ulang menjadi tanggung jawab pelanggan</label></td>
			</tr>
			<tr>
				<td valign="top"><label>3.</label></td>
				<td align="justify">Pelanggan <label id="persetujuan"><b>menyetujui</label>/<label id="ketidaksetujuan">tidak menyetujui</b></label> dicantumkannya interval kalibrasi didalam sertifikat</label></td>
			</tr>
			<tr>
				<td valign="top"><label>4.</label></td>
				<td align="justify">Pelanggan <label id="persetujuan"><b>menyetujui</label>/<label id="ketidaksetujuan">tidak menyetujui</b></label> dicantumkan kesesuaian spesifikasi didalam sertifikat kalibrasi</label></td>
			</tr>
			<?php
				if($data_keterangan_tambahan!=null){
					echo '<tr>';
					echo '<td>5.</td>';
					echo '<td>'.$data_keterangan_tambahan.'.</td>';
					echo '</tr>';
				}
			?>
			</table>
			<table id="tabletiga_kanan">
				<tr id="atas">
					<td colspan="2" align="left"><label><b><u>Keterangan Kaji Ulang:</b></u></label></td>
				</tr>
				<tr>
					<td id="spacer"></td>
				</tr>
				<tr id="tengah1">
					<td align="right"><b>A.</b></td>
					<td>Kesesuaian Ruang Lingkup</td>
				</tr>
				<tr id="tengah2">
					<td align="right"><b>B.</b></td>
					<td>Kesesuaian Metode</td>
				</tr>
				<tr id="tengah3">
					<td align="right"><b>C.</b></td>
					<td>Keseiapan SDM</td>
				</tr>
				<tr id="tengah4">
					<td align="right"><b>D.</b></td>
					<td>Visual Check</td>
				</tr>
				<tr id="tengah15">
					<td align="right"><b>E.</b></td>
					<td>Waktu Pengerjaan</td>
				</tr>
				<tr>
					<td id="spacer"></td>
				</tr>
				<tr id="bawah">
					<td colspan="2" align="left"><label>Isi Kolom A s/d E dengan tanda v dan tanda x bila tidak sesuai</label></td>
				</tr>
			</table>
	</div>

	<table id="tandatangan">
		<tr>
			<td></td>
			<td></td>
			<td><label id="tanggalnya"><label></td>
		</tr>
			<td> Diterima Oleh,</td>
			<td> Pemeriksa,</td>
			<td> Pemohon,</td>
		<tr>
			<td id="isi1"> </td>
			<td id="isi2"> </td>
			<td id="isi3"> <?php echo '<img id="ttd" src="', $data_tandatangan, '">'; ?> </td>
		</tr>
			<td><b><?php echo $petugas ?></b></td>
			<td><b><?php echo $pemeriksa ?></b></td>
			<td><b><?php echo $nama ?></b></td>
	</table>

	<table id="nomorkertas">
		<tr>
			<td id="kiri" align="left">F.7.1.1</td>
			<td id="kanan" align="right">Revisi 0</td>
		</tr>
	</table>

	<p style="page-break-before:always;">

	<div class="simola">
	<label id="pembukasimola"> No ID dan Password : </label>
		<?php
			echo '<table id="tablesimola">';
			echo '<tr>';
			echo '<th>Alat</th>';
			echo '<th>ID</th>';
			echo '<th>Password</th>';
			echo '</tr>';

			$kalender_pisah = explode("/",$tanggal);

			for ($x = 0; $x < $tambah; $x++) {
				echo '<tr>';
				echo '<td>Untuk Alat '.($x+1).'</td>';
				if(($data_noid_awal+$x)<100 AND ($data_noid_awal+$x)>=10){
					echo '<td>'.$kalender_pisah[2].'0'.($data_noid_awal+$x).'</td>';
				}
				else if(($data_noid_awal+$x)<10){
					echo '<td>'.$kalender_pisah[2].'00'.($data_noid_awal+$x).'</td>';
				}
				else{
					echo '<td>'.$kalender_pisah[2].'</td>';
				}

				if($data_no_order<100 AND $data_no_order>=10){
					echo '<td>'.$kalender_pisah[2].'0'.$data_no_order.'</td>';
				}
				elseif($data_no_order<10){
					echo '<td>'.$kalender_pisah[2].'00'.$data_no_order.'</td>';
				}
				else{
					echo '<td>'.$kalender_pisah[2].$data_no_order.'</td>';
				}

				echo '</tr>';
			}
			echo '</table>';
		?>
	<label id="tengahsimola"> Untuk status kalibrasi yang terupdate, silahkan mengakses http://simola.balai4.bmkg.go.id atau  mengunduh aplikasi BBMKG 4.0: </label>
	<br>
	<img id="petunjuk_simola" src="../img/petunjuk_simola.png"></img>
	<br>
	<label id="penutup simola"> Contact Person: <b>081355976902</b> </label>
	<br>
	<br>
	<label id="penutup simola"> Terimakasih untuk kepercayaannya. </label>
	</div>
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

		function cekpersetujuan(){
			var listpersetujuan = <?php echo json_encode($persetujuan_pisah); ?>;
			var persetujuan = document.querySelectorAll("#persetujuan");
			var ketidaksetujuan = document.querySelectorAll("#ketidaksetujuan");
			for(var i=0; i<=2; i++){
				if(listpersetujuan[i]=="on"){
					ketidaksetujuan[i].innerHTML = '<strike>' + ketidaksetujuan[i].innerHTML + '</strike>';
				}
				if(listpersetujuan[i]!="on"){
					persetujuan[i].innerHTML = '<strike>' + persetujuan[i].innerHTML + '</strike>';
				}
			}
		}

		document.getElementById("tanggalnya").innerHTML = cetaktanggal(<?php echo json_encode($tanggal); ?>);
		window.onload = cekpersetujuan();
        window.onload = codeAddress();
        </script>
</head>
<link rel="stylesheet" href="styleformspka.css">
</html>
