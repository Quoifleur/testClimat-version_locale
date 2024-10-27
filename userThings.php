<?php
session_start();
try {
    $db = new PDO('mysql:host=testcljclimat.mysql.db;dbname=testcljclimat;charset=utf8', 'testcljclimat', 'jG9JE9UJpT');
} catch (Exception $e) {
echo 'Erreur: ' . $e->getMessage();
    die();
}
$user = strip_tags($_COOKIE['user']);
$sqlQuery = "SHOW TABLES FROM testcljclimat LIKE '" . $user . "'";
$climatStatement = $db->prepare($sqlQuery);
$climatStatement->execute();
$table = $climatStatement->fetchAll();
if ($table != null) {
	$sqlQuery = 'SELECT * FROM ' . $_COOKIE['user'];
	// On récupère tout le contenu de la table données
	$climatStatement = $db->prepare($sqlQuery);
	$climatStatement->execute();
	$climat = $climatStatement->fetchAll();
	if (!empty($climat)) {
		foreach ($climat as $value) {
			$Nom[] = $value['Nom'];
			$Ram[] = $value['Ram'];
			$Save[] = $value['Save'];
			$month[] = $value['Mois'];
			$Saison[] = $value['Saison'];
			$Te[] = $value['Te'];
			$Pr[] = $value['Pr'];
			$hémisphère[] = $value['Hm'];
			$NomClimat[] = $value['NomClimat'];
			$LettreClimat[] = $value['LettreClimat'];
			$Ar[] = $value['Gaussen'];
			$Im[] = $value['Martonne'];
		}
		//print_r($Save);
		//Traitement des données :
		/*Calcule des variables */
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
				$Ar[$i] = true;
			} else {
				$Ar[$i] = false;
			}
		}
		if ($hémisphère == 'Nord') {
			$Nord = true;
		} elseif ($hémisphère == 'Sud') {
			$Nord = false;
		}
	}
	$sqlQuery = 'SELECT Save FROM ' . $user . ' WHERE Save >= 1';
	$LimitStatement = $db->prepare($sqlQuery);
	$LimitStatement->execute();
	$Limit = $LimitStatement->fetchAll();

	foreach ($Limit as $value) {
		$borne[] = $value['Save'];
	}
}

//print_r($TotalClimat);
$Voir = $_GET['Voir'] ?? null;
$a = 0;
$nommé = false;
//print_r($borne);
for ($i = 0; $i <= $borne[0]; $i++) {
	//echo '<br /> >>test';
	if (isset($_GET['nom' . $a])) {
		$Nommage[$a] =  str_replace("'", "’", strip_tags($_GET['nom' . $a]));
		if (isset($Nommage[$a])) {
			//print_r($Nommage);
			//echo '<br /> >>test1';
			$NOMStatement = $db->prepare("UPDATE " . $_COOKIE['user'] . " SET `Nom` = '" . $Nommage[$a] . "' WHERE `Save` = " . $i);
			$NOMStatement->execute() or die(print_r($db->errorInfo()));
			$nommé = true;
		}
	}
	$a++;
}
if ($nommé) {
	header('Location: https://testclimat.ovh/userThings.php');
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
				$ecritureSynthetiqueValeurMois[] = $month[$a];
				$ecritureSynthetiqueValeurTe[] = $Te[$a];
				$ecritureSynthetiqueValeurPr[] = $Pr[$a];
			}
		}
		$a++;
	}
}
$a = 0;
if ($downloadPossible) {
	if ($download[2] == 'long' || $download[1] == 'Tout les climats') {
		$downloadNom = 'SaveTestClimat,' . $download[1] . '-Complet.csv';
		$fichier = fopen($downloadNom, 'c+b');
		fwrite($fichier, $ecritureLegende);
		while (isset($ecriture[$a])) {
			fwrite($fichier, "\r\n");
			fwrite($fichier, $ecriture[$a]);
			$a++;
		}
	} else {
		$downloadNom = 'TestClimat,' . $download[1] . '-Compact.csv';
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
?>
<!DOCTYPE html>
<html>

<head>
	<?php include('head.php'); ?>
	<title>testClimat</title>
</head>

<body>
	<?php include('navigation/header.php'); ?>
	<?php include('navigation/nav.php'); ?>
	<main>
		<section class="section_intro">
			<h1>Climats sauvegardé(s).</h1>
			<p>
				Retrouvez dans cette pages les données que vous avez sauvegardé. Le sauvegarde se fait à partir d'un cookie généré par le navigateur. Cliquer ici pour la <a href="testClimatCookie.php">gestion du cookie</a>.
			</p>
		</section>
		<section class="section_milieu">
			<?php
			if ($table != null && !empty($climat)) {
				$a = 0;
				$i = 0;
				echo '<table>
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
				  </tr>';
				while ($Save[$i] > 0 && !null) {
					echo '
					  <tr>
						<th scope="row">' . $Save[$i] . '</th>
						<td><code>' . $Nom[$i] . '</code></td>
						<td><code>' . $NomClimat[$i] . '</code></td>
						<td><code>' . $LettreClimat[$i] . '</code></td>
						<td><code>' . $hémisphère[$i] . '</code></td>
						<td><form id="Save" name="Voir" method="get" action="testClimatResultatTerBisBis.php"> <input type="submit" name="Voir" value="Observer climat ' . $Save[$i] . '" /></form></td>
						<td><form id="nommer" name="nommer" method="get" action="userThings.php"><input type="text" placeholder="" id="nom' . $Save[$i] . '" name="nom' . $Save[$i] . '" required><input type="submit" value="Nommer" /></form></td>
					  </tr>
				    ';
					$a++;
					$i = $i + 12;
					/*echo 'Climat  : ' . ' , ' . $LettreClimat[$i] . '. Hémisphère :  ' . $hémisphère[$i] . '.<br />';
					echo ' <form id="Save" name="Voir" method="get" action="testClimatResultatTerBisBis.php">Voir les valeurs du climat
				<input type="submit" name="Voir" value="Observer climat ' . $Save[$i] . '" />
				</form>';*/
				}
				echo '</tbody></table><br />Utilisez <a href="index.php">TestClimat</a> pour sauvegarder des données.';
			} else {
				echo '<br />Utilisez <a href="index.php">TestClimat</a> pour sauvegarder des données.';
			}
			?>
		</section>
		<section class="section_fin">
			<h1>Téléchargement</h1>
			<p>
			<form id="Télécharger" method='get' action='userThings.php'>
				<label for="climat-select">Climat(s)</label>
				<select name="climat-select" id="climat-select" required>
					<option class="bouton" value="">--</option>
					<option class="bouton" value="all">Tout</option>
					<?php
					if ($table != null && !empty($climat)) {
						$a = 0;
						$i = 0;
						while ($Save[$i] > 0 && !null) {
							echo '<option class="bouton" value="' . $Save[$i] . '-' . $Nom[$i] . '">Climat' . $Save[$i] . '-' . $Nom[$i] . '</option>';
							$a++;
							$i = $i + 12;
						}
					} else {
						echo '<br />Utilisez <a href="index.php">TestClimat</a> pour télécharger des données.';
					} ?>
				</select>
				<label for="version">version</label>
				<select name="version" id="version" required>
					<option class="bouton" value="">--</option>
					<option class="bouton" value="compact">compact</option>
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
	<footer>
		<?php include('navigation/footer.php'); ?>
	</footer>
</body>

</html>
