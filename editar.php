<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_sevilla";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
	exit('Could not connect');
}
$query = "UPDATE estaciones SET nombre = '$_POST[nombre]', linea='$_POST[linea]', lugar='$_POST[lugar]' WHERE id = '$_POST[OGR_FID]';";
$exec = mysqli_query($conn, $query);
if($exec){
	echo "Punto modificado.";
}else{
	$msg = "Error: " . $query. "<br>" . mysqli_error($connection);
	echo $msg;
}
?>