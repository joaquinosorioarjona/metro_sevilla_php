<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_sevilla";

// Creamos una conexión
$conn = mysqli_connect($servername, $username, $password, $dbname );

//insertar datos
$sqlinsert = "INSERT INTO estaciones (id,SHAPE) VALUES ('$_POST[nombre]', '$_POST[linea]', '$_POST[lugar]',
ST_PointFromText('SHAPE ($_POST[lat] $_POST[lon])'));";

mysqli_query($conn,$sqlinsert);

    // Preparación de la consulta.
    //$sql = "SELECT ST_X(`punto`) as lat, ST_Y(`punto`) as lon FROM `datos`";
    $sql = "SELECT nombre,ST_X(`SHAPE`) as lat, ST_Y(`SHAPE`) as lon FROM `estaciones`";
    $query = mysqli_query($conn, $sql);
    
     $geojson = array(
    'type'      => 'FeatureCollection',
    'features'  => array()
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

echo json_encode($geojson, JSON_NUMERIC_CHECK);
?>