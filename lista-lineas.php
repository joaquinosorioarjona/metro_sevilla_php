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
$sql = "SELECT linea FROM lineas ORDER BY objectid";
$query = mysqli_query($conn, $sql);
if (!$query) {
	echo "An error occurred.\n";
exit;
}
echo "var array = [";
while ($row = mysqli_fetch_assoc($query)) {
	echo "'".$row['linea']."',";
}
echo "];";
?>
    
