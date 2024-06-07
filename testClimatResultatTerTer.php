<?php
session_start();
try {
    $db = new PDO('mysql:host=localhost;dbname=testclimat;charset=utf8', 'root', 'root', [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],);
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}

//print_r($borne);
//echo $Voir;
/*
$SupprimerOuSauver = $Info[0];
if ($SupprimerOuSauver == 'Supprimer') {
    $sqlQuery = 'UPDATE ' . $user . ' SET Ram = 3 WHERE Save = ' . $Voir;
    $UnSaveClimat = $db->prepare($sqlQuery);
    for ($i = 0; $i < 12; $i++) {
        $UnSaveClimat->execute() or die(print_r($db->errorInfo()));
    }
}
if ($SupprimerOuSauver == 'Sauvegarder') {
    $sqlQuery = 'UPDATE `' . $user . '` SET `Ram` = 4 WHERE Ram = 0';
    $SaveClimat = $db->prepare($sqlQuery);
    for ($i = 0; $i < 12; $i++) {
        $SaveClimat->execute() or die(print_r($db->errorInfo()));
    }
    $sqlQuery = 'UPDATE `' . $user . '`
    SET `Ram` = (
        CASE
            WHEN `Ram` = 3 THEN  2
            WHEN `Ram` = 4 THEN  1
        END
    ) 
    WHERE Ram = 3 OR Ram = 4';
    $SaveClimat = $db->prepare($sqlQuery);
    // a modifier
    for ($i = 0; $i < 12; $i++) {
        $SaveClimat->execute() or die(print_r($db->errorInfo()));
    }
}
*/
global $climatStatement;

$user = strip_tags($_COOKIE['logged']);

$sqlQuery = 'SELECT * FROM ' . $user . '';
$LimitStatement = $db->prepare($sqlQuery);
$LimitStatement->execute();
$Limit = $LimitStatement->fetchAll();

foreach ($Limit as $value) {
    $borne[] = $value['Save'];
}

// On récupère tout le contenu de la table données
$climatStatement = $db->prepare($sqlQuery);
$climatStatement->execute();
$climatCherche = $climatStatement->fetchAll();

foreach ($climatCherche as $value) {
    $id[] = $value['id'];
    $Save[] = $value['SAVE'];
    $DATEcollecte[] = $value['DATEcollecte'];
    $DATEentre[] = $value['DATEentre'];
    $TEMPORALITEperiode[] = $value['TEMPORALITEperiode'];
    $TEMPORALITEmois[] = $value['TEMPORALITEmois'];
    $NOMlocation[] = $value['NOMlocation'];
    $NOMgenerique[] = $value['NOMgenerique'];
    $POSITIONhemisphere[] = $value['POSITIONhemisphere'];
    $POSITIONx[] = $value['POSITIONx'];
    $POSITIONy[] = $value['POSITIONy'];
    $POSITIONz[] = $value['POSITIONz'];
    $SAISON[] = $value['TEMPORALITEsaison'];
    $NORMALETe[] = $value['NORMALEte'];
    $NORMALEPr[] = $value['NORMALEpr'];
    $NORMALE2[] = $value['NORMALE2'];
    $NORMALE3[] = $value['NORMALE3'];
    $NORMALE4[] = $value['NORMALE4'];
    $RESULTATkoge[] = $value['RESULTATkoge'];
    $RESULTATgaus[] = $value['RESULTATgaus'];
    $RESULTATmart[] = $value['RESULTATmart'];
}
$NbRowInTable = count($id);

$Info = explode(" ",  strip_tags($_GET['Voir'] ?? null));
if ($Info[2] = null || !is_numeric($Info[2]) || $Info[2] > $NbRowInTable - 1 || $Info[2] < 0) {
    $climatSelected = $NbRowInTable - 1;
} else {
    $climatSelected = $Info[2];
}
// Récupération du bon climat
$Te = explode(',', $NORMALETe[$climatSelected]);
$Pr = explode(',', $NORMALEPr[$climatSelected]);
$month = explode(',', $TEMPORALITEmois[$climatSelected]);
$Saison = explode(',', $SAISON[$climatSelected]);
$Nom = $NOMlocation[$climatSelected];
$Ikg = explode(',', $RESULTATkoge[$climatSelected]);
$Ar = explode(',', $RESULTATgaus[$climatSelected]);
$Im = explode(',', $RESULTATmart[$climatSelected]);

