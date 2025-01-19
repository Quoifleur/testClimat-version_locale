<?php require('outils/GTFScsvTOmap.php');
echo '<pre>';
print_r($MessageErreur ?? '');
print_r($stops);
print_r($dico_shapes_id);
//print_r($ShapesPositionXY);
echo $ShapesPositionXY[1][1] . ' ' . $ShapesPositionXY[1][2] . '<br>';
echo $ShapesPositionXY[3][1] . ' ' .  $ShapesPositionXY[3][2] . '<br>';
echo $ShapesPositionXY[0][1] . ' ' .  $ShapesPositionXY[0][2] . '<br>';
echo '</pre>';
echo $ShapesPresent;
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
    var Nbshapes = <?= json_encode($Nbshapes) ?? null; ?>;
    if (typeof Nbshapes !== 'undefined' && Number.isInteger(Nbshapes) && Nbshapes > 0) {
        var polyline = L.polyline([
            <?php
            if (isset($ShapesPositionXY) && is_array($ShapesPositionXY)) {
                $first = true;
                for ($i = 1; $i < $Nbshapes; $i++) {
                    if (isset($ShapesPositionXY[$i]) && is_array($ShapesPositionXY[$i]) && count($ShapesPositionXY[$i]) == 3) {
                        if (!$first) {
                            echo ',';
                        }
                        echo '[' . json_encode(floatval($ShapesPositionXY[$i][1])) . ', ' . json_encode(floatval($ShapesPositionXY[$i][2])) . ']';
                        $first = false;
                    } else {
                        echo 'console.log("Erreur : Coordonnées de shape manquantes ou invalides pour l\'index ' . $i . '");';
                    }
                }
            } else {
                echo 'console.log("Erreur : $ShapesPositionXY non défini ou invalide");';
            }
            ?>
        ]).addTo(map);
        // zoom the map to the polyline
        map.fitBounds(polyline.getBounds());
    } else {
        console.log("Aucune shape à afficher");
    }
</script>