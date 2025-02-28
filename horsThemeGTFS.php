<?php
session_start();
require('src/function_other.php');

if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    require('outils/ZIPtoTXT.php');
    $fichierChargé = true;
    $MessageErreur[] = 'Info : fichier chargé <br />';
} else {
    $fichierChargé = false;
    $erreur = true;
    $MessageErreur[] = 'Erreur : fichier non chargé <br />';
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
    <script>
        function loadContent() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'content.php', true);
            xhr.onreadystatechange = function() {
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
    <style>
        .table_neutre {
            background: #FFF9DF;
            color: #6F6951;
        }

        .mode-icon {
            color: #6F6951;
        }

        #dropZone {
            color: #6F6951;
            background-color: #FFF9DF;
            width: 300px;
            height: 200px;
            border: 2px dashed #6F6951;
            outline: 2px solid #6F6951;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        #dropZone.dragover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <?php
    require('navigation/headerGTFS.php');
    require('navigation/nav.php');
    ?>
    <div class="GTFS">
        <?php
        require('template/GTFSsommaire.php');
        ?>
        <main>
            <section class="section_intro">
                <div class="texte">
                    <h1>Visionneuse GTFS schedule</h1>
                    <p>testClimat-visionneuse GTFS scheldule v1.1 26/01/2025, <a href="testClimatchangelog.php">changelog</a>
                    </p>
                    <h2>GTFS</h2>
                    <p>Le General Transit Feed Specification (GTFS) est un format de fichier qui contient les horaires des
                        transports en commun. Il est utilisé par de nombreuses applications de transport en commun, telles que
                        Google Maps, pour afficher les horaires des bus, des trains et des métros. Le GTFS est un format de
                        fichier simple et facile à utiliser qui permet aux développeurs de créer des applications de transport
                        en commun.</p>
                    <p> Cette visionneuse GTFS utilise des icônes modifiées et originalement créées par <a
                            href="https://www.streamlinehq.com/icons" rel="nofollow noopener noreferrer"
                            target="_blank">Streamline</a>, sous licence Creative commons license: Attribution 4.0 International
                        (CC BY 4.0).</p>
                </div>
                <br />
                <div class="texte">
                    <h3>Documentation</h3>
                    <ul>
                        <li>Site internet officiel de <a href="https://gtfs.org/fr/" target="_blank">gtfs.org</a></li>
                        <li>Pour télécharger des fichiers GTFS : <a href="https://mobilitydatabase.org/"
                                target="_blank">mobilitydatabase</a></li>
                        <li>repository de google relatif au GTFS et GTFS Realtime <a href="https://github.com/google/transit"
                                target="_blank">github.com/google/transit</a></li>
                    </ul>
                </div>
                <br />
                <div class="A_noter">
                    <div class="A_noter_titre">A noter</div>
                    <p>Aucun fichier n'est sauvegardé par TestClimat et sa visionneuse GTFS. Tous les fichiers uploadés sont
                        immédiatement supprimés du serveur. Les données ne sont sauvegardées dans aucune base de données.
                        <br /><br />En cas de fichier lourd, le temps de chargement peut être long. Si la carte ne s'affiche
                        pas correctement, recharger la page peut résoudre le problème. Si le problème persiste, merci de me
                        contacter.
                        <br />Dans un souci d'optimisation, seuls les 20 premières lignes de chaque fichier sont affichées
                        ici (chargement complet en cours de développement).
                        <br /><br />L'ensemble du code source du site est disponible sur <a
                            href="https://github.com/Quoifleur/testClimat-version_locale">github</a>
                    </p>
                </div>
                <h2 id="chargementFichier">Fichier à visualiser</h2>
                <?php require('template/GTFSchargementFichier.php');
                ?>
            </section>
            <section class="section_milieu">
                <h2><?= $Nomfichier[0] ?? 'Bienvenue dans la liseuse de fichier GTFS'; ?></h2>

                <?php
                if ($fichierChargé) {
                    require('outils/GTFScsvTOmap.php');
                    require('template/GTFStable_presence_fichier.php');
                    echo '<br />';
                    require('template/GTFSfichierExplicite.php');
                    //require('outils/fichierGTFScompletEcriture.php');
                }
                ?>
            </section>
            <section class="section_fin">
                <div class="texte">
                    <div id="legende-container">
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

                </div>

            </section>
        </main>
    </div>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>