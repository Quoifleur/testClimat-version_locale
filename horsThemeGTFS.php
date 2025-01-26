<?php
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
            <h1>Visionneuse GTFS schedule</h1>
            <p>testClimat-visionneuse GTFS scheldule v.1 26/01/2025</p>
            <h2>GTFS</h2>
            <p>Le General Transit Feed Specification (GTFS) est un format de fichier qui contient les horaires des transports en commun. Il est utilisé par de nombreuses applications de transport en commun, telles que Google Maps, pour afficher les horaires des bus, des trains et des métros. Le GTFS est un format de fichier simple et facile à utiliser qui permet aux développeurs de créer des applications de transport en commun.</p>
            <p> Cette visionneuse GTFS utilise des icônes modifiées et originalement créées par <a href="https://www.streamlinehq.com/icons" rel="nofollow noopener noreferrer" target="_blank">Streamline</a>, sous licence Creative commons license: Attribution 4.0 International (CC BY 4.0).</p>
            <h3>Documentation</h3>
            <ul>
                <li>Site internet officiel de <a href="https://gtfs.org/fr/" target="_blank">gtfs.org</a></li>
                <li>Pour télécharger des fichiers GTFS : <a href="https://mobilitydatabase.org/"target="_blank">mobilitydatabase</a></li>
                <li>repository de google relatif au GTFS et GTFS Realtime <a href="https://github.com/google/transit"target="_blank">github.com/google/transit</a></li>
            </ul>
            <div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                <p>Aucun fichier n'est sauvegardé par TestClimat et sa visionneuse GTFS. Tous les fichiers uploadés sont immédiatement supprimés du serveur. Les données ne sont sauvegardées dans aucune base de données.
                <br /><br />En cas de fichier lourd, le temps de chargement peut être long. Si la carte ne s'affiche pas correctement, recharger la page peut résoudre le problème. Si le problème persiste, merci de me contacter.
                <br />Dans un souci d'optimisation, seuls les dix premières lignes de chaque fichier sont affichées ici (chargement complet en cours de développement).
                <br /><br />L'ensemble du code source du site est disponible sur <a href="https://github.com/Quoifleur/testClimat-version_locale">github</a></p>
            </div>
            <h2>Fichier à visualiser</h2>
            <?php require('template/GTFSchargementFichier.php');
            ?>
        </section>
        <section class="section_milieu">
            <h2><?= $Nomfichier[0] ?? 'Bienvenue dans la liseuse de fichier GTFS'; ?></h2>
            <?php 
            if ($fichierChargé) {
                require('outils/GTFScsvTOmap.php');
                //require('template/GTFSsommaire.php');
                require('template/GTFStable_presence_fichier.php');
                require('template/GTFSfichierExplicite.php');
                //require('outils/fichierGTFScompletEcriture.php');
            }
            ?>
        </section>
        <section class="section_fin">
            <div class="map-containeur">
                <h1>Carte</h1>
                <?php
                if ($fichierChargé) {
                    echo '<p>Le(s) fichier(s) stops.txt et/ou shapes.txt a(ont) été détecté(s). Si la carte ne s\'affiche pas, cela veut dire qu\'un problème et survenu. Tentez de recharger la page. Si le problème persiste merci de me contacter.</p>';
                    require('template/GTFSmap.php');
                    require('outils/GTFSnettoyage.php');
                } else {
                    echo '<p>Aucun des fichiers stops.txt ou shapes.txt ont été chargés et/ou détectés, en l\'absence de donnés cartographiables, la carte ne peut pas s\'afficher.</p>';
                    require('outils/GTFSnettoyage.php');
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