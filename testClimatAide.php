<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<?php include('navigation/head.php'); ?>
	<title>testClimat</title>
</head>

<body>
	<?php include('navigation/header.php'); ?>
	<?php include('navigation/nav.php'); ?>
	<?php include('navigation/aside.php'); ?>
	<main class="containeur">
		<section class="section_intro">
			<div class="attention">
				<div class="attention_titre">Attention aux cookies !</div>
				Si vous arrivez sur une page blanche après utilisation de testClimat, merci de bien activer les cookies pour TestClimat. En effet, TestClimat utilise les cookies pour pouvoir fonctionner.<br /><br /> Si le problème persiste, merci de nous contacter.
			</div>
			<h1 id="section-">Fonctionnement de testClimat</h1>
			<h2 id="section-1">Présentation</h2>
			<p>Le terme « testClimat » peut désigner le site internet mais aussi le script qui permet de déterminer les climats. Ce dernier représente finalement qu’une petite partie du site et est disponible en python sur mon <a href="https://github.com/Quoifleur/testClimat">github</a> (Nb. La version du script dans le site est actuellement codée en PHP mais il est prévu qu’il soit remplacé par la version python). Pour ce qui est du site, celui-ci est codé en PHP et est lié avec une base de données MySQL pour certaines fonctionnalités. Enfin, le site est composé de plusieurs pages qui ont toutes une fonction précise.</p>
			<h2 id="section-2">Utilisation</h2>
			<p>La page d’accueil permet de rentrer les données (les normales climatiques ainsi que l’hémisphère). Puis l’utilisateur est redirigé vers une deuxième page qui traite les données c’est à que le script testClimat est exécuté. C’est-à-dire que c’est sur cette page que les données sont traitées pour en dégager des indices (moyennes climatiques, plus hautes valeurs de précipitation et de température en été et hiver) permettant l’exécution d’opération logique permettant d’en dégager un climat associé mais aussi différents indices que l’aridité (ou non) de chaque mois.
				<br /> Enfin l’utilisateur est redirigé vers une troisième page lui permettant de visualiser les résultats issus du script. Sur cette page il est possible de sauvegarder les résultats qui sont référencé dans la page <a href="userThingsTer.php">compte</a> du site (l’accès à la page est désactivé si vous avez désactivé les cookies).
			</p>
			<div class="attention">
				<div class="attention_titre">Attention</div>
				Attention, pour des raisons techniques la sauvegarde du climat souhaité n’est référencée qu’après une nouvelle utilisation du script testClimat.
			</div>
			<h2 id="section-3">A propos de la base de données et des cookies</h2>
			<p>Si les cookies ont été activé c’est après l’exécution du script les données ainsi que le climat et les différents indices obtenues sont insérées dans une table de la base de données MySQL lié au site TestClimat. C’est aussi à ce moment que TestClimat met à jour la table de l’utilisateur comme (dé)sauvegarde de données précédentes</p>
			<p>La base de données est composée de plusieurs table, chaque utilisateur est associé à une table (et une seule) et ne peut accéder qu’à celle-ci. Dans celle-ci les données climatiques sont référencées si l’utilisateur a décidé de sauvegarder le climat.</p>
			<div class="A_noter">
				<div class="A_noter_titre">A noter</div>
				<p>Pour des raisons techniques, les données issus de la dernière recherche sont toujours sauvegardées dans la table de l’utilisateur même si celui-ci n’a pas choisi de les sauvegarder. Ces résultats sont effacés dès que l’utilisateur réutilise le script testClimat. Par conséquent si vous vouliez sauvegarder ce dernier climat mais que vous aviez perdu la page, il vous suffit de saisir dans la barre de recherche de votre navigateur l’adresse de la page de résultat pour les retrouver et ainsi les sauvegarder.</p>
			</div>
			<br />
			<div class="attention">
				<div class="attention_titre">Attention</div>
				<p>L’utilisateur peut faire le choix de supprimer la table qu’il lui a été associé. Notez que toute suppression est définitive et que votre cookie sera supprimé par la même occasion. Attention, si vous réutilisez testClimat par la suite sans avoir désactivé les cookies pour le site, une nouvelle table dans la base de données vous sera associée.</p>
			</div>
		</section>
		<section class="section_milieu">
			<h1 id="section-4">Saisie des valeurs</h1>
			<p>Les valeurs doivent être écrites selon la norme anglo-saxonne, c'est-à-dire avec un point au lieu d'une virgule pour écrire des nombres décimaux.</p>
			<div class="attention">
				<div class="attention_titre">Attention</div>
				Si vous choisissez de rentrer vos données via le tableau chaque valeur ne doit pas dépasser 5 caractères (signe moins et points compris). Aucune limite de caractères n'est présente si vous rentrez vos données sous forme de liste, via la seconde méthode.
			</div>
			<h2 id="section-5">Exemples</h2>
			<ul>
				<li>Types de valeurs <b>acceptées</b> via <b>la première méthode</b> de saisi (via le tableau)</li>
				<ul>
					<li>0</li>
					<li>13</li>
					<li>555</li>
					<li>1097</li>
					<li>40976</li>
					<li>-423</li>
					<li>-24.5</li>
					<li>24.56</li>
					<li>1.467</li>
					<li>-0.12</li>
				</ul>
				<li>Types de valeurs <b>acceptées</b> via <b>la seconde</b> méthode de saisi</li>
				<ul>
					<li>Toutes les valeurs ci-dessus mais aussi,</li>
					<li>-24.56</li>
					<li>-0.12222</li>
					<li>145.987</li>
					<li>1243.001</li>
				</ul>
				<li>Types de saisi possible via la seconde méthode</li>
				<ul>
					<li>-2.6,-2.0,2.3,8.3,12.7,17.2,21.1,21.1,17.1,12.0,5.3,0.1</li>
					<li>41.4,92.4,89.9,63.0,64.9,42.4,14.1,6.7,41.0,56.6,63.6,58.0</li>
					<li>(Notez l'usage de virgules pour séparer les valeurs)</li>
				</ul>
				<br />
				<li>Types de valeurs toujours <b>refusées</b> (ou menant à des erreurs)</li>
				<ul>
					<li>24,5</li>
					<li>,122</li>
					<li>.122</li>
					<li>1.243,001</li>
					<li>1,243.001</li>
				</ul>
			</ul>
			</p>
			<h3 id="section-5">Exemple type de résultat</h3>
			<p><a href="testClimatExemple.php">Exemple</a> de résultat possible avec test Climat </p>
		</section>
		<section class="section_fin">
			<h2 id="section-6">Interprétations des résultats</h2>
			<div class="A_noter">
				<div class="A_noter_titre">A noter</div>
				Le diagramme ombrothermique de la page des résultats ne peut pas être réutilisé telle quel, en effet celui-ci ne dispose pas de deux axes des y.
			</div>
			<p>TestClimats se basent sur un certain nombre de variables déduites des données climatiques rentré dans l'algorithme.</p>

			<ul>
				<h3 id="section-7">Variables utilisées par testClimat et leur définition</h3>
				<br />
				<li>Variables Tmax, Tmin et Tmannuelle</li>
				<ul>
					<li>Tmax -> Températures du mois le plus chaud de l'année.</li>
					<li>Tmin -> Températures du mois le plus froid de l'année.</li>
					<li>Tmannuelle -> MOYENNE des températures de tous les mois de l'années.</li>
				</ul>
				<br />
				<li>Variables Pmax, Psmax et Pwmax :</li>
				<ul>
					<li>Pmax -> Précipitation du mois ayant eu le plus de précipitation de l'année.</li>
					<li>Psmax -> Précipitation du mois ayant eu le plus de précipitation de l'été (d'Avril à Septembre).</li>
					<li>wmax -> Précipitation du mois ayant eu le plus de précipitation de l'hiver (d'Octobre à Mars).</li>
				</ul>
				<li>Variables Pmin, Psmin et Pwmin :</li>
				<ul>
					<li>Pmax -> Précipitation du mois ayant eu le moins de précipitation de l'année</li>
					<li>Psmax -> Précipitation du mois ayant eu le moins de précipitation de l'été (d'Avril à Septembre).</li>
					<li>wmax -> Précipitation du mois ayant eu le moins de précipitation de l'hiver (d'Octobre à Mars).</li>
				</ul>
				<li>Variables Pannuelle, Phiver et Pété :</li>
				<ul>
					<li>Pannuelle -> SOMME des précipitations de l'année.</li>
					<!--<li>Phiver -> SOMME des précipitations de l'été (d'Avril à Septembre).</li>
					<li>Pété -> SOMME des précipitations de l'hiver (d'Octobre à Mars).</li>-->
				</ul>
				<br />
				<li>Variables PTH et NbAride :</li>
				<ul>
					<li>PTH -> Seuil d'aridité, le PHT permet de déterminer si un climat est aride ou non.</li>
					<li>NbAride -> Nombre de mois aride, celui-ci est tiré de <a href="https://fr.wikipedia.org/wiki/Indice_de_Gaussen">l'indice Gaussen.</a></li>
				</ul>
			</ul>
			<h3 id="section-8">A propos de l'indice de Martonne</h3>
			<p><a href="https://fr.wikipedia.org/wiki/Aridit%C3%A9">L'indice d'aridité Martonne</a>, noté I, permet de déterminer le degré d'aridité d'une région.</p>
			<ul>
				<li>I = 0 => Régions hyperarides.</li>
				<li>I = 5 => Régions arides.</li>
				<li>I = 10 => Régions semi-arides.</li>
				<li>I = 20 => Régions semi-humides.</li>
				<li>I = 30 => Régions humides.</li>
			</ul>
		</section>
	</main>
	<footer>
		<?php include('navigation/footer.php'); ?>
	</footer>
</body>

</html>