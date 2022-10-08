<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edicion Example</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<style>
	.footer {
		position: fixed;
		left: 0;
		bottom: 0;
		width: 100%;
		background-color: #ADD8E6;
		color: white;
		text-align: center;
	} </style>
</head>
<body>
<div >
	<h1>Mapa de Leaflet interactivo</h1>
	<p>Haciendo clic sobre un punto del mapa se abre una ventana para la edición.</p>
	<p>El dato modificado se envía a una base de datos PostGis. </p>
	<div style="background-color:lavenderblush;">Haz clic sobre el mapa</div>
	<div id="map" style="width: 100%; height: 700px"></div>
	<script>
	//llamamos al archivo postgisGet.php
	<?php include 'getCiudadsalamanca.php' ?>;
	var map = L.map('map').setView([40.965,-5.664], 15);
	mapLink= '<a href="http://openstreetmap.org">OpenStreetMap</a>';
	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; ' + mapLink + ' Contributors',
		maxZoom: 18,
	}).addTo(map);
	
	function popup(feature, layer) {
		layer.bindPopup ("<ul><h3>" +feature.properties.gid+"</h3><li>Nombre " +feature.properties.nombre+"</li><li>Estilo: " +feature.properties.estilo+"</li><div class='container'><form action='insertar.php' method='post' name='form'><br><label for='nombre'>Nombre:</label><input type='text' name='nombre' value="+feature.properties.nombre+"><br><label for='estilo'>Estilo:</label><input type='text' name='estilo' value="+feature.properties.estilo+"><br><label for='siglo'>Siglo:</label><input type='text' name='siglo' value="+feature.properties.siglo+"><br/><input type='hidden' name='gid' value="+feature.properties.gid+"> <br/><input type='submit' value='Editar datos'></form><div></ul>" )
	};
	
	var geoJsonLayer = L.geoJSON(geoJson,{
		onEachFeature: popup
	}).addTo(map);
	</script>
	</div>
</div>
	<div class="footer">
	<button onclick="myFunction()">Reload page</button>
		<script>
			function myFunction() {
				location.reload();
			}
		</script>
	</div>
</body>
</html>