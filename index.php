<?php
session_start();
$LienVersTraitementDesClimats = '';
if (isset($_COOKIE['logged'])) {
	$LienVersTraitementDesClimats = 'testClimatinSQLTer.php';
	$_SESSION['nom'] = $_COOKIE['logged'];
} else {
	$LienVersTraitementDesClimats = 'testClimatResultatsanscokiees.php';
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php include('navigation/head.php'); ?>
	<title>testClimat</title>
</head>

<body>
	<?php include('navigation/header.php'); ?>
	<?php include('navigation/nav.php'); ?>
	<main>
		<section class="section_intro">
			<h1>Bienvenue chez TestClimat !</h1>
			<?php
			echo $LienVersTraitementDesClimats . '<br />';
			echo $_SESSION['nom'] . '<br />';
			echo $_COOKIE['logged'] . '<br />';
			?>
			<p>Pour vous connecter ou pvous inscrire merci d'aller sur la <a href="userThingsLogin.php">page de connection et d'inscription</a></p>
			<p>
				TestClimat est un outil gratuit pour déterminer le climat (selon la classification de <a href="https://fr.wikipedia.org/wiki/Classification_de_K%C3%B6ppen">Köppen-Geiger</a>) d'un lieu donné à partir de données climatiques.
			</p>
		</section>
		<section class="section_milieu">
			<div class="hauteur">
				<form method='post' action="<?php echo $LienVersTraitementDesClimats; ?>">
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
						<tr>
							<th class="month" scope="row">Janvier</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM1" name="TM1" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM1" name="PM1" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Février</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM2" name="TM2" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM2" name="PM2" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Mars</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM3" name="TM3" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM3" name="PM3" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Avril</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM4" name="TM4" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM4" name="PM4" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Mai</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM5" name="TM5" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM5" name="PM5" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Juin</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM6" name="TM6" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM6" name="PM6" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Juillet</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM7" name="TM7" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM7" name="PM7" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Aout</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM8" name="TM8" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM8" name="PM8" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Septembre</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM9" name="TM9" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM9" name="PM9" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Octobre</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM10" name="TM10" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM10" name="PM10" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Novembre</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM11" name="TM11" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM11" name="PM11" maxlength="5" size="4" required></td>
						</tr>
						<tr>
							<th class="month" scope="row">Décenbre</th>
							<td><input type="number" placeholder="0" step="0.01" id="TM12" name="TM12" maxlength="5" size="4" required></td>
							<td><input type="number" placeholder="0" step="0.01" id="PM12" name="PM12" maxlength="5" size="4" required></td>
						</tr>
					</table>
					<div>
						<input type="submit" value="Envoyer">
					</div>
				</form>
			</div>
		</section>
		<section class="section_fin">
			<p>
			<h2>Ou dans les cadres ci-dessous : </h2>
			Le premier cadre est pour les températures, le second pour les précipitations.
			<br />Remplacer TM1 pour la valeur des températures de janvier, TM2 pour celles de février etc. De même pour les précipitations dans le deuxième cadre.
			<br />Les valeurs doivent être séparés par des virgules, merci d'écrire les valeurs décimals avec des points (Pour en savoir plus voir la rubrique <a href="testClimatAide.php">Aide</a>).
			</p>
			<form method='post' action="<?php echo $LienVersTraitementDesClimats; ?>" enctype='multipart/form-data'>
				<legend>*Les valeurs ont était récolté dans l'hémisphère :</legend>
				<div class="boiteHémisphère">
					<div class="">
						<input type="radio" id="Nord" name="hémisphère" value="Nord" checked>
						<label for="Nord">Nord</label>
					</div>
					<div class="">
						<input type="radio" id="Sud" name="hémisphère" value="Sud">
						<label for="Sud">Sud</label>
					</div>
					<div class="">
						<input type="text" placeholder="NOMlieux-dit,communes,département,..." id="NGc" name="NGc">
					</div>
					<div class="">
						<input type="text" placeholder="NOMstation" id="NSc" name="NSc">
					</div>
					<div class="">
						<input type="text" placeholder="*TM1,TM2,TM3,..." id="Tec" name="Tec" required>
					</div>
					<div class="">
						<input type="text" placeholder="*PM1,PM2,PM3,..." id="Prc" name="Prc" required>
					</div>
					<div class="">
						<input type="text" placeholder="NORMALEclimatique3" id="NC3c" name="NC3c">
					</div>
					<div class="">
						<input type="text" placeholder="NORMALEclimatique4" id="NC4c" name="NC4c">
					</div>
					<div class="">
						<input type="text" placeholder="NORMALEclimatique5" id="NC5c" name="NC5c">
					</div>
					<div class="">
						<input type="text" placeholder="POSITIONlongitude(x)-WGS 84" id="PXc" name="PXc">
					</div>
					<div class="">
						<input type="text" placeholder="POSITIONlattitude(y)-WGS 84" id="PYc" name="PYc">
					</div>
					<div class="">
						<input type="text" placeholder="POSITIONaltitude(z)-WGS 84" id="PZc" name="PZc">
					</div>
					<div class="">
						<input type="text" placeholder="ANNEE" id="TPc" name="TPc" minlength="4" maxlength="4">
					</div>
					<div class="box huit">
						<input type="submit" value="Envoyer">
					</div>
				</div>
			</form>
			<h3>Exemple</h3>
			<p>
				Exemple des normales climatique pour la ville de Lyon. Climat associé : Cfb.
			<ul>
				<li>hémisphère : NORD</li>
				<li>x:45.763, y:4.835</li>
				<li>Te(°C) : 3.2,3.8,7.5,11.2,15.1,19.4,21.4,21,17.1,12.9,7.4,4
				</li>
				<li>Pr(mm) : 75,62,64,87,95,87,81,81,95,103,107,78
				</li>
			</ul>
			Source des données, <a href="https://fr.climate-data.org/europe/france/rhone-alpes/lyon-67/">climate-data.org</a>.
			</p>
		</section>
	</main>
	<footer>
		<?php include('navigation/footer.php'); ?>
	</footer>
</body>

</html>