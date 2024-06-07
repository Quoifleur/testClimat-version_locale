<?php
$Te = [3.4, 4.8, 8.4, 11.4, 15.8, 19.4, 22.1, 21.6, 17.6, 13.4, 7.5, 4.3];
$Pr = [47.2, 44.1, 50.4, 74.9, 90.8, 75.6, 63.7, 62, 87.5, 98.6, 81.9, 55.2];
/*Déclaration des variables*/
$Nord = true;
$hémisphère = 'Nord';
$LettreClimat1 = 'tempéré ';
$LettreClimat2 = 'humide ';
$LettreClimat3 = 'été frais et hivers froid';
$NomClimat1 = 'C';
$NomClimat2 = 'f';
$NomClimat3 = 'c';
$Tmax = 22.1;
$Tmin = 3.4;
$Tannuelle = 12.475;
$Pmax = 98.6;
$Psmax = 90.8;
$Pwmax = 98.6;
$Pmin = 44.1;
$Psmin = 62;
$Pwmin = 44.1;
$Pannuelle = 831.9;
$Phiver = 377.4;
$Pété = 107.9;

$PTH = 24.95;
$NbAride = 0
?>
<!DOCTYPE html>
<html>

<head>

	<head>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {
				'packages': ['corechart']
			});
			google.charts.setOnLoadCallback(drawVisualization);

			function drawVisualization() {
				// Some raw data (not necessarily accurate)
				var data = google.visualization.arrayToDataTable([
					['Month', 'Précipitation  (en mm)', 'Température  (en °C)'],
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
					title: 'Diagramme hombrothermique',
					vAxis: {
						title: ''
					},
					hAxis: {
						title: 'Mois'
					},
					seriesType: 'bars',
					series: {
						1: {
							type: 'line'
						}
					}
				};

				var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		</script>
	</head>
	<?php include('naviagation/head.php'); ?>
	<title>testClimatResultat</title>
</head>

<body>
	<?php include('navigation/header.php'); ?>
	<?php include('navigation/nav.php'); ?>
	<main>
		<section class="section_intro">
			<h1>Exemple</h1>
			<p>Exemple d'un résultat obtenue via test climat pour des données provenant de la ville de Lyon </p>
		</section>
		<section class="section_milieu">
			<div>
				<br /><a href="index.php">Rentrer de nouvelles valeurs / Revenir à l'accueil.</a>
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
					<th scope="row">Mois Aride?</th>
				</tr>
				<tr>
					<th class="month" scope="row">Janvier</th>
					<td><?php echo $Te[0] ?></td>
					<td><?php echo $Pr[0] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Février</th>
					<td><?php echo $Te[1] ?></td>
					<td><?php echo $Pr[1] ?></td>
					<td>non</td>
				<tr>
					<th class="month" scope="row">Mars</th>
					<td><?php echo $Te[2] ?></td>
					<td><?php echo $Pr[2] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Avril</th>
					<td><?php echo $Te[3] ?></td>
					<td><?php echo $Pr[3] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Mai</th>
					<td><?php echo $Te[4] ?></td>
					<td><?php echo $Pr[4] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Juin</th>
					<td><?php echo $Te[5] ?></td>
					<td><?php echo $Pr[5] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Juillet</th>
					<td><?php echo $Te[6] ?></td>
					<td><?php echo $Pr[6] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Aout</th>
					<td><?php echo $Te[7] ?></td>
					<td><?php echo $Pr[7] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Septembre</th>
					<td><?php echo $Te[8] ?></td>
					<td><?php echo $Pr[8] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Octobre</th>
					<td><?php echo $Te[9] ?></td>
					<td><?php echo $Pr[9] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Novembre</th>
					<td><?php echo $Te[10] ?></td>
					<td><?php echo $Pr[10] ?></td>
					<td>non</td>
				</tr>
				<tr>
					<th class="month" scope="row">Décenbre</th>
					<td><?php echo $Te[11] ?></td>
					<td><?php echo $Pr[11] ?></td>
					<td>non</td>
				</tr>
			</table>
			<p class="legende">
				Pour détermier si un mois est aride nous utilisons l'indice Gaussen.
				<br /> Cette indice est calculé ainsi : Un mois est aride si P < 2T. </p>
		</section>
		<section class="section_fin">
			<p>
				<?php
				/*Annonce du climat trouvé */
				/*echo 'Variable ClimatTrouvé : ' . $ClimatTouvé;*/
				echo /*'<br /> Variable Nord et */ 'Hémisphère : '/* . $Nord . ' ; '*/ . $hémisphère;
				echo '<br /> Le climat trouvé est le suivant : <b>' . $NomClimat1 . $NomClimat2 . $NomClimat3 . '</b>; Lettes associées : <b>' . $LettreClimat1 . $LettreClimat2 . $LettreClimat3 . '</b>';

				/*Annonce des variables calculé */
				echo '<br /><br /> Variables Tmax, Tmin et Tmannuelle : ' . $Tmax . '  ' . $Tmin . ' ; ' . $Tannuelle;
				echo '<br /><br /> Variables Pmax, Psmax et Pwmax : ' . $Pmax . ' ; ' . $Psmax . ' ; ' . $Pwmax;
				echo '<br /> Variables Pmin, Psmin et Pwmin : ' . $Pmin . ' ; ' . $Psmin . ' ; ' . $Pwmin;
				echo '<br /> Variables Pannuelle, Phiver et Pété : ' . $Pannuelle . ' ; ' . $Phiver . ' ; ' . $Pété;
				echo '<br /><br />' . /*'Variables PTHTrouvé et'*/ 'PTH : '/* . $PTHTrouvé . ' ; '*/ . $PTH;
				/*echo '<br /><br /> Variables b, i et Compte : ' . $b . ' ; ' . $i . ' ; ' . $Compte;*/
				echo '<br /><br /> Nombre de mois aride : ' . $NbAride;
				?>
			</p>
			<p>
			<div id="chart_div" style="width: 900px; height: 500px;"></div>
			D'après le tableau de valeurs ci-dessus.
			</p>
		</section>
	</main>
	<footer>
		<?php include('navigation/footer.php'); ?>
	</footer>
</body>

</html>