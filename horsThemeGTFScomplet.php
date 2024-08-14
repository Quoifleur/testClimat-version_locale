<?php

$fichier = strip_tags($_GET['voir']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="png" href="/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,900;1,900&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
    <style>
        <?php include('FCSS/GTFS.css'); ?>
    </style>
    <title>Visonneuse GTFS</title>
</head>

<body>
    <header>
        <a href="index.php" id="header">TestClimat</a>
        <?php
        if (isset($_COOKIE['logged'])) {
            echo '<img class"logged_picture" src="favicon.png"/> ';
        }
        echo ' - ' . $fichier;
        ?>
    </header>
    <!--<div class="rectangle"></div>-->
    <?php include('navigation/nav.php'); ?>
    <aside>
        <div class="aside">
            <div class="sousAside"><a href="#sommaire">Sommaire</a></div>
            <div class="sousAside"><a href="#agency">Agences</a></div>
            <div class="sousAside"><a href="#routes">Itinéraires</a></div>
            <div class="sousAside"><a href="#stops">Arrêts</a></div>
            <div class="sousAside"><a href="#calendar">Calendrier</a></div>
            <div class="sousAside"><a href="#trips">Trajet</a></div>
            <div class="sousAside"><a href="#shapes">Forme</a></div>
        </div>
    </aside>
    <main>
        <h2><?php echo $fichier; ?></h2>
        <h3 id="sommaire">Sommaire</h3>
        <ul>
            <li><a href="#agency">Agences</a></li>
            <li><a href="#routes">Itinéraires</a></li>
            <li><a href="#stops">Arrêts</a></li>
            <li><a href="#calendar">Calendrier</a></li>
        </ul>
        <h3 id="agency">Agence</h3>
        <p>Information sur l'organisme ayant fournit les données GTFS chargées ici. Les données affichées ici sont issus dz<a href=<?php echo '"upload/extract/' . $fichier . '/agency.txt"'; ?>>agency.txt</a>.</p>
        <table>
            <caption>Agence (agency.txt)</caption>
            <tr>
                <th>agency_id</th>
                <th>agency_name</th>
                <th>agency_url</th>
                <th>agency_timezone</th>
                <th>agency_lang</th>
                <th>agency_phone</th>
            </tr>
            <?php
            $agency = file('upload/extract/' . $fichier . '/agency.txt');
            $InfoAgency = explode(',', $agency[1]);
            echo '<tr>';
            for ($i = 0; $i < 6; $i++) {
                echo '<td>' . $InfoAgency[$i] . '</td>';
            }
            echo '</tr>';
            ?>
        </table>
        <h3 id="routes">Itinéraires</h3>
        <p>Itinéraires du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/routes.txt"'; ?>>routes.txt</a>.</p>
        <table>
            <caption>Itinéraires (routes.txt)</caption>
            <?php
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
            for ($i = 1; $i < $Nbligne; $i++) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    echo '<td>' . $Info[$i][$y] . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <h3 id="stops">Arrêts</h3>
        <p>Arrêts du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/stops.txt"'; ?>>stops.txt</a>.</p>
        <table>
            <caption>Arrêts (stops.txt)</caption>
            <?php
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
            for ($i = 1; $i < $Nbligne; $i++) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    echo '<td>' . $Info[$i][$y] . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <h3 id="calendar">Calendrier</h3>
        <p>Jours de service des différentes lignes du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/calendar.txt"'; ?>>stops.txt</a>.</p>
        <table>
            <caption>Calendrier (calendar.txt)</caption>
            <?php
            $fichierBrut = file('upload/extract/' . $fichier . '/calendar.txt');
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
            for ($i = 1; $i < $Nbligne; $i++) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    echo '<td>' . $Info[$i][$y] . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <h3 id="trips">trajet</h3>
        <p>Complémentaire au fichier calendar.txt, décrit les trajets des différentes lignes du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/trips.txt"'; ?>>trips.txt</a>.</p>
        <table>
            <caption>Trajet (trips.txt)</caption>
            <?php
            $fichierBrut = file('upload/extract/' . $fichier . '/trips.txt');
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
            for ($i = 1; $i < $Nbligne; $i++) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    echo '<td>' . $Info[$i][$y] . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <h3 id="shapes">Forme</h3>
        <p>Décrit les trajets les formes des différentes lignes du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/shapes.txt"'; ?>>shapes.txt</a>.</p>
        <p>Notez que le fichier shapes.txt est trop volumineux pour être affiché ici.</p>
        <!-- <table>
            <caption>Shapes (shapes.txt)</caption>
            <?php
            /*$fichierBrut = file('upload/extract/' . $fichier . '/shapes.txt');
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
            for ($i = 1; $i < $Nbligne; $i++) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    echo '<td>' . $Info[$i][$y] . '</td>';
                }
                echo '</tr>';
            }*/
            ?>
        </table>-->
    </main>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>