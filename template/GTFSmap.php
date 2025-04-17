<?php
/*Débug
/require('outils/GTFScsvTOmap.php');
echo '<pre>';
$arraystring = print_r($stops);
$arraystring = print_r($dico_shapes_id);
fclose($LOG);
//print_r($MessageErreur ?? '');
//print_r($stops);
//print_r($dico_shapes_id);
//print_r($ShapesPositionXY);
//echo $ShapesPresent;
echo $dico_shapes_id['Nb_shape_id'] . '<br>';
echo $NbligneParShape . 'nbligne<br>';
echo $Nbshapes . ' shapes<br>';
//echo array_sum(array_column($dico_shapes_id['shape_names'], 'Nb_ligne'));
echo '</pre>';*/
//initialisation de différentes variables
//$NbshapesPourJS = $Nbshapes ?? 0;
//echo $NbshapesPourJS;
$start_time = 0;
$end_time = 0;
$start_time = hrtime(true);
?>
<div id="map" style="width: 100%; aspect-ratio: 1 / 1;"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script type="text/javascript">
    console.log("Info : Script de carte chargé");
    var Px = <?= json_encode($baricentre[0]); ?>;
    var Py = <?= json_encode($baricentre[1]); ?>;
    //var map = L.map("map").setView([Px, Py], 13);
    const markers = L.markerClusterGroup();
    const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    const pageBlanche = L.tileLayer('', {
        maxZoom: 19,
    });

    const map = L.map('map', {
        center: [Px, Py],
        zoom: 10,
        layers: [osm, markers]
    });

    const baseLayers = {
        'OpenStreetMap': osm,
        'Sans fond de carte': pageBlanche
    };

    const overlays = {
        'Stops': markers
    };

    const layerControl = L.control.layers(baseLayers, overlays).addTo(map);

    const openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
    });
    layerControl.addBaseLayer(openTopoMap, 'OpenTopoMap');
    //tuto
    var latlng = [Px, Py];
    //var tooltip = L.tooltip().setLatLng(latlng).setContent('cliquez sur les lignes et les arrêts pour plus d\'informations <br/> Modifier la visibilité des couches ainsi que le type d\'arrière plan en cliquant sur le bouton en haut à droite.').addTo(map);
    // Fonction pour générer une couleur aléatoire
    function getRandomColor() {
        var letters = '23456789ABC';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 11)];
        }
        return color;
    }
    // Initialiser le groupe de clusters
    // create a start
    // create a stop
    <?php
    if (isset($StopsPositionXY) && isset($Nbpoints) && is_array($StopsPositionXY) && is_int($Nbpoints)) {
        for ($i = 1; $i < $Nbpoints; $i++) {
            if (isset($StopsPositionXY[$i]) && is_array($StopsPositionXY[$i]) && count($StopsPositionXY[$i]) == 2) {
                echo 'var stop_id = ' . json_encode($stopsInfo[$i]['stop_id'] ?? null) . ';';
                echo 'var stop_name = ' . json_encode($stopsInfo[$i]['stop_name'] ?? null) . ';';
                echo 'var stop_lat = ' . json_encode($StopsPositionXY[$i][0] ?? null) . ';';
                echo 'var stop_long = ' . json_encode($StopsPositionXY[$i][1] ?? null) . ';';
                echo 'var zone_id = ' . json_encode($stopsInfo[$i]['zone_id'] ?? null) . ';';
                echo 'var parent_station = ' . json_encode($stopsInfo[$i]['parent_station'] ?? null) . ';';
                echo 'var wheelchair_boarding = ' . json_encode($stopsInfo[$i]['wheelchair_boarding'] ?? null) . ';';
                echo 'var platform_code = ' . json_encode($stopsInfo[$i]['platform_code'] ?? null) . ';';
                echo 'var popupContent = `
                            <div class="popup-content">
                                <p><strong>stop Id :</strong> ${stop_id}</p>
                                <p><strong>Name :</strong> ${stop_name}</p>
                                <p><strong>Coordonées :</strong> ${stop_lat},${stop_long}</p>
                                <p><strong>Zone Id :</strong> ${zone_id}</p>
                                <p><strong>Parent Station :</strong> ${parent_station}</p>
                                <p><strong>Wheelchair Boarding :</strong> ${wheelchair_boarding}</p>
                                <p><strong>Platform Code :</strong> ${platform_code}</p>
                            </div>
                        `;';
                echo 'var marker = L.marker([' . json_encode($StopsPositionXY[$i][0]) . ', ' . json_encode($StopsPositionXY[$i][1]) . ']).bindPopup(popupContent).addTo(markers);';
            } else {
                $MessageErreur[] = 'Erreur : Coordonnées manquantes ou invalides pour l\'index ' . $i;
            }
        }
    } else {
        $MessageErreur[] = 'Erreur : $StopsPositionXY ou $Nbpoints non définis ou invalides';
    }

    ?>
    map.addLayer(markers);
    // createshape
    var temoin = 0;
    var arrayPolyline = [];
    var shapes = L.layerGroup().addTo(map);
    <?php
    if (isset($dico_shapes_id['Nb_shape_id']) && is_int($dico_shapes_id['Nb_shape_id']) && $dico_shapes_id['Nb_shape_id'] > 0) {
        $debug = [];
        $y = 1;
        for ($index = 0; $index < $dico_shapes_id['Nb_shape_id']; $index++) {
            $routeColor = $CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['route_color'] ?? null;
            $routeTexteColor = $CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['route_text_color'] ?? null
    ?>
            var shape_id = <?= json_encode($dico_shapes_id['shape_names'][$index]['name']) ?? null; ?>;
            var route_id = <?= json_encode($CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['route_id']) ?? null; ?>;
            var shape_color = <?= json_encode('#' . $routeColor) ?>;
            var shape_text_color = <?= json_encode('#' . $routeTexteColor); ?>;
            if (shape_color == '#') {
                shape_color = getRandomColor();
                console.log("Info : Couleur non trouvée pour la shape " + shape_id);
            }
            <?php
            echo 'var latlngs = [';
            while (($ShapesPositionXY[$y][0] ?? null) == $dico_shapes_id['shape_names'][$index]['name']) {
                if (isset($ShapesPositionXY) && is_array($ShapesPositionXY)) {
                    $firstdot = [0, 0];
                    $first = true;

                    if (isset($ShapesPositionXY[$y][1]) && isset($ShapesPositionXY[$y][2]) && is_array($ShapesPositionXY[$y])) {
                        if ($first) {
                            $firstdot = [$ShapesPositionXY[$y][1], $ShapesPositionXY[$y][2]];
                        }

                        $first = false;
                        echo '[' . json_encode(floatval($ShapesPositionXY[$y][1])) . ', ' . json_encode(floatval($ShapesPositionXY[$y][2])) . ']';
                        $y++;
                        if (($ShapesPositionXY[$y][0] ?? null) !== $dico_shapes_id['shape_names'][$index]['name']) {
                            echo '];';
                        } else {
                            echo ',';
                        }
                        $debug[$index][] = $i;
                    }
                } else {
                    echo 'console.log("Erreur : $ShapesPositionXY non défini ou invalide");';
                }
            } ?>
            var popupContent = `
            <div class="popup-content">
            <p><strong>Shape Id :</strong> ${shape_id}</p>
            <p><strong>Route Id :</strong> ${route_id}</p>
            <p><strong>Nombre de points :</strong> ${latlngs.length}</p>
            <p><strong>Couleur :</strong> <span class="color-box" style="background-color: ${shape_color}; color: ${shape_text_color}"></span>${shape_color}</p>
            </div>`;

            var polyline = L.polyline(latlngs, {
                color: shape_color
            }).addTo(map).bindPopup(popupContent);


            //shapes.addLayer(polyline);
            arrayPolyline.push([polyline, shape_id, route_id, shape_color, shape_text_color]);
            temoin++;

            /*
                        var control = document.createElement('div');
                        control.className = 'layer-control';
                        control.innerText = `Afficher/Masquer ${data.name}`;
                        control.addEventListener('click', function() {
                            if (map.hasLayer(polyline)) {
                                map.removeLayer(polyline);
                            } else {
                                map.addLayer(polyline);
                            }
                        });
                        document.getElementById('layer-controls').appendChild(control);
                        // Ajouter le groupe de couches au contrôle de couches*/
    <?php }
    } ?>
    console.log("Info : " + temoin + " Shapes ajoutées à la carte");
    //layerControl.addOverlay(shapes, 'Shapes');
    var shapesGroup = L.layerGroup();
    // Votre code existant pour ajouter les polylines
    for (var i = 0; i < arrayPolyline.length; i++) {
        var polyline = arrayPolyline[i][0];
        shapesGroup.addLayer(polyline);

        var colorBox = '<span class="color-box" style="background-color:' + arrayPolyline[i][3] + ';"></span>';
        var shapeText = 'Shape ' + arrayPolyline[i][1];
        var routeText = 'Route ' + arrayPolyline[i][2];

        // Créer une ligne de tableau
        var row = document.createElement('tr');

        // Créer les cellules de tableau
        var colorCell = document.createElement('td');
        colorCell.innerHTML = colorBox;

        var shapeCell = document.createElement('td');
        shapeCell.textContent = shapeText;

        var routeCell = document.createElement('td');
        routeCell.textContent = routeText;
        // Créer les boutons
        var zoomButton = document.createElement('button');
        zoomButton.innerHTML = '<img src="icones/svg/zoom.svg" alt="Zoom" style="width: 20px; height: 20px; align-item: center;">';
        zoomButton.addEventListener('click', (function(polyline) {
            return function() {
                map.fitBounds(polyline.getBounds());
                window.location.href = '#carte'; // Redirige vers la section "Carte"

            };
        })(polyline));

        var toggleButton = document.createElement('button');
        toggleButton.innerHTML = map.hasLayer(polyline) ?
            '<img src="icones/svg/bouton_eyes_open.svg" alt="affiché" style="width: 20px; height: 20px; align-item: center;" >' :
            '<img src="icones/svg/bouton_eyes_close.svg" alt="masqué" style="width: 20px; height: 20px; align-item: center;">';
        toggleButton.addEventListener('click', (function(polyline, toggleButton) {
            return function() {
                if (map.hasLayer(polyline)) {
                    map.removeLayer(polyline);
                    toggleButton.innerHTML = '<img src="icones/svg/bouton_eyes_close.svg" alt="masqué" style="width: 20px; height: 20px; align-item: center;">';
                } else {
                    map.addLayer(polyline);
                    toggleButton.innerHTML = '<img src="icones/svg/bouton_eyes_open.svg" alt="affiché" style="width: 20px; height: 20px; align-item: center;">';
                }
            };
        })(polyline, toggleButton));
        // Créer une cellule pour les boutons
        var zoomCell = document.createElement('td');
        zoomCell.appendChild(zoomButton);
        var toggleCell = document.createElement('td');
        toggleCell.appendChild(toggleButton);

        // Ajouter les cellules à la ligne
        row.appendChild(colorCell);
        row.appendChild(shapeCell);
        row.appendChild(routeCell);
        row.appendChild(zoomCell);
        row.appendChild(toggleCell);

        // Ajouter la ligne au corps du tableau
        document.getElementById('legend-body').appendChild(row);
    }

    // Ajouter le groupe de couches au contrôle de couches
    layerControl.addOverlay(shapesGroup, "Shapes");

    /*for (var i = 0; i < arrayPolyline.length; i++) {
        layerControl.addOverlay(arrayPolyline[i][0], 'Shape ' + arrayPolyline[i][1] + ' Route ' + arrayPolyline[i][2]);
    }*/
    // zoom the map to the polyline 
    map.fitBounds(polyline.getBounds());
</script>
<?php
$end_time = hrtime(true);
$execution_time_GTFSmap = $end_time - $start_time;
