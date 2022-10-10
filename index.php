<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximumscale=1.0,user-scalable=no" />
	<title>Mapa de la red de transporte ferroviario de Sevilla</title>
	
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl/1.13.1/mapbox-gl.min.css" />
	<link rel="stylesheet" href="sidebar-v2-master/css/leaflet-sidebar.css" />
	
	<style>
		.icon {
		max-width: 70%;
		max-height: 70%;
		margin: 4px;
		}
		body {
			height: 95%;
			background-color: #CD5C5C;
			padding: 0;
			margin: 0;
		}
		html, #map {
			height:100%;
			font: 10pt "Helvetica Neue", Arial, Helvetica, sans-serif;
		}#map {
			width: 100%;
			height: 890px; 
			box-shadow: 5px 5px 5px #888;
		}
		.form-control{
			width: 300px;
			background-color: #ADD8E6;
		}
		header {
			background-color: #CD5C5C;  
			color: #FFFFFF;
			font: 15px Calibri, sans-serif;
			text-align: center;
			height: 3%;
		}
		.leaflet-control {
			margin: 0px 5px;
		}
		.leaflet-control-layers-expanded {
			background: #CD5C5C none repeat scroll 0 0;
			color: #FFFFFF;
			font: 15px Calibri, sans-serif;
			padding: 6px 10px 6px 6px;
		}
		.legend {
			background: #CD5C5C none repeat scroll 0 0;
			color: #FFFFFF;
			font: 15px Calibri, sans-serif;
			padding: 6px;		
			line-height: 18px;
		} 
		.legend i{
			width: 18px;
			height: 18px;
			float: left;
			margin-right: 2px;
			opacity: 0.7;
		}
		.sidebar-header{
			background-color: #CD5C5C;
			color: #FFFFFF;
		}
		.sidebar-tabs > li.active, .sidebar-tabs > ul > li.active {
			color: #fff;
			background-color: #CD5C5C; 
		}
		.lorem {
			font-style: italic;
			color: #666666;
		}
	</style>
