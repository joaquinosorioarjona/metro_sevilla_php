<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "puntos";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname );
 // Check connection
  
    if (! $conn) {
      exit('Fallo en la conexión.');
    }
    // Preparación de la consulta.
    $sql = "SELECT ST_X(`punto`) as lat, ST_Y(`punto`) as lon FROM `datos`";
    $query = mysqli_query($conn, $sql);
		
	 $data = array();
 
	echo "var planelatlong = [";
    
    for ($x = 0; $x < mysqli_num_rows($query); $x++) {
        $data[] = mysqli_fetch_assoc($query);
        echo "[",$data[$x]['lat'],",",$data[$x]['lon'],"]";
        if ($x <= (mysqli_num_rows($query)-2) ) {
			echo ",";
		}
    }
    
    	echo "];";	
		
    // Desconexión.
    $ok = mysqli_close($conn);
	
    ?>
