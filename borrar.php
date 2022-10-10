<?php
require_once('conexion.php');
// Preparación de la consulta.
$sql = "DELETE FROM datos WHERE estacion= '$_POST[estacion]' ";
$query = mysqli_query($conn, $sql);
mysqli_close($conn);
?>