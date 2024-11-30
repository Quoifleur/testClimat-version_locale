<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include('src/function_drawing.php');
include('src/function_super.php');
include('src/function_geojson.php');
include('src/function_other.php');
if (isset($_FILES['file'])) {
    require('outils/ZIPtoTXT.php');
} else {
    $fichierChargé = false;
    $erreur = false;
}
include('outils/cartoGTFS.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <?php include('navigation/head.php'); ?>
    <title>Visonneuse GTFS</title>
</head>

<body>
    <?php include('navigation/header.php'); ?>
    <?php include('navigation/nav.php'); ?>

    <main>
        <section class="section_intro">
            <h1>Visonneuse GTFS</h1>
            <h2>GTFS</h2>
            <p>Le General Transit Feed Specification (GTFS) est un format de fichier qui contient les horaires des transports en commun. Il est utilisé par de nombreuses applications de transport en commun, telles que Google Maps, pour afficher les horaires des bus, des trains et des métros. Le GTFS est un format de fichier simple et facile à utiliser qui permet aux développeurs de créer des applications de transport en commun.</p>
            <h3>Documentation</h3>
            <ul>
                <li>Site internet de <a href="https://gtfs.org/fr/">gtfs.org</a></li>
                <li>repository de google relatif au GTFS et GTFS Realtime<a href="https://github.com/google/transit">github.com/google/transit</a></li>
            </ul>
            <h2>Fichier à visualiser</h2>
            <?php require('template/chargementFichierGTFS.php');
            ?>
        </section>
        <section class="section_milieu">
            <h2><?= $Nomfichier[0] ?? 'Bienvenue dans la liseuse de fichier GTFS'; ?></h2>
            <?php if ($fichierChargé) {
                echo '<div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                <p>Seul les dix premières lignes de chaque fichiers sont affichées ici. Pour retrouver les données au complets merci d\'aller
                <form id="voir" method="get" action="horsThemeGTFScomplet.php">
                    <input type="submit" name="voir" value="' . $fichier . '">
                </form>
                </p>
            </div>';
            }
            ?>
            <h3 id="sommaire">Sommaire</h3>
            <?php require('template/GTFSsommaire.php'); ?>
            <h3>Informations</h3>
            <table>
                <caption>Informations sur le fichier chargé</caption>
                <tr>
                    <th>Fichier</th>
                    <th>Présence</th>
                    <th>Présence</th>
                </tr>
                <?php require('template/table_presence_fichierGTFS.php'); ?>
            </table>
            <?php
            if ($fichierChargé) {
                require('template/GTFSfichierExplicite.php');
            }
            ?>
        </section>
        <section class="section_fin">
            <?php
            //include('cartodessinGTFS.php');
            ?>
            <img src="carte.png" alt="Carte">
            <!--<button id="toggleStops">Afficher/Masquer les arrêts</button>
            <div id="map" style="width: 100%; height: 600px;"></div>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    var Px = <?php echo $lat ?? 44.841; ?>;
                    var Py = <?php echo $long ?? -0.587; ?>;

                    var map = L.map("map").setView([Px, Py], 13);
                    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    }).addTo(map);

                    var stopsLayer = L.layerGroup();
                    <?php
                    for ($i = 1; $i < $NbStops ?? 2; $i++) {
                        echo 'L.marker([' . json_encode($stop[$i][1]) . ', ' . json_encode($stop[$i][2]) . ']).addTo(stopsLayer).bindPopup(' . json_encode($stop[$i][0]) . ');';
                    }
                    ?>
                    stopsLayer.addTo(map);

                    var geoJsonLayer = L.geoJSON(<?php echo json_encode($lienFichier); ?>).addTo(map);

                    document.getElementById('toggleStops').addEventListener('click', function() {
                        if (map.hasLayer(stopsLayer)) {
                            map.removeLayer(stopsLayer);
                        } else {
                            map.addLayer(stopsLayer);
                        }
                    });
                });
            </script>-->
        </section>
    </main>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>