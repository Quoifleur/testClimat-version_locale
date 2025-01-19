<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('src/function_other.php');
if (isset($_FILES['file'])) {
    require('outils/ZIPtoTXT.php');
} else {
    $fichierChargé = false;
    $erreur = false;
}
//include('outils/cartoGTFS.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <?php require('navigation/head.php'); ?>
    <title>Visonneuse GTFS</title>
</head>

<body>
    <?php require('navigation/header.php'); ?>
    <?php require('navigation/nav.php'); ?>

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
            <?php require('template/GTFSchargementFichier.php');
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
            if ($fichierChargé) {
                require('template/GTFSsommaire.php');
                require('template/GTFStable_presence_fichier.php');
                require('template/GTFSfichierExplicite.php');
            }
            ?>
        </section>
        <section class="section_fin">
            <div class="map-containeur">
                <h1>Carte</h1>
                <?php
                if ($fichierChargé) {
                    echo '<p> fichier chargé</p>';
                    require('template/GTFSmap.php');
                } else {
                    echo '<p>Aucun fichier n\'a pas été chargé</p>';
                }
                ?>
            </div>

        </section>
    </main>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>