<?php
session_start();
session_destroy();
if(isset($_GET['login'])) {
	echo "<script>alert('Username atau Password Salah');</script>";
} else {
}
?>
<html>
<title> Layanan BBMKG 4.0 </title>
<link rel="shortcut icon" href="gambar/bmkg.png">
<head>
	<script src="js/jquery.min.js"></script>
	<script src="js/nozoom.js"></script>
<body>
<div class="wadah">
<div class="kiri">
	<label id="judul1"> Earthquake Dissemination System </label>
	<label id="judul2"> Pusat Gempa Regional IV </label>
	<img src="gambar/bmkg.png">
	<form action="proseslogin.php" method="post">
		<div class="kontenlogin">
			<input type="name" name="username" placeholder="username">
			<input type="password" name="password" placeholder="password">
			<button type="submit"><b>login</b></button>
		</div>
	</form>
	<label id="judul3"> Version 1.0 by SeptiTank </label>
</div>

<div class="kanan">

</div>
</div>

</body>
</head>
<link rel="stylesheet" href="css/styleindex.css">
</html>
