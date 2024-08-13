<?php
if (isset($_FILES['file'])) {
    include('ZIPtoTXT.php');
} else {
    $fichierChargé = false;
    $erreur = false;
}
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
            <h2>Fichier à visualiser</h2>
            <div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                <p>Le fichier doit être au format .zip</p>
            </div>
            <form method="POST" action="horsThemeGTFS.php" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="9000000">
                <input type="file" name="file" id="file" accept=".zip">
                <input type="submit" value="Envoyer">
            </form>
            <?php
            if ($fichierChargé) {
                echo '<div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                <p>Le fichier <b>' . $Nomfichier[0] . '</b> a été chargé avec succès </p>
            </div>';
            } else {
                echo '<div class="attention">
                <div class="attention_titre">Attention </div>
                <p>Aucun fichier n\'a été chargé. Pour se faire utilisez le formulaire ci-dessus. Si vous rencontrer un problème merci de me contacter. Noter que le fichier doit être au format zip</p>
            </div>';
            }
            if ($erreur) {
                echo '<div class="attention">
                <div class="attention_titre">Attention </div>
                <p>Une erreur est survenue. Le fichier doit être au format zip et ne doit pas dépasser 9000000 octets</p>';
            }
            ?>
        </section>
        <section class="section_milieu">
            <h2><?php echo $Nomfichier[0]; ?></h2>
            <div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                <p>Seul les dix premières lignes de chaque fichiers sont affichées ici. Pour retrouvé les données au complets merci d'aller
                <form id="voir" method="get" action="horsThemeGTFScomplet.php">
                    <input type="submit" name="voir" value=<?php echo '"' . $fichier . '"'; ?>>
                </form>
                </p>
            </div>
            <h3>Agences</h3>
            <p>Information sur l'organisme ayant fournit les données GTFS chargées ici. Les données affichées ici sont issus dz<a href=<?php echo '"upload/extract/' . $fichier . '/agency.txt"'; ?>>agency.txt</a>.</p>
            <table>
                <tr>
                    <th>agency_id</th>
                    <th>agency_name</th>
                    <th>agency_url</th>
                    <th>agency_timezone</th>
                    <th>agency_lang</th>
                    <th>agency_phone</th>
                </tr>
                <?php
                if ($fichierChargé) {
                    $agency = file('upload/extract/' . $fichier . '/agency.txt');
                    $InfoAgency = explode(',', $agency[1]);
                    echo '<tr>';
                    for ($i = 0; $i < 6; $i++) {
                        echo '<td>' . $InfoAgency[$i] . '</td>';
                    }
                    echo '</tr>';
                }
                ?>
            </table>
            <h3>Itinéraires</h3>
            <p>Itinéraires du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/routes.txt"'; ?>>routes.txt</a>.</p>
            <table>
                <?php
                if ($fichierChargé) {
                    $fichierBrut = file('upload/extract/' . $fichier . '/routes.txt');
                    $Legende = explode(',', $fichierBrut[0]);
                    $Nbligne = count($fichierBrut);
                    $Nbcolonnes = count($Legende);
                    for ($i = 0; $i < $Nbligne; $i++) {
                        $Info[$i] = explode(',', $fichierBrut[$i]);
                    }
                    //print_r($Info);
                    echo '<tr>';
                    for ($i = 0; $i < $Nbcolonnes; $i++) {
                        echo '<th>' . $Legende[$i] . '</th>';
                    }
                    echo '</tr>';
                    for ($i = 1; $i < 11; $i++) {
                        echo '<tr>';
                        for ($y = 0; $y < $Nbcolonnes; $y++) {
                            echo '<td>' . $Info[$i][$y] . '</td>';
                        }
                        echo '</tr>';
                    }
                }
                ?>
            </table>
            <h3>Arrêts</h3>
            <p>Arrêts du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/stops.txt"'; ?>>stops.txt</a>.</p>
            <table>
                <?php
                if ($fichierChargé) {
                    $fichierBrut = file('upload/extract/' . $fichier . '/stops.txt');
                    $Legende = explode(',', $fichierBrut[0]);
                    $Nbligne = count($fichierBrut);
                    $Nbcolonnes = count($Legende);
                    for ($i = 0; $i < $Nbligne; $i++) {
                        $Info[$i] = explode(',', $fichierBrut[$i]);
                    }
                    //print_r($Info);
                    echo '<tr>';
                    for ($i = 0; $i < $Nbcolonnes; $i++) {
                        echo '<th>' . $Legende[$i] . '</th>';
                    }
                    echo '</tr>';
                    for ($i = 1; $i < 11; $i++) {
                        echo '<tr>';
                        for ($y = 0; $y < $Nbcolonnes; $y++) {
                            echo '<td>' . $Info[$i][$y] . '</td>';
                        }
                        echo '</tr>';
                    }
                }
                ?>
            </table>
            <h3>Calendrier</h3>


        </section>
        <section class="section_fin">
            <div id="mapid"></div>
            <script>
                var mymap = L.map('mapid').setView([48.8534, 2.3488], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(mymap);
            </script>
        </section>
    </main>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>