</head>
<body>
	<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
	<script src='https://unpkg.com/@turf/turf/turf.min.js'></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl/1.13.1/mapbox-gl.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl-leaflet/0.0.15/leaflet-mapbox-gl.min.js"></script>
	<script src="sidebar-v2-master/js/leaflet-sidebar.js"></script>
	<script src="https://unpkg.com/leaflet-filelayer@1.2.0"></script>
	<script src="lineas.js"></script>

	<header>
		<h1>Mapa de propuesta de la red completa de transporte ferroviario del Área Metropolitana de Sevilla</h1>
	</header>
	
		<div class="container-fluid" align="right">
		<span>
			<form action="">
				<div id="formulario">
					<select name="customers" onchange="makeRequest(this.value)">
					<option value="Todos">Todos</option>
					</select>
				<div>
			</form>
		</span>
		
	<div id="sidebar" class="sidebar collapsed">
		<div class="sidebar-tabs">
		<ul role="tablist">
			<li><a href="#home" role="tab"><i class="fa fa-info"></i></a></li>
			<li><a href="#planos" role="tab"><i class="fa fa-map"></i></a></li>
			<li><a href="#poblacion" role="tab"><i class="fa fa-users"></i></a></li>
			<li><a href="#puntos" role="tab"><i class="fa fa-map-marker"></i></a></li>
			<li><a href="#buffer" role="tab"><i class="fa fa-circle-o"></i></a></li>
			<li><a href="#fuentes" role="tab"><i class="fa fa-link"></i></a></li>
			<li><a href="https://www.youtube.com/watch?v=xx5t_-hmbQg" role="tab"><i class="fa fa-youtube"></i></a></li>
			<li><a href="https://es.wikipedia.org/wiki/Metro_de_Sevilla" role="tab"><i class="fa fa-wikipedia-w"></i></a></li>
		</ul>
		</div>
	<div class="sidebar-content">
		<div class="sidebar-pane" id="home">
			<h1 class="sidebar-header">
				Red ferroviaria completa de Sevilla
				<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
			</h1>
			<p class="lorem">El Área Metropolitana de Sevilla es una de las aglomeraciones urbanas con menor desarrollo de su trazado ferroviario, traduciendose en una gran falta de conectividad entre zonas, mayores tiempos de desplazamiento de los ciudadanos a sus lugares de trabajo o residencia, una gran congestión de tráfico rodado y niveles insostenibles de contaminación y polución.</p>
			<p class="lorem">A día de hoy, la red de Metro de Sevilla solo cuenta con la línea 1 de Metro. A corto plazo solo hay planes de realizar el trazado norte de la Línea 3, mientras que la Línea 2 corre peligro de quedar congelada otros 20 años. Este mapa no solo muestra la línea completa de Metro, sino que recoge la propuesta de SevillaQuiereMetro de conectar las líneas 1 y 2 en Nervión y Santa Justa para aumentar así la interconectividad entre zonas. El mapa también recoge la línea completa de Metrocentro, que se extendería de Santa Justa a la Encarnación para volver a Plaza Nueva y convertirla en una línea circular que puede favorecer la movilidad turística. </p>
			<p class="lorem">Además, el mapa incorpora las propuestas de Tranvías de Dos Hermanas y Alcalá, corrobora la importancia de la creación de la estación de Cercanías de Casilla de los Pinos, y elabora una simplificación de la Línea de Tranvía del Aljarafe, teniendo en cuenta la propuesta de expansión de la Línea 2 de Metro a Ginés, y la elaboración de dos ramales de la Línea 2 de Cercanías que conducirían a Bormujos y La Puebla del Río. De este modo, se busca no solo favorecer la movilidad entre los pueblos del Aljarafe y Sevilla, sino también entre ellos mismos. Además, se propone una cuarta línea de tranvía que conecte el Hospital San Lázaro con la estación de Cercanías de San Jerónimo y llegue hasta la Rinconada, conectando la Algaba.</p>
			<p class="lorem">Por último, se propone una mejora de la red de Cercanías basada en la propuesta de de la Asociación para la Igualdad y la Mejora del Transporte (Apimt), pero unificando líneas para aumentar la competitividad y el flujo de viajeros. De este modo, además de la expansión de la Línea 2 y su ramal al Aljarafe, se propone la conexión directa entre el centro de Sevilla y el Aeropuerto (el cual no cuenta actualmente con ninguna conexión ferroviaria con la ciudad), la creación de una línea que lleve a Alcalá de Guadaira y Carmona, y la transformación de la línea de Media Distancia Utrera-Marchena-Osuna a una línea de Cercanías. Finalmente, se propone que la línea a Alcalá de Guadaira sea una línea semicircular que la conecte tanto con Sevilla como Dos Hermanas, siendo clave para ello la estación existente de Pio Palmete.</p>
		</div>
		<div class="sidebar-pane" id="planos">
			<h1 class="sidebar-header">Planos actuales<span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
			<p><a href="images/plano_metro.jpg"><img src="images/plano_metro.jpg" alt="Plano del Metro de Sevilla.jpg"width="400" height="300"></a>
			<p><a href="images/plano_cercanias.png"><img src="images/plano_cercanias.png" alt="Plano del Cercanías de Sevilla.png"width="400" height="500"></a>
		</div>
		<div class="sidebar-pane" id="poblacion">
		<h1 class="sidebar-header">Población<span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
		<h4>El Área Metropolitana de Sevilla cuenta con una población de aproximadamente 1.548.741 habitantes según datos del INE de 2021.</h4>
		<br>
		<h5>Sevilla (total: 756.026 habitantes)</h5>
		<ul><li>Distrito Este-Alcosa-Torreblanca: 153.678 habitantes</li>
			<li>Distrito Cerro Amate: 90.433 habitantes</li>
			<li>Distrito Sur: 75.620 habitantes</li>
			<li>Distrito Macarena: 74.576 habitantes</li>
			<li>Distrito Norte: 71.963 habitantes</li>
			<li>Distrito San Pablo-Santa Justa: 66.600 habitantes</li>
			<li>Distrito Casco Histórico: 60.437 habitantes habitantes</li>
			<li>Distrito Nervión: 51.578 habitantes</li>
			<li>Distrito Triana: 48.948 habitantes</li>
			<li>Distrito Bellavista-La Palmera: 35.785 habitantes</li>
			<li>Distrito Los Remedios: 27.009 habitantes</li>
		</ul>
		<br>
		<h5>Dos Hermanas (total: 133.964 habitantes)</h5>
			<ul><li>Dos Hermanas centro: 96.931 habitantes</li>
			<li>Montequinto: 35.698 habitantes</li>
			<li>Fuente del Rey: 1.285 habitantes</li>
			<li>Marismas y Puntales-Adriano: 50 habitantes</li>
			<li>Entrenúcleos: en construcción</li>
		</ul>
		<br>
		<h5>Alcalá de Guadaira: 75.546 habitantes</h5>
		<br>
		<h5>Conurbación del Aljarafe: (total: 249.113 habitantes)</h5>
			<ul><li>Mairena del Aljarafe: 46.555 habitantes</li>
			<li>Coria del Río: 30.908 habitantes</li>
			<li>Camas: 27.560 habitantes</li>
			<li>Tomares: 25.455 habitantes</li>
			<li>Bormujos: 22.180 habitantes</li>
			<li>San Juan de Aznalfarache: 21.774 habitantes</li>
			<li>Castilleja de la Cuesta: 17.516 habitantes</li>
			<li>Gines: 13.428 habitantes</li>
			<li>Gelves: 10.183 habitantes</li>
			<li>Palomares del Río: 8.843 habitantes</li>
			<li>Santiponce: 8.538 habitantes</li>
			<li>Valencina de la Concepción: 7.776 habitantes</li>
			<li>Salteras: 5.564 habitantes</li>
			<li>Castilleja de Guzmán: 2.833 habitantes</li>
			</ul>
		<br>
		<h5>La Rinconada: 39.204 habitantes</h5>
		<h5>La Algaba: 16.503 habitantes</h5>
		</div>
		
		<div class="sidebar-pane" id="puntos">
			<h1 class="sidebar-header">Añadir estaciones<span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
			<h5>Haz click en el mapa para añadir una nueva estación, e introduce aquí los datos del nuevo punto:</h5>
				<form name="form">
					<div class="form-group">
						<label for="nombre">Nombre:</label>
						<input type="text" class="form-control" name="nombre" id="nombre">
					</div>
					<div class="form-group">
						<label for="linea">Linea:</label>
						<input type="text" class="form-control" name="linea" value="" id="linea">
					</div>
					<div class="form-group">
						<label for="lugar">Zona:</label>
						<input type="text" class="form-control" name="lugar" value="" id="lugar">
					</div>
					<div class="form-group">
						<label for="lat">Latitud:</label>
						<input type="text" class="form-control" name="lat" value="" id="lat">
					</div>
					<div class="form-group">
						<label for="lon">Longitud:</label>
						<input type="text" class="form-control" name="lon" value="" id="lon">
					</div>
					<input onclick="validacion()" type="button" value="Submit">
				</form>
		</div>
		
		<div class="sidebar-pane" id="buffer">
			<h1 class="sidebar-header">Radio de buffer<span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
			<h5>Selecciona el radio del buffer:</h5>
			<input id="slide" type="range" min="0" max="1000" step="10" value="500" onchange="updateDiametro(this.value)">
		</div>
		
		<div class="sidebar-pane" id="fuentes">
			<h1 class="sidebar-header">Fuentes<span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
			<p><a href="https://sevillaquieremetro.org/">Sevilla Quiere Metro</a>
			<p><a href="http://www.sevilla21.es/">Sevilla21</a>
			<p><a href="https://sevillasemueve.org/">Sevilla se Mueve</a>
			<p><a href="https://apimt.wordpress.com/">Asociación para la Igualdad y la Mejora del Transporte</a>
		</div>
	</div>
	</div>
	
	<div id="map" class="sidebar-map"></div>
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
		
	var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: 'Map data &copy; OpenStreetMap contributors'
	});
	var maptile = L.mapboxGL({
        attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
        style: 'https://api.maptiler.com/maps/d7ae625d-6061-4ee2-803c-1b07fbe1b864/style.json?key=Y9KJbkXF4ObUWmvEpf6s'
      });	
	var carto = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
		subdomains: 'abcd',
		maxZoom: 20
	}).addTo(map);	

	var sidebar = L.control.sidebar('sidebar').addTo(map);

	var celdas = L.tileLayer.wms("http://localhost:8080/geoserver/wms", {
		layers: 'metrosevilla:celdas_movilidad',
		format: 'image/png',
		transparent: true,
		tiled: true,
		attribution: "Natural Earth"
	}).addTo(map);
	
	function popup_lineas (feature, layer) {
		layer.bindPopup("<div style=textalign: center><h6>"+feature.properties.linea+ "<h6></div>",
		{minWidth: 150, maxWidth: 200});
	};
	
	var metro1 = new L.GeoJSON(lineas, {
		filter: metro1filter,
		weight: 6,
		color: "#008000",
		onEachFeature: popup_lineas,
	});
	function metro1filter(feature) {
		if (feature.properties.linea === "Linea 1 de Metro") return true
	}
	
	var metro2 = new L.GeoJSON(lineas, {
		filter: metro2filter,
		weight: 6,
		color: "#0000FF",
		onEachFeature: popup_lineas,
	});
	function metro2filter(feature) {
		if (feature.properties.linea === "Linea 2 de Metro") return true
	}
	
	var metro3 = new L.GeoJSON(lineas, {
		filter: metro3filter,
		weight: 6,
		color: "#FF0000",
		onEachFeature: popup_lineas,
	});
	function metro3filter(feature) {
		if (feature.properties.linea === "Linea 3 de Metro") return true
	}
	
	var metro4 = new L.GeoJSON(lineas, {
		filter: metro4filter,
		weight: 6,
		color: "#FFFF00",
		onEachFeature: popup_lineas,
	});
	function metro4filter(feature) {
		if (feature.properties.linea === "Linea 4 de Metro") return true
	}
	
	var metro = L.layerGroup([metro1, metro2, metro3, metro4]).addTo(map);

	var metrocentro = new L.GeoJSON(lineas, {
		filter: metrocentrofilter,
		weight: 4,
		color: "#40E0D0",
		onEachFeature: popup_lineas
	}).addTo(map);
	function metrocentrofilter(feature) {
		if (feature.properties.servicio === "metrocentro") return true
	}
	
	var tranvia = new L.GeoJSON(lineas, {
		filter: tranviafilter,
		weight: 4,
		color: "#A0522D",
		onEachFeature: popup_lineas
	}).addTo(map);
	function tranviafilter(feature) {
		if (feature.properties.servicio === "tranvia") return true
	}
	
	var cercanias = new L.GeoJSON(lineas, {
		filter: cercaniasfilter,
		weight: 4,
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
		//http_request.open('POST', 'editar.php'),//
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
			layer.bindPopup("<div style=textalign: center><h3>"+feature.properties.nombre+ "<h3></div><hr><table><tr><td>Línea: "+feature.properties.linea+ "</td></tr><tr><td>Zona: "+feature.properties.lugar+ "</td></tr><tr><td>Da potencial servicio a "+feature.properties.poblacion+" habitantes</td></tr></table><div class='container'><form action='insertar.php' method='post' name='form'><br><label for='nombre'>Nombre:</label><input type='text' name='nombre' value="+feature.properties.nombre+"><br><label for='linea'>Linea:</label><input type='text' name='linea' value="+feature.properties.linea+"><br><label for='lugar'>Zona:</label><input type='text' name='lugar' value="+feature.properties.lugar+"><br/><input type='hidden' name='gid' value="+feature.properties.gid+"> <br/><input type='submit' value='Editar datos'></form><form action='borrar.php'method='post' name='form'> <input type='text' style='display:none'name='nombre' value= "+feature.properties.nombre+" id='nombre'><br/><input type='submit' class='button' value='Borrar punto'onclick='return alerta()'></form>",
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
	coords = [];
	function updateDiametro(value) {
		puntos.clearLayers();
		for (var i = 0; i < coords.length; i++) {
			var pt =turf.point(coords[i]);
			var buffer = turf.buffer(pt, value, { units: 'meters' });   
			var dibujaBuffer= L.geoJson(buffer, {
				style: myStyle
			});
			puntos.addLayer(dibujaBuffer);
		}
	}
	
	window.onload = makeRequest("Todos");
	
	var baseLayers = {
		"CARTO": carto,
		"OpenStreetsMap": osm,
		"Maptile": maptile,
	};
	
	var overlays = {
		"Líneas de Metro": metro,
		"Metrocentro": metrocentro,
		"Líneas de Tranvía metropolitano": tranvia,
		"Líneas de Cercanías": cercanias,
		"Celdas de población": celdas
	};
	
	var control = new L.control.layers(baseLayers, overlays,{collapsed:false});
	control.addTo(map);
	
	var legend = L.control({ position: "bottomright" });
	legend.onAdd = function(map) {
		var div = L.DomUtil.create("div", "legend");
		div.innerHTML += "<h4>Líneas ferroviarias</h4>";
		div.innerHTML += '<i style="background: #008000"></i><span>Línea 1 Metro</span><br>';
		div.innerHTML += '<i style="background: #0000FF"></i><span>Línea 2 Metro</span><br>';
		div.innerHTML += '<i style="background: #FF0000"></i><span>Línea 3 Metro</span><br>';
		div.innerHTML += '<i style="background: #FFFF00"></i><span>Línea 4 Metro</span><br>';
		div.innerHTML += '<i style="background: #40E0D0"></i><span>Metrocentro</span><br>';
		div.innerHTML += '<i style="background: #A0522D"></i><span>Línea Tranvía</span><br>';
		div.innerHTML += '<i style="background: #8B008B"></i><span>Línea Cercanías</span><br>';
		return div;
	};
	legend.addTo(map);
	
	L.control.scale({
		position: 'bottomleft',
		maxWidth: 200,
		imperial: false
	}).addTo(map);	
	
	</script>
	<div style=text-align:right>
		<p style=color:white><strong>Autor: Joaquín Osorio Arjona (Doctor en Geografía, Investigador en la Universidad de Sevilla. <a href=”url”>www.joaquinosorioarjona.com</a></strong></p>	
	</div>
</body>
</html>