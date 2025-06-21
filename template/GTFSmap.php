<?php
$start_time = 0;
$end_time = 0;
$start_time = hrtime(true);
?>
<div id="map" style="width: 100%; aspect-ratio: 1 / 1;"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script type="text/javascript">
    // Fonction couleur aléatoire
    function getRandomColor() {
        var letters = '23456789ABC';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 11)];
        }
        return color;
    }

    console.log("Info : Script de carte chargé");
    var Px = <?= json_encode($baricentre[0]); ?>;
    var Py = <?= json_encode($baricentre[1]); ?>;
    var latlng = [Px, Py];

    // Créer la carte
    const map = L.map('map', {
        center: [Px, Py],
        zoom: 13,
    });

    //var map = L.map("map").setView([Px, Py], 13);
    // const overlays = {
    //     'Stops': markers
    // };

    //const layerControl = L.control.layers(baseLayers, overlays).addTo(map);

    document.addEventListener('DOMContentLoaded', function () {
        // // Initialiser la carte
        //const map = L.map('map').setView([Px, Py], 13); // Coordonnées de Paris

        // Ajouter la couche OpenStreetMap par défaut
        let osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Autres couches
        let otpLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
        });

        let satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

        let pageBlanche = L.tileLayer('', {
            maxZoom: 19,
        });

        // Écouter les changements dans le menu déroulant
        const backgroundSelect = document.getElementById('background-select');
        backgroundSelect.addEventListener('change', function () {
            const selectedValue = backgroundSelect.value;

            // Supprimer toutes les couches
            map.eachLayer(function (layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });

            // Ajouter la couche sélectionnée
            switch (selectedValue) {
                case 'OSM':
                    osmLayer.addTo(map);
                    break;
                case 'OTP':
                    otpLayer.addTo(map);
                    break;
                case 'satellite':
                    satelliteLayer.addTo(map);
                    break;
                case 'other':
                    // Ajouter une autre couche si nécessaire
                    break;
                case 'NA':
                    // Ne pas ajouter de couche
                    break;
                default:
                    console.log('Valeur non reconnue');
            }
        });
    });
    const markers = L.markerClusterGroup();
    document.addEventListener('DOMContentLoaded', function () {
        map.addLayer(markers);
        // Écouter les changements dans le menu déroulant
        const stopsSelect = document.getElementById('stops-select');
        stopsSelect.addEventListener('change', function () {
            const selectedValue = stopsSelect.value;

            // Ajouter la couche sélectionnée
            switch (selectedValue) {
                case 'stops-all':
                    map.addLayer(markers);
                    break;
                case 'stops-NA':
                    map.removeLayer(markers);
                    break;
                case 'stops-0':
                    console.log('Info');
                    break;
                case 'stops-1':
                    console.log('Info');

                    break;
                case 'stops-2':
                    break;
                case 'stops-3':
                    break;
                case 'stops-4':
                    break;
                default:
                    console.log('Valeur non reconnue');
            }
        });
    });

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
    // createshape
    var temoin = 0;
    var arrayPolyline = [];
    var shapesGroup = L.layerGroup();
    var shapesPresent = true; // Variable pour vérifier si des shapes sont présentes

    document.addEventListener('DOMContentLoaded', function () {
        map.addLayer(shapesGroup);
        // Écouter les changements dans le menu déroulant
        const shapesSelect = document.getElementById('shapes-select');
        shapesSelect.addEventListener('change', function () {
            const selectedValue = shapesSelect.value;

            // Ajouter la couche sélectionnée
            switch (selectedValue) {
                case 'shapes-all':
                    map.addLayer(shapesGroup);
                    shapesPresent = true; // Indiquer que des shapes sont présentes
                    // Mettre tous les boutons en mode "open"
                    document.querySelectorAll('.toggle-shape-btn').forEach(function (btn) {
                        btn.innerHTML = '<img src="icones/svg/bouton_eyes_open.svg" alt="affiché" style="width: 20px; height: 20px; align-item: center;">';
                    });
                    break;
                case 'shapes-NA':
                    map.removeLayer(shapesGroup);
                    shapesPresent = false; // Indiquer qu'aucune shape n'est présente 
                    document.querySelectorAll('.toggle-shape-btn').forEach(function (btn) {
                        btn.innerHTML = '<img src="icones/svg/bouton_eyes_close.svg" alt="masqué" style="width: 20px; height: 20px; align-item: center;">';
                    });
                    break;
                default:
                    console.log('Valeur non reconnue');
            }
        });
    });

    <?php
    if (isset($dico_shapes_id['Nb_shape_id']) && is_int($dico_shapes_id['Nb_shape_id']) && $dico_shapes_id['Nb_shape_id'] > 0) {
        $filePath = 'upload/extract' . $fichier . '/shapes.txt';
        $handle = new SplFileObject($filePath, 'r');
        $handle->setFlags(SplFileObject::READ_CSV);
        $data = $handle->fgetcsv();
        $Xkey = array_search('shape_pt_lat', $data) ?? null;
        $Ykey = array_search('shape_pt_lon', $data) ?? null;
        $Shapes_name = array_search('shape_id', $data) ?? null;
        $data = $handle->fgetcsv();

        for ($index = 0; $index < $dico_shapes_id['Nb_shape_id']; $index++) {
            $routeColor = $CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['route_color'] ?? null;
            $routeTexteColor = $CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['route_text_color'] ?? null
                ?>
            var shape_id = <?= json_encode($dico_shapes_id['shape_names'][$index]['name']) ?? null; ?>;
            var route_id = <?= json_encode($CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['route_id']) ?? null; ?>;
            var days_of_service = <?= json_encode($CorrespondanceShapeRoute[$dico_shapes_id['shape_names'][$index]['name']]['calendar']); ?>;
            var shape_color = <?= json_encode('#' . $routeColor) ?>;
            var shape_text_color = <?= json_encode('#' . $routeTexteColor); ?>;
            if (shape_color == '#') {
                shape_color = getRandomColor();
                console.log("Info : Couleur non trouvée pour la shape " + shape_id);
            }
            <?php
            echo 'var latlngs = [';
            if ($handle) {
                while (($data[$Shapes_name] ?? null) == $dico_shapes_id['shape_names'][$index]['name']) {
                    if (memory_get_usage() >= $memoryLimit) {
                        $handle->fseek(0, SEEK_SET); // Rewind the file pointer to the beginning
                        $handle->fgetcsv(); // Skip the header line
                        break; // Exit the loop if memory limit is reached
                    }
                    if (isset($data[$Xkey]) && isset($data[$Ykey])) {
                        $firstdot = [0, 0];
                        $first = true;
                        if ($first) {
                            $firstdot = [$data[$Xkey], $data[$Ykey]];
                        }
                        $first = false;
                        echo '[' . json_encode(floatval($data[$Xkey])) . ', ' . json_encode(floatval($data[$Ykey])) . ']';
                        $data = $handle->fgetcsv();
                        if (($data[$Shapes_name] ?? null) !== $dico_shapes_id['shape_names'][$index]['name']) {
                            echo '];';
                        } else {
                            echo ',';
                        }
                    }
                }
            }

            ?>
            var popupContent = `
            <div class="popup-content">
            <p><strong>Shape Id :</strong> ${shape_id}</p>
            <p><strong>Route Id :</strong> ${route_id}</p>
            <p><strong>Jours de Service :</strong> ${days_of_service}</p>
            <p><strong>Nombre de points :</strong> ${latlngs.length}</p>
            <p><strong>Couleur :</strong> <span class="color-box" style="background-color: ${shape_color}; color: ${shape_text_color}"></span>${shape_color}</p>
            </div>`;

            var polyline = L.polyline(latlngs, {
                color: shape_color
            }).addTo(map).bindPopup(popupContent);
            polyline.on('mouseover', function () {
                this.setStyle({
                    weight: 14
                });
            });
            polyline.on('mouseout', function () {
                this.setStyle({
                    weight: 5 // Remettez ici la valeur d'origine du weight
                });
            });


            //shapes.addLayer(polyline);
            arrayPolyline.push([polyline, shape_id, route_id, shape_color, shape_text_color]);
            temoin++;
        <?php }
    }
    ?> console.log("Info : " + temoin + " Shapes ajoutées à la carte");
    //layerControl.addOverlay(shapes, 'Shapes');

    // Votre code existant pour ajouter les polylines
    document.addEventListener('DOMContentLoaded', function () {
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
            zoomButton.addEventListener('click', (function (polyline) {
                return function () {
                    map.fitBounds(polyline.getBounds());
                    window.location.href = '#carte'; // Redirige vers la section "Carte"

                };
            })(polyline));

            var toggleButton = document.createElement('button');
            toggleButton.classList.add('toggle-shape-btn');
            toggleButton.innerHTML = map.hasLayer(polyline) ?
                '<img src="icones/svg/bouton_eyes_open.svg" alt="affiché" style="width: 20px; height: 20px; align-item: center;" >' :
                '<img src="icones/svg/bouton_eyes_close.svg" alt="masqué" style="width: 20px; height: 20px; align-item: center;">';
            toggleButton.addEventListener('click', (function (polyline, toggleButton) {
                return function () {
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
    });

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
