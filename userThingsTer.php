<?php
session_start();
include('connexion/bdconnexion.php');
$compteActif = false;
// Déconnexion
if (isset($_POST['deconnexion']) && isset($_COOKIE['logged'])) {
    $compteActif = false;
    setcookie('logged', $value['clef'], time() + 1, '/', '', true, true);
    unset($_COOKIE['logged']);
    session_destroy();
    header('Location: userThingsLogin.php');
    exit();
}
if (isset($_COOKIE['logged'])) {
    $user = strip_tags($_COOKIE['logged']);
    $compteActif = true;
}
if (isset($user)) {
    //echo 'balise 0 <br />';
    $sqlQuery = 'SELECT * FROM `climat` WHERE COMPTEclef = :COMPTEclef';
    $climatStatement = $db->prepare($sqlQuery);
    $climatStatement->execute(['COMPTEclef' => $user]);
    $table = $climatStatement->fetchAll();
    if (!empty($table)) {
        //echo 'balise 1 <br />';
        $sqlQuery = 'SELECT * FROM climat WHERE COMPTEclef = "' . $user . '" ORDER BY id ASC';
        $climatStatement = $db->prepare($sqlQuery);
        $climatStatement->execute();
        $climatCherche = $climatStatement->fetchAll();
        if (!empty($climatCherche)) {
            //echo 'balise 2 <br />';
            foreach ($climatCherche as $value) {
                $id[] = $value['id'];
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
            //echo 'balise boucle : <br />';
            for ($i = 0; $i < $NbRowInTable; $i++) {
                if ($NOMgenerique[$i] != null) {
                    $Nom[$i] = $NOMgenerique[$i];
                } else {
                    $Nom[$i] = 'n/a';
                }
                /*$LettrePlusNomClimat[$i] = explode(',', $RESULTATkoge[$i]);
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
                echo 'balise' . $i . '<br />';*/
                $ASave[$i] = explode(',', $Save[$i]);
                $ADATEcollecte[$i] = explode(',', $DATEcollecte[$i]);
                $ADATEentre[$i] = explode(',', $DATEentre[$i]);
                $ATEMPORALITEperiode[$i] = explode(',', $TEMPORALITEperiode[$i]);
                $mois[$i] = explode(',', $TEMPORALITEmois[$i]);
                $ANOMlocalisation[$i] = explode(',', $NOMlocalisation[$i]);
                $ANOMgenerique[$i] = explode(',', $NOMgenerique[$i]);
                $hémisphère[$i] = $POSITIONhemisphere[$i];
                $APOSITIONx[$i] = explode(',', $POSITIONx[$i]);
                $APOSITIONy[$i] = explode(',', $POSITIONy[$i]);
                $APOSITIONz[$i] = explode(',', $POSITIONz[$i]);
                $ASAISON[$i] = explode(',', $SAISON[$i]);
                $Te[$i] = explode(',', $NORMALETe[$i]);
                $Pr[$i] = explode(',', $NORMALEPr[$i]);
                $ANORMALE2[$i] = explode(',', $NORMALE2[$i]);
                $ANORMALE3[$i] = explode(',', $NORMALE3[$i]);
                $ANORMALE4[$i] = explode(',', $NORMALE4[$i]);
                $Ikg[$i] = explode(',', $RESULTATkoge[$i]);
                $Ar[$i] = explode(',', $RESULTATgaus[$i]);
                $Im[$i] = explode(',', $RESULTATmart[$i]);
                $LettrePlusNomClimat[$i] = explode(',', $RESULTATkoge[$i]);
                $LettreClimat[$i] = $LettrePlusNomClimat[$i][0];
                $NomClimat[$i] = $LettrePlusNomClimat[$i][1];
            }
        }
    }
    $Voir = $_GET['Voir'] ?? null;
    $nommé = false;
    if (!isset($NbRowInTable)) {
        $NbRowInTable = 0;
    }
    /* Pour nommer les climats
    echo $user;
    $a = 0;
    $Nommage = array();
    print_r($_GET);
    echo '<br />';
    print_r($id);
    for ($i = 0; $i < end($id); $i++) {
        $NomAverifierExistence = strip_tags($_GET['nom' . $id[$i]]);
        if (isset($NomAverifierExistence)) {
            $Nommage[$a] =  str_replace("'", "’", $NomAverifierExistence);
            $sqlQuery = 'UPDATE `climat` SET `NOMgenerique` = :NOMgenerique WHERE `COMPTEclef` = :id';
            $SaveStatement = $db->prepare($sqlQuery);
            echo '<br /> balise2';
            try {
                $SaveStatement->execute(['id' => $user, 'NOMgenerique' => $Nommage[$a]]);
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
        }
        $a++;
    }
    if ($nommé) {
        header('Location: http://localhost/testClimat-version_locale/userThingsTer.php');
    }
    //téléchargement des données
    include('outils/download_Climat.php');
    */
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
                    echo '<p>Pour supprimer votre compte et effacer toutes vos données associé merci d\'aller à la page de <a href="userThingsCompte.php">gestion du compte</a> </p>';
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
						<td><form id="nommer" name="nommer" method="get" action="userThingsTer.php"><input type="text" placeholder="" id="nom' . $id[$i] . '" name="nom' . $id[$i] . '" required><input type="submit" value="Nommer' . $id[$i] . '" /></form></td>
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
                    <option class="bouton" value="0-all">Tout</option>
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
                <!--<label for="version">version</label>
                <select name="version" id="version" required>
                    <option class="bouton" value="">--</option>
                    <option class="bouton" value="compact_colonne">compact_colonne</option>
                    <option class="bouton" value="compact_ligne">compact_ligne</option>
                    <option class="bouton" value="long">long</option>
                </select>
                <label for="format">format</label>
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