<?php
require ('membacasession.php');
?>

<html>
<title> I-GEDE </title>
<link rel="shortcut icon" href="gambar/bmkg.png">
<head>
<body>

<div class="isi">
	<div class="frameisi">
		<iframe id="kontennya" src="pembuka.php" frameborder="0"></iframe>
	</div>
	<div class="menu">
		<div class="menu_home">
			<button id="tombol_menuhome" class="menuhome" onclick="buka_kembali()">Menu Utama</button>
		</div>
		<div class="menu_utama">
			<!-- Menu UTAMA -->
			<div class="menuutama animate" id="menuutama">
				<button id="menu_datagempa" class="menutengah" onclick="buka_datagempa()">Data Gempa</button>
				<button id="menu_manual" class="menutengah" onclick="">Dismeninasi Manual</button>
				<button id="menu_otomatis" class="menutengah" onclick="buka_diseminasi_otomatis()">Diseminasi Otomatis</button>
				<button id="menu_setting" class="menutengah" onclick="buka_setting()">Setting</button>
			</div>
			<!-- Data Gempa -->
			<div class="submenu animate" id="submenu_datagempa">
				<button id="menu_datagempa" class="menutengah" onclick="setURL('/utama_datagempa.php')">Update Data Gempa</button>
			</div>


		</div>
		<div class="menu_kembali">
			<button id="tombol_kembali" class="menukembali" onclick="window.location.href='/index.php';">Log Out</button>
		</div>

	</div>
</div>

<script>
		function setURL(url){
			document.getElementById('kontennya').src = url;
		}

		function buka_datagempa(){
			setURL('/utama_datagempa.php');
			document.getElementById('menuutama').style.display = "none";
			document.getElementById('submenu_datagempa').style.display = "flex";
		}
		function buka_diseminasi_otomatis(){
			setURL('/utama_diseminasi_otomatis.php');
		}
		function buka_kembali(){
			document.getElementById('menuutama').style.display = "flex";
			document.getElementById('submenu_datagempa').style.display = "none";
			setURL('pembuka.php');
		}

</script>

</body>
</head>
	<link rel="stylesheet" href="css/styleutama.css" >
</html>
