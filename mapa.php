<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Mapa de la red de transporte ferroviario de Sevilla</title>
	<meta name="viewport" content="initial-scale=1,maximumscale=1,user-scalable=no" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" />
	<style>
		html {
			height:100%; 
		}#map {
			width: 700px;
			height: 600px; 
		}
	</style>
</head>
<body>
	<span>
		<form action="">
			<div id="formulario">
				<select name="customers" onchange="makeRequest(this.value)">
				</select>
			<div>
		</form>
	</span>
	<div id="map"></div>
	<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
	<script>
	<?php include 'lista-lineas.php'; ?>
	//Create and append the options
	for (var i = 0; i < array.length; i++) {
		var el=document.querySelector("#formulario select[name='customers']");
		var option = document.createElement("option");
		option.setAttribute("value", array[i]);
		option.text = array[i];
		el.appendChild(option);
	}
	
	var map = L.map('map').setView([37.392720, -5.991882], 13);
	var basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
	var puntos = L.layerGroup().addTo(map);
	var http_request = false;
	
	function makeRequest(str) {
		http_request = false;
		if (window.XMLHttpRequest) { // Mozilla, Safari,...
			http_request = new XMLHttpRequest();
			if (http_request.overrideMimeType) {
				//http_request.overrideMimeType('text/xml');
			}
		} else if (window.ActiveXObject) { // IE
			try {
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			}
		}
		if (!http_request) {
			alert('Falla :( No es posible crear una instancia XMLHTTP');
			return false;
		}
		http_request.onreadystatechange = dibujarMapa;
		http_request.open("GET", "conexion.php?q="+str, true);
		http_request.send();
	}
	
	function dibujarMapa() {
		if (http_request.readyState == 4) {
			if (http_request.status == 200) {
			//creamos el mapa de Leaflet
				mimapa();
			} else {
				alert('Hubo problemas con la petición.');
			}
		}
	}
	
	function mimapa(){
		var geojson = JSON.parse(http_request.responseText);
		//console.log(geojson);
		//Borramos el contenido de puntos
		puntos.clearLayers();
		// Creación de la capa de Leaflet
		//Damos estilo a los marcadores;
		var MarkerOptions = {
			radius: 8,
			fillColor: "#ff7800",
			color: "#000",
			weight: 1,
			opacity: 1,
			fillOpacity: 0.8
		};
		
		function colorPuntos(d) {
			return d == "Linea 1 de Metro" ? '#FF0000' :
			d == "Linea 2 de Metro" ? '#00FF00' :
			d == "Linea 3 de Metro" ? '#0000FF' :
			d == "Linea 4 de Metro" ? '#FF00FF' :
			d == "Metrocentro" ? '#FFFF00' :
			d == "Tranvía del Aljarafe" ? '#00FFFF' :
			d == "Tranvía de Dos Hermanas" ? '#00FFFF' :
			d == "Tranvía de Alcalá" ? '#00FFFF' :
			d == "Tranvía del Norte" ? '#00FFFF' :
							'#000000';
		};
		function estilo_estaciones (feature) {
			return{
				radius: 7,
				fillColor: colorPuntos(feature.properties.linea),
				color: colorPuntos(feature.properties.linea),
				weight: 1,
				opacity : 1,
				fillOpacity : 0.8
			};
		};
		function popup_estaciones (feature, layer) {
			layer.bindPopup("<div style=textalign: center><h3>"+feature.properties.nombre+ "<h3></div><hr><table><tr><td>Línea: "+feature.properties.linea+ "</td></tr><tr><td>Zona: "+feature.properties.lugar+ "</td></tr></table>",
			{minWidth: 150, maxWidth: 200});
		};
		var estaciones = L.geoJSON(geojson, {
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, MarkerOptions);
			},
			style:estilo_estaciones,
			onEachFeature: popup_estaciones
		});
		puntos.addLayer(estaciones)
	};
	window.onload = makeRequest("Todos");
	</script>

</body>
</html>
