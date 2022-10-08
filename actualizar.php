<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_sevilla";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
	exit('Could not connect');
$sql = "UPDATE estaciones SET nombre = '$_POST[nombre]', linea='$_POST[linea]', lugar='$_POST[lugar]' WHERE gid = '$_POST[gid]';";
$query = mysqli_query($conn, $sql);
echo "Punto modificado";
?>