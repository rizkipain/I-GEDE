<?php
	$urutan = $_GET['urutan'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="12;url=ambil_data_kecamatan.php?urutan=<?php echo $urutan ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="gambar/bmkg.png">
    <title>Berhasil - Redirecting - </title>
</head>
<body>
    <div class="wadah">
        <label id="atas">Proses Pengolahan Data Kecamatan</label>
        <label id="bawah">MOHON TUNGGU </label>
	<label id="bawah">Jangan Sentuh Apapun!!</label>
    </div>
</body>

<link rel="stylesheet" href="css/style_notifikasi.css">
</html>