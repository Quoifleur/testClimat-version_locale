<?php
session_start();
include('connexion/bdconnexion.php');

global $climatStatement;
$user = strip_tags($_COOKIE['logged']) ?? null;

// On récupère tout le contenu de la table données
$sqlQuery = 'SELECT * FROM climat WHERE COMPTEclef = :COMPTEclef';
$climatStatement = $db->prepare($sqlQuery);
$climatStatement->execute(['COMPTEclef' => $user]);
$climatCherche = $climatStatement->fetchAll();
$id = array();
foreach ($climatCherche as $value) {
    $id[] = $value['id'];
    $Save[] = $value['SAVE'];
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

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <?php include('navigation/head.php'); ?>
    <title>testClimatModificationClimat</title>
</head>

<body>
    <?php include('navigation/header.php'); ?>
    <?php include('navigation/nav.php'); ?>
    <main>
        <section class="section_intro">
            <h1>Climat</h1>
            <table>
                <colgroup>
                    <col span="1" class="Nom de la sation">
                    <col span="1" class="Nom générique">
                    <col span="1" class="DATEcollecte">
                    <col span="1" class="DATEentre">
                    <col span="1" class="POSITIONx">
                    <col span="1" class="POSITIONy">
                    <col span="1" class="POSITIONz">
                </colgroup>
                <tr>
                    <th scope="col">
                        <label for="Nom de la sation">Nom de la sation</label>
                    </th>
                    <th scope="col">
                        <label for="Nom générique">Nom générique</label>
                    </th>
                    <th scope="col">
                        <label for="DATEcollecte">DATEcollecte</label>
                    </th>
                    <th scope="col">
                        <label for="DATEentre">DATEentre</label>
                    </th>
                    <th scope="col">
                        <label for="POSITIONx">POSITIONx</label>
                    </th>
                    <th scope="col">
                        <label for="POSITIONy">POSITIONy</label>
                    </th>
                    <th scope="col">
                        <label for="POSITIONz">POSITIONz</label>
                    </th>
                </tr>
                <?php
                echo '
                <tr>
                    <th class="' . $Nom . '">' . $Nom . '</th>
                    <td class="' . $NOMgenerique . '">' . $NOMgenerique . '</td>
                    <td class="' . $DATE_collecte . '">' . $DATE_collecte . '</td>
                    <td class="' . $DATE_entre . '">' . $DATE_entre . '</td>
                    <td class="' . $Px[0] . '">' . $Px[0] . '</td>
                    <td class="' . $Py[0] . '">' . $Py[0] . '</td>
                    <td class="' . $Pz[0] . '">' . $Pz[0] . '</td>
                </tr>';
                ?>
            </table>
        </section>
        <section class="section_milieu">
            <form>
                <legend>Les valeurs ont était récolté dans l'hémisphère :</legend>
                <div>
                    <input type="radio" id="Nord" name="hémisphère" value="Nord" checked>
                    <label for="Nord">Nord</label>
                </div>
                <div>
                    <input type="radio" id="Sud" name="hémisphère" value="Sud">
                    <label for="Sud">Sud</label>
                </div>
                <table>
                    <colgroup>
                        <col span="1" class="month">
                        <col span="1" class="ValeurTempérature">
                        <col span="1" class="ValeurPrécipitation">
                    </colgroup>
                    <tr>
                        <th class="month" scope="col">/</th>
                        <th scope="col">Température (°C)</th>
                        <th scope="col">Précipitation (mm)</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < 12; $i++) {
                        echo '
                        <tr>
                            <th class="month" scope="row">' . $month[$i] . '</th>
                            <td><input type="number" placeholder="0" step="0.01" id="TM' . $i . '" name="TM' . $i . '" maxlength="5" size="4" required value="' . $Te[$i] . '"></td>
                            <td><input type="number" placeholder="0" step="0.01" id="PM' . $i . '" name="PM' . $i . '" maxlength="5" size="4" required value="' . $Pr[$i] . '"></td>
                        </tr>';
                    }
                    ?>
                </table>
                <input type="submit" value="Envoyer">
            </form>


            </form>
        </section>
        <section class="section_fin">
        </section>
    </main>
    <footer>
        <?php include('navigation/footer.php'); ?>
    </footer>
</body>

</html>