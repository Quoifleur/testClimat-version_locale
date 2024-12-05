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
        <?php
        require('template/GTFSsommaire.php');
        require('template/GTFStable_presence_fichier.php');
        require('template/GTFSfichierExpliciteBis.php');
        ?>
    </main>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>