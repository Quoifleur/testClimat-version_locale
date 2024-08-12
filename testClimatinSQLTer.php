<?php
session_start();
//echo $_SESSION['nom'] . '<br />';
//echo $_COOKIE['user'] . '<br />';
try {
    $db = new PDO('mysql:host=localhost;dbname=testclimat;charset=utf8', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],);
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}
function NettoyageString($string)
{
    $string = strip_tags($string);
    $string = str_replace("'", "’", strip_tags($string));
    $string = str_replace('"', '“', $string);
    $string = str_replace('<', '«', $string);
    $string = str_replace('>', '»', $string);
    return $string;
}
$user = strip_tags($_COOKIE['logged']);
$visibilite = 0;
/*
$sqlQuery = 'CREATE TABLE IF NOT EXISTS ' . $user . '(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `COMPTEclef` varchar(64) DEFAULT NULL,
    `COMPTEvisibilite` tinyint(1) DEFAULT \'0\',
    `AC` varchar(32) DEFAULT NULL,
    `SAVE` int(1) DEFAULT NULL,
    `RAM` int(16) DEFAULT NULL,
    `DATEcollecte` date DEFAULT NULL,
    `DATEentre` date DEFAULT NULL,
    `TEMPORALITEperiode` varchar(9) DEFAULT NULL,
    `TEMPORALITEmois` varchar(128) DEFAULT NULL,
    `TEMPORALITEsaison` varchar(24) DEFAULT NULL,
    `NOMlocalisation` varchar(32) DEFAULT NULL,
    `NOMgenerique` varchar(32) DEFAULT NULL,
    `POSITIONhemisphere` varchar(8) DEFAULT NULL,
    `POSITIONx` decimal(20,20) DEFAULT NULL,
    `POSITIONy` decimal(20,20) DEFAULT NULL,
    `POSITIONz` decimal(20,20) DEFAULT NULL,
    `NORMALEte` varchar(256) DEFAULT NULL,
    `NORMALEpr` varchar(256) DEFAULT NULL,
    `NORMALE2` varchar(256) DEFAULT NULL,
    `NORMALE3` varchar(256) DEFAULT NULL,
    `NORMALE4` varchar(256) DEFAULT NULL,
    `RESULTATkoge` varchar(256) DEFAULT NULL,
    `RESULTATgaus` varchar(256) DEFAULT NULL,
    `RESULTATmart` varchar(256) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ';

$statement = $db->prepare($sqlQuery);
$statement->execute([]);
*/
//Tableau des mois 
$month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

