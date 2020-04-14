<?php

session_start();
include ('hapussession.php');
$usernamelogin=$_POST['username'];
$passwordlogin=md5($_POST['password']);

include ('config.php');

	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$query = $conn->prepare( "SELECT * FROM admin WHERE username= :username AND password= :password " );
	$query->bindParam(':username', $usernamelogin);
	$query->bindParam(':password', $passwordlogin);

	$query->execute();
	while($row=$query->fetch(PDO::FETCH_ASSOC)) {
		$_SESSION['username']=$row['username'];
	}
	if(!isset($_SESSION['username'])){
		header("Location:./index.php?login=gagal");
	}
	else{
		header("Location:./utama.php");
	}
?>
