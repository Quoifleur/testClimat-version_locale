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
                <form method="POST" action="horsThemeGTFS.php" enctype="multipart/form-data">
                    <input type="hidden" name="MAX_FILE_SIZE" value="9000000">
                    <input type="file" name="file" id="file" accept=".zip">
                    <input type="submit" value="Envoyer">
                </form>
        </section>
        <section class="section_milieu">
            <?php
            if ($fichierChargé) {
                echo '<div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                <p>Le fichier <b>' . $fichier . '</b> a été chargé avec succès </p>
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