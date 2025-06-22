<?php
session_start();
require('src/function_other.php');
require('outils/ZIPtoTXT.php');
/*
if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    
    $fichierChargé = true;
    $MessageErreur[] = 'Info : fichiers chargés <br />';
} else {
    $fichierChargé = false;
    $erreur = true;
    $MessageErreur[] = 'Erreur : fichier non chargé <br />';
}
*/
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <?php require('navigation/headGTFS.php'); ?>
    <title>Visonneuse GTFS</title>
    <script>
        function loadContent() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'content.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('content').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function handleDrop(event) {
            event.preventDefault();
            event.stopPropagation();
            document.getElementById('dropZone').classList.remove('dragover');

            var files = event.dataTransfer.files;
            if (files.length > 0) {
                var file = files[0];

                // Vérifie que le fichier est au format .zip
                if (file.type === 'application/zip' || file.name.endsWith('.zip')) {
                    // Vérifie que la taille du fichier ne dépasse pas 25 Mo
                    if (file.size <= 25 * 1024 * 1024) {
                        document.getElementById('fileInput').files = files;
                        console.log('Fichier téléchargé:', file.name);
                        // Vous pouvez soumettre le formulaire ici si nécessaire
                    } else {
                        alert('Le fichier dépasse la taille maximale autorisée de 25 Mo.');
                    }
                } else {
                    alert('Veuillez télécharger un fichier au format .zip.');
                }
            }
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.stopPropagation();
            document.getElementById('dropZone').classList.add('dragover');
        }

        function handleDragLeave(event) {
            event.preventDefault();
            event.stopPropagation();
            document.getElementById('dropZone').classList.remove('dragover');
        }
    </script>
</head>

