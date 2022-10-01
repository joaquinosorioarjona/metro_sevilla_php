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

if ($_GET["q"] === "Todos") {
	$sql = "SELECT ST_X(SHAPE) as lon, ST_Y(SHAPE) as lat, nombre, linea, lugar FROM estaciones";
	} else {
		$sql = "SELECT ST_X(SHAPE) as lon, ST_Y(SHAPE) as lat, nombre, linea, lugar FROM estaciones WHERE linea= '$_GET[q]'";
	}
	
$query = mysqli_query($conn, $sql);
$geojson = array(
	'type' => 'FeatureCollection',
	'features' => array()
);
while($row = mysqli_fetch_assoc($query)) {
	$marker = array(
		'type' => 'Feature',
		'features' => array(
			'type' => 'Feature',
			'geometry' => array(
				'type' => 'Point',
				'coordinates' => array((float)$row['lon'], (float)$row['lat'])
			),
			'properties' => array(
				'nombre' => $row['nombre'],
				'linea' => $row['linea'],
				'lugar' => $row['lugar'],
			)
		)
	);
	array_push($geojson['features'], $marker['features']);
};
mysqli_close($conn);
echo json_encode($geojson, JSON_UNESCAPED_UNICODE);
?>
