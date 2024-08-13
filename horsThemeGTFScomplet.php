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
        body {
            margin: auto;
            font-family: 'Ubuntu', sans-serif;
            background: linear-gradient(333deg, rgba(17, 122, 78, 1) 0%, rgb(6, 105, 100) 20%, rgb(37, 115, 178) 66%, rgba(104, 104, 235, 1) 100%);
            background-size: 100%;
        }

        header,
        nav {
            background: rgb(91, 196, 154);
            text-align: justify;
            padding: 1%;
            position: sticky;
            top: 0px;
            z-index: 1;
        }

        .menu,
        .pied {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .menu {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-template-rows: 1.5fr;
        }

        a {
            outline: none;
            font-weight: bold;
            text-decoration: none;
            color: rgb(255, 225, 106);
        }


        a:hover {
            color: rgb(91, 196, 154);
        }

        a#header:hover {
            color: rgb(255, 225, 106);
        }

        a:visited {
            color: rgb(255, 225, 106);
        }

        a:visited:hover {
            color: rgb(91, 196, 154);
        }

        .flou {
            background-color: rgb(255, 225, 106);
            color: rgb(255, 225, 106);
        }

        table {
            border-collapse: collapse;
            background-color: rgba(230, 255, 245, 0.514);
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            position: sticky;
            top: 50px;
            background-color: rgba(230, 255, 245);
        }
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
    <?php include('navigation/nav.php'); ?>
    <main>
        <h2><?php echo $fichier; ?></h2>
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
            $agency = file('upload/extract/' . $fichier . '/agency.txt');
            $InfoAgency = explode(',', $agency[1]);
            echo '<tr>';
            for ($i = 0; $i < 6; $i++) {
                echo '<td>' . $InfoAgency[$i] . '</td>';
            }
            echo '</tr>';
            ?>
        </table>
        <h3>Itinéraires</h3>
        <p>Itinéraires du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/routes.txt"'; ?>>routes.txt</a>.</p>
        <table>
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
        <h3>Arrêts</h3>
        <p>Arrêts du réseaux de transports en commun décrit dans le fichiers GTFS. Les données affichées ici sont issus de <a href=<?php echo '"upload/extract/' . $fichier . '/stops.txt"'; ?>>stops.txt</a>.</p>
        <table>
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
        <h3>Calendrier</h3>
    </main>
</body>
<footer>
    <?php include('navigation/footer.php'); ?>
</footer>

</html>