<body>
    <div class="tGTFS_header">
        <?php
        require('navigation/headerGTFS.php');
        require('navigation/navGTFS.php');
        ?>
    </div>
    <?php
    require('template/GTFSsommaire.php');
    ?>
    <main class="tGTFS_main">
        <section class="section_intro">
            <div class="texte">
                <h1 id="introduction">Visionneuse GTFS schedule</h1>
                <p>testClimat-visionneuse GTFS scheldule v1.1 26/01/2025, <a
                        href="testClimatchangelog.php">changelog</a>
                </p>
                <h2>Qu'est-ce qu'un fichier GTFS ?</h2>
                <p>
                    Le General Transit Feed Specification (GTFS) est un format de fichier qui contient les horaires
                    des transports en commun. Il est utilisé par de nombreuses applications de transport en commun,
                    telles que Google Maps, pour afficher les horaires des bus, des trains et des métros. Le GTFS
                    est un format de fichier simple et facile à utiliser qui permet aux développeurs de créer des
                    applications de transport en commun.
                </p>
            </div>
            <div class="texte">
                <h3>Documentation et crédit</h3>
                <ul>
                    <li>Site internet officiel de <a href="https://gtfs.org/fr/" target="_blank">gtfs.org</a></li>
                    <li>Pour télécharger des fichiers GTFS : <a href="https://mobilitydatabase.org/"
                            target="_blank">mobilitydatabase</a></li>
                    <li>repository de google relatif au GTFS et GTFS Realtime <a
                            href="https://github.com/google/transit" target="_blank">github.com/google/transit</a>
                    </li>
                    <li>Cette visionneuse GTFS utilise des icônes modifiées et originalement créées par <a
                            href="https://www.streamlinehq.com/icons" rel="nofollow noopener noreferrer"
                            target="_blank">Streamline</a>, sous licence Creative commons license: Attribution 4.0
                        International (CC BY 4.0).</li>
                </ul>
                <h3>Fonctionnememt de cette visionneuse</h3>
                <p>Aucun fichier n'est sauvegardé par TestClimat et sa visionneuse GTFS. Tous les fichiers uploadés
                    sont
                    immédiatement supprimés du serveur. Les données ne sont sauvegardées dans aucune base de
                    données.
                    <br /><br />En cas de fichier lourd, le temps de chargement peut être long. Si la carte ne
                    s'affiche
                    pas correctement, recharger la page peut résoudre le problème. Si le problème persiste, merci de
                    me
                    contacter.
                    <br />Dans un souci d'optimisation, seuls les 20 premières lignes de chaque fichier sont
                    affichées
                    ici (chargement complet en cours de développement).
                    <br /><br />L'ensemble du code source du site est disponible sur <a
                        href="https://github.com/Quoifleur/testClimat-version_locale">github</a>
                </p>
            </div>
            <div class="formulaire">
                <h2 id="chargementFichier">Visualiser un fichier</h2>
                <?php require('template/GTFSchargementFichier.php'); ?>
            </div>
        </section>
        <section class="sommaire">
            <?php
            if ($fichierChargé) {
                require('outils/GTFScsvTOmap.php');
                require('template/GTFStable_presence_fichier.php');
            }
            ?>
        </section>
        <section class="section_recap">
            <?php
            if ($fichierChargé) {
                require('template/GTFSfichierExplicite.php');
                //require('outils/fichierGTFScompletEcriture.php');
            } else {
                require('template/GTFStexteIntroductif.php');
            }
            ?>
        </section>
        <section class="section_graphique">
            <div class="texte">
                <h1 id="Graphicage">Graphicage</h1>
                <?php
                if ($fichierChargé) {
                    echo '<p>Le fichier stop_times.txt a été détecté. Si le graphique ne s\'affiche pas, cela veut dire qu\'un problème et survenu. Tentez de recharger la page. Si le problème persiste merci de me contacter.</p>';
                    require('template/GTFSgraphiquetemplate.php');
                    require('outils/GTFSgraphique.php');
                } else {
                    echo '<p>Aucun fichier stop_times.txt n\'a été chargé et/ou détecté, en l\'absence de ces données, le graphique ne peut pas s\'afficher.</p>';
                } ?>
            </div>
        </section>
        <section class="section_carte">
            <div class="texte">
                <h1 id="carte">Carte</h1>
                <?php
                if ($fichierChargé) {
                    echo '<p>Le(s) fichier(s) stops.txt et/ou shapes.txt a(ont) été détecté(s). Si la carte ne s\'affiche pas, cela veut dire qu\'un problème et survenu. Tentez de recharger la page. Si le problème persiste merci de me contacter.</p>';
                    require('template/GTFSmap.php');
                    //require('template/GTFSformulaireExportCarte.php');
                    require('outils/GTFSnettoyage.php');
                } else {
                    echo '<p>Aucun des fichiers stops.txt ou shapes.txt ont été chargés et/ou détectés, en l\'absence de donnés cartographiables, la carte ne peut pas s\'afficher.</p>';
                }

                ?>
            </div>

        </section>
        <section class="section_legende">
            <div id="map_legend" class="texte">
                <h4>Légende</h4>
                <form id="background-form">
                    <label for="background-select">Arrière-plan</label>
                    <select id="background-select" name="background-select">
                        <option value="OSM">OpenStreetMap</option>
                        <option value="OTP">OpenTopoMap</option>
                        <option value="satellite">Satellite</option>
                        <!--<option value="other">Autre</option>-->
                        <option value="NA">Aucun</option>
                    </select>
                </form>
                <form id="stops-form">
                    <label for="stops-select">Arrêts et types d'arrêts</label>
                    <select id="stops-select" name="stops-select">
                        <option value="stops-all">Tous</option>
                        <option value="stops-NA">Aucun</option>
                        <option value="stops-0">stop or platform</option>
                        <option value="stops-1">station</option>
                        <option value="stops-2">Entrance/Exit</option>
                        <option value="trips-3">Generic Node</option>
                        <option value="trips-4">Boarding Area</option>
                    </select>
                </form>
                <form id="shapes-form">
                    <label for="shapes-select">Formes</label>
                    <select id="shapes-select" name="shapes-select">
                        <option value="shapes-all">Toutes</option>
                        <option value="shapes-NA">Aucune</option>
                    </select>
                </form>
                <table id="legend-table" class="table-container">
                    <thead>
                        <tr>
                            <th>Couleur</th>
                            <th>Shape</th>
                            <th>Route</th>
                            <th>Zoom</th>
                            <th>visibilité</th>
                        </tr>
                    </thead>
                    <tbody id="legend-body">
                    </tbody>
                </table>
        </section>
        <section class="section_fin">
            <?php require('template/GTFSdebug.php'); ?>
        </section>
    </main>

</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>