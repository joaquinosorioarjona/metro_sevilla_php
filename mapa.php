<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Mapa de la red de transporte ferroviario de Sevilla</title>
	<meta name="viewport" content="initial-scale=1,maximumscale=1,user-scalable=no" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"/>

	<style>
		html {
			height:100%; 
		}#map {
			width: 700px;
			height: 600px; 
		}
		.form-control{
			width: 300px;
			background-color: #ADD8E6;
		}
		.footer {
			position: fixed;
			left: 0;
			bottom: 0;
			width: 100%;
			background-color: #ADD8E6;
			color: white;
			text-align: center;
		}
		
	</style>
</head>
<body>
<div class="container-fluid">
  <h1>Mapa de la red de transporte ferroviario de Sevilla</h1>
  <p>Haciendo clic sobre un punto del mapa se trasladan sus coordenadas al formulario.</p>
  <p>El dato obtenido se envía a una base de datos para su almacenamiento.</p>
	<span>
		<form action="">
			<div id="formulario">
				<select name="customers" onchange="makeRequest(this.value)">
				</select>
			<div>
		</form>
	</span>
	<div id="map"></div>
	<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
	<script src='https://unpkg.com/@turf/turf/turf.min.js'></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="lineas.js"></script>
	
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
	
	var map = L.map('map').setView([37.378944, -5.980278], 12);
	var basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
		
	function popup_lineas (feature, layer) {
		layer.bindPopup("<div style=textalign: center><h6>"+feature.properties.linea+ "<h6></div>",
		{minWidth: 150, maxWidth: 200});
	};
	
	var metro1 = new L.GeoJSON(lineas, {
		filter: metro1filter,
		weight: 4,
		color: "#008000",
		onEachFeature: popup_lineas,
	});
	function metro1filter(feature) {
		if (feature.properties.linea === "Linea 1 de Metro") return true
	}
	
	var metro2 = new L.GeoJSON(lineas, {
		filter: metro2filter,
		weight: 4,
		color: "#0000FF",
		onEachFeature: popup_lineas,
	});
	function metro2filter(feature) {
		if (feature.properties.linea === "Linea 2 de Metro") return true
	}
	
	var metro3 = new L.GeoJSON(lineas, {
		filter: metro3filter,
		weight: 4,
		color: "#FF0000",
		onEachFeature: popup_lineas,
	});
	function metro3filter(feature) {
		if (feature.properties.linea === "Linea 3 de Metro") return true
	}
	
	var metro4 = new L.GeoJSON(lineas, {
		filter: metro4filter,
		weight: 4,
		color: "#FFFF00",
		onEachFeature: popup_lineas,
	});
	function metro4filter(feature) {
		if (feature.properties.linea === "Linea 4 de Metro") return true
	}
	
	var metro = L.layerGroup([metro1, metro2, metro3, metro4]).addTo(map);

	
	var metrocentro = new L.GeoJSON(lineas, {
		filter: metrocentrofilter,
		weight: 2,
		color: "#40E0D0",
		onEachFeature: popup_lineas
	}).addTo(map);
	function metrocentrofilter(feature) {
		if (feature.properties.servicio === "metrocentro") return true
	}
	
	var tranvia = new L.GeoJSON(lineas, {
		filter: tranviafilter,
		weight: 2,
		color: "#DB7093",
		onEachFeature: popup_lineas
	}).addTo(map);
	function tranviafilter(feature) {
		if (feature.properties.servicio === "tranvia") return true
	}
	
	var cercanias = new L.GeoJSON(lineas, {
		filter: cercaniasfilter,
		weight: 1,
		color: "#8B008B",
		onEachFeature: popup_lineas
	}).addTo(map);
	function cercaniasfilter(feature) {
		if (feature.properties.servicio === "cercanias") return true
	}
	
	
	
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
			radius: 5,
			fillColor: "#EE82EE",
			color: "#000",
			weight: 1,
			opacity: 1,
			fillOpacity: 0.8
		};
		
		function popup_estaciones (feature, layer) {
			layer.bindPopup("<div style=textalign: center><h3>"+feature.properties.nombre+ "<h3></div><hr><table><tr><td>Línea: "+feature.properties.linea+ "</td></tr><tr><td>Zona: "+feature.properties.lugar+ "</td></tr><tr><td>Da potencial servicio a "+feature.properties.poblacion+" habitantes</td></tr></table>",
			{minWidth: 150, maxWidth: 200});
		};
		var estaciones = L.geoJSON(geojson, {
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, MarkerOptions);
			},
			onEachFeature: popup_estaciones
		});
		puntos.addLayer(estaciones)
	};
	window.onload = makeRequest("Todos");
	
	var escala = L.control.scale({ position: 'bottomleft', imperial: false, maxWidth: 200});
	map.addControl(escala);
		
	</script>

</body>
</html>