//Traitement des données :
/*Calcule des variables */
$LettreClimat = $Ikg[0];
$NomClimat = $Ikg[1];
$Tmax = max($Te);
$Tmin = min($Te);
$Tannuelle = array_sum($Te) / 12;
$Pmax = max($Pr);
$Pmin = min($Pr);
$Pannuelle = array_sum($Pr);
$IMmax = max($Im);
$IMmin = min($Im);

for ($i = 0; $i < 12; $i++) {
    $Ar[$i] = ((bool) $Ar[$i]);
    if ($Ar[$i]) {
        $Ar[$i] = '<b> OUI </b>';
    } else {
        $Ar[$i] = 'non';
    }
}
if ($hémisphère == 'Nord') {
    $Nord = true;
} elseif ($hémisphère == 'Sud') {
    $Nord = false;
}
//print_r($month);
//Mois S ou W
?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // table des valeurs.
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Précipitation (en mm)', 'Température (en °C)'],
                ['M1', <?php echo $Pr[0]; ?>, <?php echo $Te[0]; ?>, ],
                ['M2', <?php echo $Pr[1]; ?>, <?php echo $Te[1]; ?>, ],
                ['M3', <?php echo $Pr[2]; ?>, <?php echo $Te[2]; ?>, ],
                ['M4', <?php echo $Pr[3]; ?>, <?php echo $Te[3]; ?>, ],
                ['M5', <?php echo $Pr[4]; ?>, <?php echo $Te[4]; ?>, ],
                ['M6', <?php echo $Pr[5]; ?>, <?php echo $Te[5]; ?>, ],
                ['M7', <?php echo $Pr[6]; ?>, <?php echo $Te[6]; ?>, ],
                ['M8', <?php echo $Pr[7]; ?>, <?php echo $Te[7]; ?>, ],
                ['M9', <?php echo $Pr[8]; ?>, <?php echo $Te[8]; ?>, ],
                ['M10', <?php echo $Pr[9]; ?>, <?php echo $Te[9]; ?>, ],
                ['M11', <?php echo $Pr[10]; ?>, <?php echo $Te[10]; ?>, ],
                ['M12', <?php echo $Pr[11]; ?>, <?php echo $Te[11]; ?>, ]
            ]);

            var options = {
                title: 'Représentation graphique des valeurs',
                series: {
                    0: {
                        targetAxisIndex: 1
                    },
                    1: {
                        type: 'line',
                        targetAxisIndex: 0,
                    },
                },
                vAxis: {
                    0: {
                        title: 'Température (en °C)',
                        ticks: [0, 20, 40, 60, 80, 100, 120, 140]
                    },
                    1: {
                        title: 'Précipitation (en mm)',
                    }
                },
                hAxis: {
                    title: 'Mois'
                },
                seriesType: 'bars',
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        /*function doModifie() {
            document.getElementById('Ordonner').value = "Ordonner";
        }*/
    </script>
    <!-- Import Leaflet CSS Style Sheet -->
    <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css" />
    <!-- Import Leaflet JS Library -->
    <script src="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.js"></script>
    <style>
        <?php
        include('FCSS/NORDcss.css');
        ?>
    </style>
    <?php include('navigation/head.php'); ?>
    <title>testClimatResultat</title>
</head>

<body>
    <?php include('navigation/header.php'); ?>
    <?php include('navigation/nav.php'); ?>
    <main>
        <section class="section_intro">
            <h1>Climat <?php echo $Voir . ', ' . $Nom[$Voir]; ?></h1>
            <!--<p><?php echo $borne[0] . '<br />' . $Voir; ?></p>-->
            <p><?php
                echo '<br /> Le climat trouvé est le suivant : <b>' . $NomClimat .  '</b>; Lettes associées : <b>' . $LettreClimat . '</b>'; ?></p>
        </section>
        <section class="section_milieu">
            <div>
                <br /><a href="index.php">Rentrer de nouvelles valeurs / Revenir à l'accueil.</a>
            </div>
            <p>Appuyer sur une des listes déroulantes pour classer une des variable par ordre croissant ou décroissant, puis appuyer sur le bouton Ordonner. Appuyez une nouvelle fois sur celui-ci pour réinitialier l'ordre du tableau.</p>
            <table>
                <colgroup>
                    <col span="1" class="month">
                    <col span="1" class="ValeurTempérature">
                    <col span="1" class="ValeurPrécipitation">
                </colgroup>
                <tr>
                    <th class="month" scope="col"></th>
                    <th scope="col">
                        <label for="OrdreTe">Température °C</label>
                    </th>
                    <th scope="col">
                        <label for="OrdrePr">Précipitation (mm)</label>
                    </th>
                    <th scope="col">
                        <label for="OrdreGaussen">Mois Aride?</label>
                    </th>
                    <th scope="col">
                        <label for="OrdreMartonne">Indice de Martonne</label>
                    </th>
                </tr>
                <?php
                for ($i = 0; $i < 12; $i++) {
                    if ($Te[$i] == $Tmax) {
                        $AffichageSaison = $Saison[$i] . 'max';
                    } elseif ($Te[$i] == $Tmin) {
                        $AffichageSaison = $Saison[$i] . 'min';
                    } else {
                        $AffichageSaison = $Saison[$i] . 'month';
                    }
                    echo '<tr>
                    <th class="' . $Saison[$i] . 'month"  scope=row>' . $month[$i] . '</th>
                    <td class="' . $AffichageSaison . '">' . $Te[$i] . '</td>
                    <td class="' . $AffichageSaison . '">' . $Pr[$i] . '</td>
                    <td class="' . $Saison[$i] . 'month">' . $Ar[$i] . '</td>
                    <td class="' . $AffichageSaison . '">' . $Im[$i] . '</td>
                </tr>';
                }
                ?>
            </table>
            <p class="legende">
                Pour déterminer si un mois est aride nous utilisons l'indice Gaussen.
                <br /> Cette indice est calculé ainsi : Un mois est aride si P
                < 2T. <br /><br />Pour en savoir plus sur l'indice de Martonne <a href="https://fr.wikipedia.org/wiki/Aridit%C3%A9">Indice de Martonne</a>, <a href="testClimatAide.php#Martonne">Aide.</a>
            </p>
        </section>
        <section class="section_fin">
            <p>
                <?php
                /*Annonce du climat trouvé */
                /*echo 'Variable ClimatTrouvé : ' . $ClimatTrouvé;*/
                echo /*'<br /> Variable Nord et */ 'Hémisphère : '/* . $Nord . ' ; '*/ . $hémisphère;
                echo '<br /> Le climat trouvé est le suivant : <b>' . $NomClimat .  '</b>; Lettes associées : <b>' . $LettreClimat . '</b>';

                /*Annonce des variables calculé */
                echo '<br /><br /> Variables Tmax, Tmin et Tannuelle : ' . $Tmax . '  ' . $Tmin . ' ; ' . $Tannuelle;
                echo '<br /><br /> Variables Pmax : '/*, Pmax et Pwmax : '*/ . $Pmax /*. ' ; ' . $Pmax . ' ; ' . $Pwmax*/;
                echo '<br /> Variables Pmin : '/*, Pmin et Pwmin : '*/ . $Pmin/* . ' ; ' . $Pmin . ' ; ' . $Pwmin*/;
                echo '<br /> Variables Pannuelle,' /* Phiver et Pété : '*/ . $Pannuelle/* . ' ; ' . $Phiver . ' ; ' . $Pété*/;
                //echo '<br /><br />' . /*'Variables PTHTrouvé et'*/ 'PTH : '/* . $PTHTrouvé . ' ; '*/ . $PTH;
                /*echo '<br /><br /> Variables b, i et Compte : ' . $b . ' ; ' . $i . ' ; ' . $Compte; */
                //echo '<br /><br /> Nombre de mois aride : ' . $NbAride . ' (Selon l \'indice de Gaussen).';
                ?>
            </p>
            <p>
            <div id="chart_div" class="chart_div"></div>
            D'après le tableau de valeurs ci-dessus.
            </p>
        </section>
    </main>
    <footer>
        <?php include('navigation/footer.php'); ?>
    </footer>
</body>

</html>