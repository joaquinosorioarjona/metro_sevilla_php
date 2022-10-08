<?php
require_once('conexion.php');
// Preparación de la consulta.
$sql = "DELETE FROM estaciones WHERE estacion= '$_POST[nombre]' ";
$query = mysqli_query($conn, $sql);
mysqli_close($conn);
?>