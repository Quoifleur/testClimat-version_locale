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
$NbshapesPourJS = $Nbshapes ?? 0;
//echo $NbshapesPourJS;
?>
<div id="map" style="width: 100%; height: 600px;"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script type="text/javascript">
    console.log("Info : Script de carte chargé");
    var Px = <?= json_encode($baricentre[0]); ?>;
    var Py = <?= json_encode($baricentre[1]); ?>;
    var map = L.map("map").setView([Px, Py], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
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

    var markers = L.markerClusterGroup();
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
                echo 'console.log("Erreur : Coordonnées manquantes ou invalides pour l\'index ' . $i . '");';
            }
        }
    } else {
        echo 'console.log("Erreur : $StopsPositionXY ou $Nbpoints non définis ou invalides");';
    }

    ?>
    map.addLayer(markers);

    // createshape
    var temoin = 0;
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
            if (shape_color == null) {
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
                </div>
            `;
            var polyline = L.polyline(latlngs, {
                color: shape_color
            }).addTo(map).bindPopup(popupContent);
            temoin++;

    <?php }
    } ?>
    console.log("Info : Shapes ajoutées");
    console.log(temoin);
    // zoom the map to the polyline
    map.fitBounds(polyline.getBounds());
</script>