<?php
session_start();
include('connexion/bdconnexion.php');

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
$user = strip_tags($_COOKIE['logged']) ?? null;
/*
echo $user;

$LimitStatement = $db->prepare($sqlQuery);
$LimitStatement->execute(['COMPTEclef' => $user]);
$Limit = $LimitStatement->fetchAll();


foreach ($Limit as $value) {
    $borne[] = $value['Save'];
}
*/
// On récupère tout le contenu de la table données
$sqlQuery = 'SELECT * FROM climat WHERE COMPTEclef = :COMPTEclef';
$climatStatement = $db->prepare($sqlQuery);
$climatStatement->execute(['COMPTEclef' => $user]);
$climatCherche = $climatStatement->fetchAll();
$id = array();
foreach ($climatCherche as $value) {
    $id[] = $value['id'];
    // $Save[] = $value['SAVE'];
    $DATEcollecte[] = $value['DATEcollecte'];
    $DATEentre[] = $value['DATEentre'];
    $TEMPORALITEperiode[] = $value['TEMPORALITEperiode'];
    $TEMPORALITEmois[] = $value['TEMPORALITEmois'];
    $NOMlocation[] = $value['NOMlocalisation'];
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
$InfoVoir = strip_tags($_GET['Voir'] ?? null);
if ($InfoVoir == null) {
    for ($i = 0; $i < 4; $i++) {
        $Info[$i] = null;
    }
} else {
    $Info = explode(" ",  $InfoVoir);
}
if ($Info[2] == null || !is_numeric($Info[2]) || $Info[2] > $NbRowInTable - 1 || $Info[2] < 0) {
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
$NOMgenerique = $NOMgenerique[$climatSelected];
$Ikg = explode(',', $RESULTATkoge[$climatSelected]);
$Ar = explode(',', $RESULTATgaus[$climatSelected]);
$Im = explode(',', $RESULTATmart[$climatSelected]);
$hémisphère = $POSITIONhemisphere[$climatSelected];
$Px = explode(',', $POSITIONx[$climatSelected]);
$Py = explode(',', $POSITIONy[$climatSelected]);
$Pz = explode(',', $POSITIONz[$climatSelected]);
$DATE_collecte = $DATEcollecte[$climatSelected];
$DATE_entre = $DATEentre[$climatSelected];
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
//Encodage pour javascript
$JsonTe = json_encode($Te);
$JsonPr = json_encode($Pr);
$JsonMonth = json_encode($month);
$JsonSaison = json_encode($Saison);
$JsonAr = json_encode($Ar);
$JsonIm = json_encode($Im);
$JsonNom = json_encode($Nom);
$JsonLettreClimat = isset($LettreClimat[$climatSelected]) ? json_encode($LettreClimat[$climatSelected]) : null;
$JsonNomClimat = json_encode($NomClimat);
$JsonTmax = json_encode($Tmax);
$JsonTmin = json_encode($Tmin);
$JsonTannuelle = json_encode($Tannuelle);
$JsonPmax = json_encode($Pmax);
$JsonPmin = json_encode($Pmin);
$JsonPannuelle = json_encode($Pannuelle);
$JsonIMmax = json_encode($IMmax);
$JsonIMmin = json_encode($IMmin);
$JsonNord = json_encode($Nord);
$JsonPx = isset($Px[$climatSelected]) ? json_encode($Px[$climatSelected]) : null;
$JsonPy = isset($Py[$climatSelected]) ? json_encode($Py[$climatSelected]) : null;
$JsonPz = isset($Pz[$climatSelected]) ? json_encode($Pz[$climatSelected]) : null;
$JsonHémisphère = json_encode($hémisphère);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
            <h1>Climat</h1>
            <p><?php
                echo '<br /> Le climat trouvé est le suivant : <b>' . $NomClimat .  '</b>; Lettes associées : <b>' . $LettreClimat . '</b>'; ?>
                <br /><br /><b>Ce climat a été enregistré automatiquement</b>, pour retrouver tous vos anciens climats recherchés, rendez-vous sur la page <a href="userThingsTer.php">compte</a>.
            </p>
            <table>
                <caption>Informations sur le climat</caption>
                <tr>
                    <th>
                        <label for="Nom de la sation">Nom de la sation</label>
                    </th>
                    <th>
                        <label for="Nom générique">Nom générique</label>
                    </th>
                    <th>
                        <label for="DATEcollecte">DATEcollecte</label>
                    </th>
                    <th>
                        <label for="DATEentre">DATEentre</label>
                    </th>
                </tr>
                <?php
                echo '<tr>
                    <td class="' . $Nom . '">' . $Nom . '</td>
                    <td class="' . $NOMgenerique . '">' . $NOMgenerique . '</td>
                    <td class="' . $DATE_collecte . '">' . $DATE_collecte . '</td>
                    <td class="' . $DATE_entre . '">' . $DATE_entre . '</td>
                    </tr>';
                ?>
                <tr>
                    <th>
                        <label for="POSITIONhemisphere">Hémisphere</label>
                    <th>
                        <label for="POSITIONx">Longitude (x)</label>
                    </th>
                    <th>
                        <label for="POSITIONy">Lattitude (y)</label>
                    </th>
                    <th>
                        <label for="POSITIONz">Altitude (z)</label>
                    </th>
                </tr>
                <?php
                echo '
                <tr>
                    <td class="' . $hémisphère . '">' . $hémisphère . '</td>
                    <td class="' . $Px[0] . '">' . $Px[0] . '</td>
                    <td class="' . $Py[0] . '">' . $Py[0] . '</td>
                    <td class="' . $Pz[0] . '">' . $Pz[0] . '</td>
                </tr>';
                ?>
            </table>
        </section>
        <section class="section_milieu">
            <div>
                <br /><a href="index.php">Rentrer de nouvelles valeurs / Revenir à l'accueil.</a>
            </div>
            <p>Appuyer sur une des listes déroulantes pour classer une des variable par ordre croissant ou décroissant, puis appuyer sur le bouton Ordonner. Appuyez une nouvelle fois sur celui-ci pour réinitialier l'ordre du tableau.</p>
            <table>
                <caption>Tableau des valeurs</caption>
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
                La sauvegarde des climats est automatique, pour retrouver tous vos anciens climats recherchés, rendez-vous sur la page <a href="userThingsTer.php">compte</a>.<br />
                <br />
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
            <p>
                <?php
                if (isset($Px[0]) && isset($Py[0])) {
                    echo 'Coordonnées géographiques : ' . $Px[$climatSelected] . ' ; ' . $Py[$climatSelected] . ' ; ' . $Pz[$climatSelected];
                    echo '<div id="map" style="width: 100%; height: 400px;">
                <script type="text/javascript">
                    var Px = ' . $JsonPx . ' || null;
                    var Py = ' . $JsonPy . ' || null;
                    var Pz = ' .  $JsonPz . ' || null;
                    var CodeClimat = ' .  $JsonLettreClimat . ';
                    ' . include ('carte.js') . '
                </script>
            </div>';
                }
                ?>

            </p>
        </section>
    </main>
    <footer>
        <?php include('navigation/footer.php'); ?>
    </footer>
</body>

</html>