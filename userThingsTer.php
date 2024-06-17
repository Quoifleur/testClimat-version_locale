<?php
session_start();
include('connexion/bdconnexion.php');
function NettoyageString($string)
{
    $string = strip_tags($string);
    $string = str_replace("'", "’", strip_tags($string));
    $string = str_replace('"', '“', $string);
    $string = str_replace('<', '«', $string);
    $string = str_replace('>', '»', $string);
    return $string;
}
$compteActif = false;
// Déconnexion
if (isset($_POST['deconnexion']) && isset($_COOKIE['logged'])) {
    $compteActif = false;
    setcookie('logged', '', time() + 1, null, null, false, true);
    unset($_COOKIE['logged']);
    header('Location: userThingsLogin.php');
    exit();
}
if (isset($_COOKIE['logged'])) {
    $user = strip_tags($_COOKIE['logged']);
    $compteActif = true;
}

if (isset($user)) {
    //echo 'balise 0 <br />';
    $sqlQuery = 'SELECT * FROM `CLIMAT` WHERE COMPTEclef = :COMPTEclef';
    $climatStatement = $db->prepare($sqlQuery);
    $climatStatement->execute(['COMPTEclef' => $user]);
    $table = $climatStatement->fetchAll();
    if (!empty($table)) {
        //echo 'balise 1 <br />';
        $sqlQuery = 'SELECT * FROM CLIMAT WHERE COMPTEclef = "' . $user . '" ORDER BY id ASC';
        $climatStatement = $db->prepare($sqlQuery);
        $climatStatement->execute();
        $climatCherche = $climatStatement->fetchAll();
        if (!empty($climatCherche)) {
            //echo 'balise 2 <br />';
            $id = array();
            foreach ($climatCherche as $value) {
                $id[] = $value['id'];
                $COMPTEclef[] = $value['COMPTEclef'];
                $Save[] = $value['SAVE'];
                $DATEcollecte[] = $value['DATEcollecte'];
                $DATEentre[] = $value['DATEentre'];
                $TEMPORALITEperiode[] = $value['TEMPORALITEperiode'];
                $TEMPORALITEmois[] = $value['TEMPORALITEmois'];
                $NOMlocalisation[] = $value['NOMlocalisation'];
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
            $LastEntryInID = end($id);
            //echo 'balise boucle : <br />';
            for ($i = 0; $i < $NbRowInTable; $i++) {
                if ($NOMgenerique[$i] != null) {
                    $Nom[$i] = $NOMgenerique[$i];
                } //else {
                //   $Nom[$i] = 'n/a';
                //}
                $LettrePlusNomClimat[$i] = explode(',', $RESULTATkoge[$i]);
                $LettreClimat[$i] = $LettrePlusNomClimat[$i][0];
                $NomClimat[$i] = $LettrePlusNomClimat[$i][1];
                $Te[$i] = explode(',', $NORMALETe[$i]);
                $Pr[$i] = explode(',', $NORMALEPr[$i]);
                $mois[$i] = explode(',', $TEMPORALITEmois[$i]);
                $Saison[$i] = explode(',', $SAISON[$i]);
                $hémisphère[$i] = $POSITIONhemisphere[$i];
                $Ikg[$i] = explode(',', $RESULTATkoge[$i]);
                $Ar[$i] = explode(',', $RESULTATgaus[$i]);
                $Im[$i] = explode(',', $RESULTATmart[$i]);
                //echo 'balise' . $i . '<br />';
            }
        }
    }
    $Voir = $_GET['Voir'] ?? null;
    $nommé = false;
    if (!isset($NbRowInTable)) {
        $NbRowInTable = 0;
    }
    // Pour nommer les climats
    for ($i = 0; $i < $NbRowInTable; $i++) {
        if (isset($_GET['nom' . $id[$i]])) {
            $Nommage[$i] = NettoyageString($_GET['nom' . $id[$i]]);
            if (isset($Nommage[$i])) {
                $sqlQuery = 'UPDATE `climat` SET `NOMgenerique` = :NOMgenerique WHERE `id` = :id AND `COMPTEclef` = :COMPTEclef';
                $NOMStatement = $db->prepare($sqlQuery);
                $NOMStatement->execute(['NOMgenerique' => $Nommage[$i], 'id' => $id[$i], 'COMPTEclef' => $user]) or die(print_r($db->errorInfo()));
                header('Location: userThingsTer.php');
                exit();
            }
        }
    }
    //téléchargement des données
    $a = 0;
    $downloadPossible = false;
    $downloadNom = 'climat';
    $ecritureLegende = '"ClimatNumero","Nom","Mois","Saison","Te","Pr","hémisphère","Gaussen","Martonne","NomClimat","LettreClimat"';
    //$ecritureSynthetiqueLegende = '"ClimatNumero","Nom","NomClimat","LettreClimat","hémisphère","Gaussen","Martonne"';
    $ecritureSynthetiqueValeurLegendeMois = '"Mois","';
    $ecritureSynthetiqueValeurLegendeTe = '"Température","';
    $ecritureSynthetiqueValeurLegendePr = '"Précipitation","';
    $ponctuation = '","';
    $ponctuationFinal = '"';
    $download[0] = $_GET['Télécharger'] ?? null;
    $download[1] = $_GET['climat-select'] ?? null;
    $download[2] = $_GET['version'] ?? null;
    for ($i = 0; $i <= 2; $i++) {
        if (isset($download[$i])) {
            $downloadPossible = true;
        }
    }
    if ($downloadPossible && $download[1] == 'all') {
        $download[1] = 'Tout les climats';
        $downloadNom = '*';
        while ($Ram[$a] == 2) {
            $ecriture[] = '"' . $Save[$a] . '","' . $Nom[$a] . '","' . $month[$a] . '","' . $Saison[$a] . '","' . $Te[$a] . '","' . $Pr[$a] . '","' . $hémisphère[$a] . '","' . $Ar[$a] . '","' . $Im[$a] . '","' . $NomClimat[$a] . '","' . $LettreClimat[$a] . '"';
            $a++;
        }
    } elseif ($downloadPossible) {
        $climatAtelecharger = explode('-', $download[1]);
        while ($Ram[$a] == 2) {
            if ($Save[$a] == $climatAtelecharger[0]) {
                if ($download[2] == 'long') {
                    $ecriture[] = '"' . $Save[$a] . '","' . $Nom[$a] . '","' . $month[$a] . '","' . $Saison[$a] . '","' . $Te[$a] . '","' . $Pr[$a] . '","' . $hémisphère[$a] . '","' . $Ar[$a] . '","' . $Im[$a] . '","' . $NomClimat[$a] . '","' . $LettreClimat[$a] . '"';
                    $ecritureSynthetique[] = '"' . $Save[$a] . '","' . $Nom[$a] . '","' . $NomClimat[$a] . '","' . $LettreClimat[$a] . '","' . $hémisphère[$a] . '","' . $Ar[$a] . '","' . $Im[$a] . '"';
                } else {
                    $ecritureSynthetiqueValeurMois = $month[$a];
                    $ecritureSynthetiqueValeurTe = $Te[$a];
                    $ecritureSynthetiqueValeurPr = $Pr[$a];
                }
            }
            $a++;
        }
    }
    $a = 0;
    if ($downloadPossible) {
        if ($download[2] == 'long' || $download[1] == 'Tout les climats') {
            $downloadNom = 'TestClimat§' . $download[1] . '§Complet.csv';
            $fichier = fopen($downloadNom, 'c+b');
            fwrite($fichier, $ecritureLegende);
            while (isset($ecriture[$a])) {
                fwrite($fichier, "\r\n");
                fwrite($fichier, $ecriture[$a]);
                $a++;
            }
        } elseif ($download[2] == 'compact_ligne') {
            $downloadNom = 'TestClimat§' . $download[1] . '§CompactLigne.csv';
            $fichier = fopen($downloadNom, 'c+b');
            fwrite($fichier, $ecritureSynthetiqueValeurLegendeMois);
            $a = 0;
            while ($a < 12) {
                fwrite($fichier, $ecritureSynthetiqueValeurMois[$a]);
                if ($a == 11) {
                    fwrite($fichier, $ponctuationFinal);
                } else {
                    fwrite($fichier, $ponctuation);
                }
                $a++;
            }
            $a = 0;
            fwrite($fichier, "\r\n");
            fwrite($fichier, $ecritureSynthetiqueValeurLegendeTe);
            while ($a < 12) {
                fwrite($fichier, $ecritureSynthetiqueValeurTe[$a]);
                if ($a == 11) {
                    fwrite($fichier, $ponctuationFinal);
                } else {
                    fwrite($fichier, $ponctuation);
                }
                $a++;
            }
            $a = 0;
            fwrite($fichier, "\r\n");
            fwrite($fichier, $ecritureSynthetiqueValeurLegendePr);
            while ($a < 12) {
                fwrite($fichier, $ecritureSynthetiqueValeurPr[$a]);
                if ($a == 11) {
                    fwrite($fichier, $ponctuationFinal);
                } else {
                    fwrite($fichier, $ponctuation);
                }
                $a++;
            }
            $a = 0;
        } else {
            $ecritureSynthetiqueValeurLegendeTe = 'Te","';
            $ecritureSynthetiqueValeurLegendePr = 'Pr"';
            for ($i = 0; $i < 12; $i++) {
                if ($i <= 8) {
                    $ecritureSynthetiqueValeurMois[$i] = 'M0' . $i + 1;
                } else {
                    $ecritureSynthetiqueValeurMois[$i] = 'M' . $i + 1;
                }
            }
            $downloadNom = 'TestClimat§' . $download[1] . '§CompactColone.csv';
            $fichier = fopen($downloadNom, 'c+b');
            fwrite($fichier, $ecritureSynthetiqueValeurLegendeMois . $ecritureSynthetiqueValeurLegendeTe . $ecritureSynthetiqueValeurLegendePr);
            fwrite($fichier, "\r\n");
            $a = 0;
            while ($a < 12) {
                fwrite($fichier, '"' . $ecritureSynthetiqueValeurMois[$a] . '","' . $ecritureSynthetiqueValeurTe[$a] . '","' . $ecritureSynthetiqueValeurPr[$a] . '"');
                fwrite($fichier, "\r\n");
                $a++;
            }
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($downloadNom) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($downloadNom));
        readfile($downloadNom);
        unlink($downloadNom);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include('navigation/head.php');
    ?>
    <title>testClimat</title>
</head>
<?php include('navigation/header.php'); ?>

<body>
    <?php include('navigation/nav.php'); ?>
    <main>
        <section class="section_intro">
            <h1>testClimat-Compte</h1>
            <p>
                <?php
                //echo $_COOKIE['logged'] . '<br />';
                if (!$compteActif) {
                    echo 'Connectez-vous (ou inscrivez-vous) pour pouvoir sauvegarder vos données et plus encore. <br /><a href="userThingsLogin.php">Connection et inscription</a>';
                } else {
                    echo 'Bienvenue sur votre compte. <br /><form method="post"><button method="post" type="submit" name="deconnexion" value="deconnexion">Déconnexion</button></form>';
                    echo '<p>Pour supprimer votre compte et effacer toutes vos données associé merci d\'aller à la page de <a href="testClimatCookie.php">gestion du compte</a> </p>';
                } ?>
            </p>
            <h2>Climats sauvegardé(s).</h2>
            <p>
                Retrouvez dans cette pages les climats sauvegardés. Le sauvegarde se fait automatiquement de sorte que chaque résultat est sauvé.
            </p>
        </section>
        <section class="section_milieu">
            <table>
                <caption>
                    Climats sauvegardés :
                </caption>
                <tbody>
                    <tr>
                        <th scope="col">Nb</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Climat</th>
                        <th scope="col">Code</th>
                        <th scope="col">hémisphère</th>
                        <th scope="col">Voir</th>
                        <th scope="col">Action</th>
                    </tr>
                    <?php
                    if (isset($NbRowInTable)) {
                        $i = 0;
                        while ($i < $NbRowInTable) {
                            echo '
					<tr>
						<th scope="row">' . $id[$i] . '</th>
						<td><code>' . $Nom[$i] . '</code></td>
						<td><code>' . $NomClimat[$i] . '</code></td>
						<td><code>' . $LettreClimat[$i] . '</code></td>
						<td><code>' . $hémisphère[$i] . '</code></td>
						<td><form id="Save" name="Voir" method="get" action="testClimatResultatTerTer.php"> <input type="submit" name="Voir" value="Observer climat ' . $id[$i] . '" /></form></td>
						<td><form id="nommer" name="nommer" method="get" action=""><input type="text" placeholder="" id="nom' . $id[$i] . '" name="nom' . $id[$i] . '" required><input type="submit" value="Nommer" /></form></td>
					  </tr>
				    ';
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table><br />
        </section>
        <section class="section_fin">
            <h3>Téléchargement</h3>
            <p>
            <form id="Télécharger" method='get' action='userThingsTer.php'>
                <label for="climat-select">Climat(s)</label>
                <select name="climat-select" id="climat-select" required>
                    <option class="bouton" value="">--</option>
                    <option class="bouton" value="all">Tout</option>
                    <?php
                    if (isset($NbRowInTable)) {
                        $i = 0;
                        while ($i < $NbRowInTable) {
                            echo '<option class="bouton" value="' . $id[$i] . '-' . $Nom[$i] . '">Climat' . $id[$i] . '-' . $Nom[$i] . '</option>';
                            $i++;
                        }
                    } else {
                        echo '<br />Utilisez <a href="index.php">TestClimat</a> pour télécharger des données.';
                    } ?>
                </select>
                <label for="version">version</label>
                <select name="version" id="version" required>
                    <option class="bouton" value="">--</option>
                    <option class="bouton" value="compact_colonne">compact_colonne</option>
                    <option class="bouton" value="compact_ligne">compact_ligne</option>
                    <option class="bouton" value="long">long</option>
                </select>
                <!--<label for="format">format</label>
				<select name="format" id="format" required>
					<option class="bouton" value="">--</option>
					<option class="bouton" value="SQL">SQL</option>
					<option class="bouton" value="CSV">CSV</option>
					<option class="bouton" value="PDF">PDF</option>
				</select>-->
                <input id="Télécharger" type="submit" name="Télécharger" value="Télécharger" onClick="doModifie()">
            </form>
            </p>
        </section>
    </main>
    <?php include('navigation/footer.php'); ?>
</body>


</html>