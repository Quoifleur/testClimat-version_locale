<?php
/*Débug
/require('outils/GTFScsvTOmap.php');
echo '<pre>';
$fichierLOG = strval('upload/extract' . $fichier . '/log.html');
$LOG = fopen($fichierLOG, 'w');
fwrite($LOG, '<pre>');
fwrite($LOG, $MessageErreur ?? '');
$arraystring = print_r($stops);
fwrite($LOG, $arraystring);
$arraystring = print_r($dico_shapes_id);
fwrite($LOG, $arraystring);
fwrite($LOG, '</pre>');
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
                echo 'var marker = L.marker([' . json_encode($StopsPositionXY[$i][0]) . ', ' . json_encode($StopsPositionXY[$i][1]) . ']).addTo(markers);';
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
        for ($index = 0; $index < $dico_shapes_id['Nb_shape_id']; $index++) { ?>
            var shape_id = <?= json_encode($dico_shapes_id['shape_names'][$index]['name']) ?? null; ?>;
            var latlngs = [
            <?php
            while (($ShapesPositionXY[$y][0] ?? null) == $dico_shapes_id['shape_names'][$index]['name']) {
                if (isset($ShapesPositionXY) && is_array($ShapesPositionXY)) {
                    $firstdot = [0, 0];
                    $first = true;

                    if (isset($ShapesPositionXY[$y][1]) && isset($ShapesPositionXY[$y][2]) && is_array($ShapesPositionXY[$y])) {
                        if ($first) {
                            $firstdot = [$ShapesPositionXY[$y][1], $ShapesPositionXY[$y][2]];
                        }

                        $first = false;
                        echo '[' . json_encode(floatval($ShapesPositionXY[$y][1])) . ', ' . json_encode(floatval($ShapesPositionXY[$y][2])) . '],';
                        $y++;


                        $debug[$index][] = $i;
                    }
                } else {
                    echo 'console.log("Erreur : $ShapesPositionXY non défini ou invalide");';
                }
            }
        }
            ?>
            ];
            var polyline = L.polyline(latlngs, {
                color: getRandomColor(),
            }).addTo(map).bindPopup("id : " + shape_id);
            temoin++;
        <?php } ?>
        console.log("Info : Shape ajoutée");
        console.log(temoin);
        // zoom the map to the polyline
        map.fitBounds(polyline.getBounds());
</script>