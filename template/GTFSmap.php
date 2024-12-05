<?php require('outils/GTFScsvTOmap.php');
echo '<pre>';
print_r($MessageErreur ?? '');
print_r($stops);
echo '</pre>';
echo $ShapesPresent;
?>
<div id="map" style="width: 100%; height: 600px;"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script type="text/javascript">
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
    <?php if (isset($Nbshapes) && is_int($Nbshapes) && $Nbshapes > 0): ?>
        var polyline = L.polyline([
            <?php
            if (isset($ShapesPositionXY) && is_array($ShapesPositionXY)) {
                for ($i = 1; $i < $Nbshapes; $i++) {
                    if (isset($ShapesPositionXY[$i]) && is_array($ShapesPositionXY[$i]) && count($ShapesPositionXY[$i]) == 2) {
                        echo '[' . json_encode(floatval($ShapesPositionXY[$i][0])) . ', ' . json_encode(floatval($ShapesPositionXY[$i][1])) . ']';
                        if ($i < $Nbshapes - 1) {
                            echo ',';
                        }
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
    <?php else: ?>
        console.log("Aucune shape à afficher");
    <?php endif; ?>
</script>