//Récupération des valeurs.
//POSITION
$Px = $_POST['PXc'] ? strip_tags($_POST['PXc']) : null;
$PY = $_POST['PYc'] ? strip_tags($_POST['PYc']) : null;
$PZ = $_POST['PZc'] ? strip_tags($_POST['PZc']) : null;
$Hémisphère = $_POST['hémisphère'];
//NORMALE CLIMATIQUE
if (isset($_POST['Tec']) && isset($_POST['Prc'])) {
    $Te = explode(",", strip_tags($_POST['Tec']));
    $Pr = explode(",", strip_tags($_POST['Prc']));
} else {
    $Te = [strip_tags($_POST['TM1']), strip_tags($_POST['TM2']), strip_tags($_POST['TM3']), strip_tags($_POST['TM4']), strip_tags($_POST['TM5']), strip_tags($_POST['TM6']), strip_tags($_POST['TM7']), strip_tags($_POST['TM8']), strip_tags($_POST['TM9']), strip_tags($_POST['TM10']), strip_tags($_POST['TM11']), strip_tags($_POST['TM12'])];
    $Pr = [strip_tags($_POST['PM1']), strip_tags($_POST['PM2']), strip_tags($_POST['PM3']), strip_tags($_POST['PM4']), strip_tags($_POST['PM5']), strip_tags($_POST['PM6']), strip_tags($_POST['PM7']), strip_tags($_POST['PM8']), strip_tags($_POST['PM9']), strip_tags($_POST['PM10']), strip_tags($_POST['PM11']), strip_tags($_POST['PM12'])];
}
for ($i = 0; $i < 11; $i++) {
    if (!is_numeric($Te[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        echo '<br /><br />L\'une des valeurs saisi n\'est pas un nombre. <br />Merci de saisir les valeurs sous cette forme, par exemple : -2.6,-2.0,2.3,8.3,12.7,17.2,21.1,21.1,17.1,12.0,5.3,0.1 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
    if (!isset($Te[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        echo '<br /><br />L\'une des valeurs saisi manque. <br />Merci de bien saisir 12 valeurs sous cette forme, par exemple : -2.6,-2.0,2.3,8.3,12.7,17.2,21.1,21.1,17.1,12.0,5.3,0.1 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
}
for ($i = 0; $i <= 11; $i++) {
    if (!is_numeric($Pr[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        '<br /><br />L\'une des valeurs entré n\'est pas un nombre. <br />Merci d\'entré les valeurs sous cette forme, par exemple : 41.4,92.4,89.9,63.0,64.9,42.4,14.1,6.7,41.0,56.6,63.6,58.0 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
    if (!isset($Pr[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        echo '<br /><br />L\'une des valeurs saisi manque. <br />Merci de bien saisir 12 valeurs sous cette forme, par exemple : 41.4,92.4,89.9,63.0,64.9,42.4,14.1,6.7,41.0,56.6,63.6,58.0 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
}
echo 'Te (température en °C)';
for ($i = 0; $i < 12; $i++) {
    echo '<br />Te[' . $i . '] >>> ' . $Te[$i];
}
echo '<br /><br /> Pr (précipitation en mm)';
for ($i = 0; $i < 12; $i++) {
    echo '<br />Pr[' . $i . ']  >>> ' . $Pr[$i];
}
echo '<br /><br />';
/* Détermination de l'hémisphère */
if ($Hémisphère == 'Nord') {
    $Nord = true;
    $Saison[0] = 'W';
    $Saison[1] = 'W';
    $Saison[2] = 'W';
    $Saison[9] = 'W';
    $Saison[10] = 'W';
    $Saison[11] = 'W';

    $Saison[3] = 'S';
    $Saison[4] = 'S';
    $Saison[5] = 'S';
    $Saison[6] = 'S';
    $Saison[7] = 'S';
    $Saison[8] = 'S';
} elseif ($Hémisphère == 'Sud') {
    $Nord = false;
    $Saison[3] = 'W';
    $Saison[4] = 'W';
    $Saison[5] = 'W';
    $Saison[6] = 'W';
    $Saison[7] = 'W';
    $Saison[8] = 'W';

    $Saison[0] = 'S';
    $Saison[1] = 'S';
    $Saison[2] = 'S';
    $Saison[9] = 'S';
    $Saison[10] = 'S';
    $Saison[11] = 'S';
}
/*Tableau des températures en été en °C (En fonction de l'hémisphère l'hiver et l'été sont inversés*/
if ($Nord) {
    $STe = [$Te[3], $Te[4], $Te[5], $Te[6], $Te[7], $Te[8]];
} else {
    $STe = [$Te[0], $Te[1], $Te[2], $Te[9], $Te[10], $Te[11]];
}
if ($Nord) {
    $WPr = [$Pr[0], $Pr[1], $Pr[2], $Pr[9], $Pr[10], $Pr[11]]; /*Tableau des précipitation des mois d'hiver en mm*/
    $SPr = [$Pr[3], $Pr[4], $Pr[5], $Pr[6], $Pr[7], $Pr[8]]; /*Tableau des précipitation des mois d'été en mm*/
} else {
    $SPr = [$Pr[0], $Pr[1], $Pr[2], $Pr[9], $Pr[10], $Pr[11]]; /*Tableau des précipitation des mois d'hiver (de l'hémisphère sud) en mm*/
    $WPr = [$Pr[3], $Pr[4], $Pr[5], $Pr[6], $Pr[7], $Pr[8]]; /*Tableau des précipitation des mois d'été (de l'hémisphère sud) en mm*/
}
echo 'STe (température en °C)';
for ($i = 0; $i < 6; $i++) {
    echo '<br />STe[' . $i . '] >>> ' . $STe[$i];
}
echo '<br /><br /> SPr & WPr (précipitation en mm)';
for ($i = 0; $i < 6; $i++) {
    echo '<br />SPr[' . $i . ']  >>> ' . $SPr[$i];
}
for ($i = 0; $i < 6; $i++) {
    echo '<br />WPr[' . $i . ']  >>> ' . $WPr[$i];
}
echo '<br /><br />';
/*Calcule des variables */
$NomClimat1Trouvé = false;
$ClimatTrouvé = false;
$PTHTrouvé = false;

$b = 0;
$i = 0;
$Compte = 0;

$PTH = 0;
$Ia = 0;

$Tmax = max($Te);
$Tmin = min($Te);
$Tannuelle = array_sum($Te) / 12;

$Pmax = max($Pr);
$Psmax = max($SPr);
$Pwmax = max($WPr);
$Pmin = min($Pr);
$Psmin = min($SPr);
$Pwmin = min($WPr);
$Pannuelle = array_sum($Pr);

$Phiver = array_sum($SPr);
$Pété = array_sum($WPr);

/*Calcule de l'indice de Gaussen */
/*Tableau des mois arides */
$Ar = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
for ($i = 0; $i < 12; $i++) {
    if ($Pr[$i] < 2 * $Te[$i]) {
        $Ar[$i] = 1;
    }
}
echo 'Mois aride';
for ($i = 0; $i < 12; $i++) {
    echo '<br />Ar[' . $i . '] >>> ' . $Ar[$i];
}
echo '<br /><br />';
/*Calcule de l'indice de Martonne */
$Ia = $Pannuelle / ($Tannuelle + 10); /* Pour l'année*/
$Im = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
for ($i = 0; $i < 12; $i++) {
    $Im[$i] = 12 * $Pr[$i] / ($Te[$i] + 10);
}
echo 'Martonne';
for ($i = 0; $i < 12; $i++) {
    echo '<br />Im[' . $i . '] >>> ' . $Im[$i];
}
echo '<br /><br />';
/*Détermination de la variable b (il s'agit d'un régime thermique possible pour les climats tempérées) */
for ($i = 0; $i < 12; $i++) {
    if ($Te[$i] > 10) {
        $Compte++;
    }
}
if ($Compte >= 4) {
    $b = 1;
} else {
    $b = 0;
}
/*Détermination du PTH */
if (($Pannuelle * (2 / 3)) >= $Phiver) {
    $PTH = $Tannuelle * 2;
    $PTHTrouvé = true;
}
if (!$PTHTrouvé && ($Pannuelle * (2 / 3)) >= $Pété) {
    $PTH = ($Tannuelle * 2) + 28;
    $PTHTrouvé = true;
}
if (!$PTHTrouvé) {
    $PTH = ($Tannuelle * 2) + 14;
    $PTHTrouvé = true;
}
/*Détermination du climat (testClimat)*/
if ($Tmax < 10) {
    $LettreClimat1 = "E";
    $NomClimat1 = "polaire ";
    if ($Tmax >= 0 && $Tmax < 10) {
        $LettreClimat2 = "t";
        $NomClimat2 = " de toundra ";
        $ClimatTrouvé = true;
    }
    if ($Tmax <= 0 && !$ClimatTrouvé) {
        $LettreClimat2 = "f";
        $NomClimat2 = "glacier ";
        $ClimatTrouvé = true;
    }
}
if ($Pannuelle < 10 * $PTH && !$ClimatTrouvé) {
    $LettreClimat1 = "B";
    $NomClimat1 = " aride ";

    if ($Pannuelle > 5 * $PTH) {
        $LettreClimat2 = "s";
        $NomClimat2 = "de steppe ";

        if ($Tannuelle >= 18 && !$ClimatTrouvé) {
            $LettreClimat3 = "h";
            $NomClimat3 = "chaud ";
            $ClimatTrouvé = true;
        }
        if (!$ClimatTrouvé) {
            $LettreClimat3 = "k";
            $NomClimat3 = "froid ";
            $ClimatTrouvé = true;
        }
    }
    if ($Pannuelle <= 5 * $PTH && !$ClimatTrouvé) {
        $LettreClimat2 = "w";
        $NomClimat2 = "de désert ";

        if ($Tannuelle >= 18) {
            $LettreClimat3 = "h";
            $NomClimat3 = "chaud ";
            $ClimatTrouvé = true;
        }
        if ($Tannuelle < 18 && !$ClimatTrouvé) {
            $LettreClimat3 = "k";
            $NomClimat3 = "froid ";
            $ClimatTrouvé = true;
        }
    }
}
if ($Tmin >= 18 && !$ClimatTrouvé) {
    $LettreClimat1 = "A";
    $NomClimat1 = "équatorial ";

    if ($Pmin >= 60) {
        $LettreClimat2 = "f";
        $LettreClimat3 = "";
        $NomClimat2 = "avec forêt humide équatoriale ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
    if ($Pannuelle >= 25 * (100 - $Pmin) && !$ClimatTrouvé) {
        $LettreClimat2 = "m";
        $LettreClimat3 = "";
        $NomClimat2 = "avec mousson équatoriale ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
    if ($Psmin < 60 && !$ClimatTrouvé) {
        $LettreClimat2 = "s";
        $LettreClimat3 = "";
        $NomClimat2 = "avec savane équatoriale avec été sec ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
    if ($Pwmin < 60 && !$ClimatTrouvé) {
        $LettreClimat2 = "w";
        $LettreClimat3 = "";
        $NomClimat2 = "avec savane équatoriale avec hiver sec ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
}
if ($Tmin > -3 && $Tmin < 18 && !$ClimatTrouvé) {
    $LettreClimat1 = "C";
    $NomClimat1 = " tempéré ";
    $NomClimat1Trouvé = true;
}

if ($Tmin <= -3 && !$ClimatTrouvé && !$NomClimat1Trouvé) {
    $LettreClimat1 = "D";
    $NomClimat1 = " continental neigeux ";
}
if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
    if ($Psmin < $Pwmin) {
        if ($Pwmax > (3 * $Psmin) && $Psmin < 40) {
            $LettreClimat2 = "s";
            $NomClimat2 = "avec été sec et hiver pluvieux ";

            if ($LettreClimat1 == "D") {
                if ($Tmin <= -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "d";
                    $NomClimat3 = "avec un été et hiver très froid";
                    $ClimatTrouvé = true;
                }
            }
            if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
                if ($Tmax >= 22 && !$ClimatTrouvé) {
                    $LettreClimat3 = "a";
                    $NomClimat3 = "avec un été chaud ";
                    $ClimatTrouvé = true;
                }
                if ($b == 1 && !$ClimatTrouvé) {
                    $LettreClimat3 = "b";
                    $NomClimat3 = "avec un été tempéré ";
                    $ClimatTrouvé = true;
                }
                if ($Tmin > -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "c";
                    $NomClimat3 = "avec un été frais et hiver froid ";
                    $ClimatTrouvé = true;
                }
            }
        }
    }
    if (!$ClimatTrouvé) {
        if ($Pwmin < $Psmin && $Psmax > 10 * $Pwmin) {
            $LettreClimat2 = "w";
            $NomClimat2 = "avec hiver sec et été pluvieux ";

            if ($LettreClimat1 == "D") {
                if ($Tmin <= -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "d";
                    $NomClimat3 = "avec un été et hiver très froid ";
                    $ClimatTrouvé = true;
                }
            }
            if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
                if ($Tmax >= 22 && !$ClimatTrouvé) {
                    $LettreClimat3 = "a";
                    $NomClimat3 = "avec un été chaud ";
                    $ClimatTrouvé = true;
                }
                if ($b == 1 && !$ClimatTrouvé) {
                    $LettreClimat3 = "b";
                    $NomClimat3 = "avec un été tempéré ";
                    $ClimatTrouvé = true;
                }
                if ($Tmin > -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "c";
                    $NomClimat3 = "avec un été frais et hiver froid ";
                    $ClimatTrouvé = true;
                }
            }
        }
    }
    if ($ClimatTrouvé == false) {
        $LettreClimat2 = "f";
        $NomClimat2 = "humide ";
        if ($LettreClimat1 == "D" && !$ClimatTrouvé) {
            if ($Tmin <= -38) {
                $LettreClimat3 = "d";
                $NomClimat3 = "été et hivers très froid ";
                $ClimatTrouvé = true;
            }
        }
        if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
            if ($Tmax >= 22) {
                $LettreClimat3 = "a";
                $NomClimat3 = "été chaud ";
                $ClimatTrouvé = true;
            }
            if ($b == 1 && !$ClimatTrouvé) {
                $LettreClimat3 = "b";
                $NomClimat3 = "été tempéré ";
                $ClimatTrouvé = true;
            }
            if ($Tmin > -38 && !$ClimatTrouvé) {
                $LettreClimat3 = "c";
                $NomClimat3 = "été frais et hivers froid ";
                $ClimatTrouvé = true;
            }
        }
    }
}
/*Débug */
echo '<br />ClimatTrouvé >>> ' . $ClimatTrouvé;
echo '<br />PHTrouvé >>> ' . $PTHTrouvé;
echo '<br />';
echo '<br />b >>> ' . $b;
echo '<br />i >>> ' . $i;
echo '<br />Compte >>> '  . $Compte;
echo '<br />';
echo '<br />PTH >>> '  . $PTH;
echo '<br />Ia >>> '  . $Ia;
echo '<br />';
echo '<br />Tmax >>> '  . $Tmax;
echo '<br />Tmin >>> '   . $Tmin;
echo '<br />Tannuelle >>> '  . $Tannuelle;
echo '<br />';
echo '<br />Pmax >>> '   . $Pmax;
echo '<br />Psmax >>> '   . $Psmax;
echo '<br />Pwmax >>> '   . $Pwmax;
echo '<br />Pmin >>> '   . $Pmin;
echo '<br />Psmin >>> '   . $Psmin;
echo '<br />Pwmin >>> '   . $Pwmin;
echo '<br />Pannuelle >>> '   . $Pannuelle;
echo '<br />';
echo '<br />Phiver >>> '   . $Phiver;
echo '<br />Pété >>> '   . $Pété;
echo '<br /><br />';
echo $NomClimat = $NomClimat1 . $NomClimat2 . $NomClimat3;
echo $LettreClimat = $LettreClimat1 . $LettreClimat2 . $LettreClimat3;
$climatKG = $LettreClimat . ', ' . $NomClimat;
/*
//nettoyage de la table
$deleteStatement = $db->prepare('DELETE FROM ' . $user . ' WHERE Ram = 0 OR Ram = 3');
$deleteStatement->execute([]) or die(print_r($db->errorInfo()));
//Save (ou non)
$SaveStatement = $db->prepare('UPDATE ' . $user . ' SET Save = Save+1, Ram = 2 WHERE Ram = 1 ');
$SaveStatement->execute([]) or die(print_r($db->errorInfo()));

// Ecriture de la requête

$sqlQuery = 'INSERT INTO ' . $user . '(Mois, Saison, Te, Pr, Hm, Gaussen, Martonne, NomClimat, LettreClimat) VALUES (:Mois, :Saison, :Te, :Pr, :Hm, :Gaussen, :Martonne, :NomClimat, :LettreClimat)';
$insertClimat = $db->prepare($sqlQuery);

// Exécution ! Les valeurs est maintenant en base de données
for ($i = 0; $i < 12; $i++) {
    $insertClimat->execute(array(':Mois' => $month[$i], ':Saison' => $Saison[$i], ':Te' => $Te[$i], ':Pr' => $Pr[$i], ':Hm' => $Hémisphère, ':Gaussen' => $Ar[$i], ':Martonne' => $Im[$i], ':NomClimat' => $NomClimat, ':LettreClimat' => $LettreClimat));
}
*/
$stringMonth = '';
$stringSaison = '';
$stringPr = '';
$stringTe = '';
$stringAr = '';
$stringIm = '';

for ($i = 0; $i < 11; $i++) {
    $stringMonth .= $month[$i] . ',';
    $stringSaison .= $Saison[$i] . ',';
    $stringPr .= $Pr[$i] . ',';
    $stringTe .= $Te[$i] . ',';
    $stringAr .= $Ar[$i] . ',';
    $stringIm .= $Im[$i] . ',';
}
$i = 11;
$stringMonth .= $month[$i];
$stringSaison .= $Saison[$i];
$stringPr .= $Pr[$i];
$stringTe .= $Te[$i];
$stringAr .= $Ar[$i];
$stringIm .= $Im[$i];
$save = 1;
$ram = 1;
echo '<br />Hémisphère >>> ' . $Hémisphère;
echo '<br />Px >>> ' . $Px;
echo '<br />PY >>> ' . $PY;
echo '<br />PZ >>> ' . $PZ;
echo '<br />climateKG >>> ' . $climatKG;
echo '<br />stringMonth >>> ' . $stringMonth;
echo '<br />stringSaison >>> ' . $stringSaison;
echo '<br />stringPr >>> ' . $stringPr;
echo '<br />stringTe >>> ' . $stringTe;
echo '<br />stringAr >>> ' . $stringAr;
echo '<br />stringIm >>> ' . $stringIm;
echo '<br />';
echo '<br />$save >>> ' . $save;
echo '<br />$ram >>> ' . $ram;
echo '<br />';
echo '<br />$_SESSION[nom] >>> ' . $_SESSION['nom'];
echo '<br />$_COOKIE[logged] >>> ' . $_COOKIE['logged'];

//Save des anciennes valeurs
//$SaveStatement = $db->prepare('UPDATE ' . $user . ' SET Save = Save+1');
//$SaveStatement->execute([]) or die(print_r($db->errorInfo()));
//Ajout des nouvelles valeurs
$sqlQuery = 'INSERT INTO  `climat` (COMPTEclef, COMPTEvisibilite, DATEentre, TEMPORALITEmois, TEMPORALITEsaison, POSITIONhemisphere, POSITIONx, POSITIONy, POSITIONz, NORMALEte, NORMALEpr, RESULTATkoge, RESULTATgaus, RESULTATmart) VALUES (:COMPTEclef, :COMPTEvisibilite,  :DATEentre, :TEMPORALITEmois, :TEMPORALITEsaison, :POSITIONhemisphere, :POSITIONx, :POSITIONy, :POSITIONz, :NORMALEte, :NORMALEpr, :RESULTATkoge, :RESULTATgaus, :RESULTATmart)';
echo '<br /> balise1';
echo '<br /> sqlQuery >>> ' . $sqlQuery;
$SaveStatement = $db->prepare($sqlQuery);
echo '<br /> balise2';
try {
    $SaveStatement->execute(['COMPTEclef' => $user, 'COMPTEvisibilite' => $visibilite, 'DATEentre' => date('Y-m-d'), 'TEMPORALITEmois' => $stringMonth, 'TEMPORALITEsaison' => $stringSaison, 'POSITIONhemisphere' => $Hémisphère, 'POSITIONx' => $Px, 'POSITIONy' => $PY, 'POSITIONz' => $PZ,  'NORMALEte' => $stringTe, 'NORMALEpr' => $stringPr, 'RESULTATkoge' => $climatKG, 'RESULTATgaus' => $stringAr, 'RESULTATmart' => $stringIm]);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
echo '<br /> balise3';
header("Location: testClimatResultatTerTer.php");
exit;
