<?php
session_start();
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
			<h1>A propos</h1>
			<p>
			<ul>
				<li>Vous avez constaté une ou plusieurs imprécision(s) et/ou erreur(s) dans les résultats de TestClimat ?</li>
				<li>Vous avez des suggestions ou vous avez constaté un ou plusieurs bug(s) sur le site TestClimat?</li>
				<li><b>N'hésitez pas à me contacter.</b></li>
			</ul>

			</p>
		</section>
		<section class="section_milieu">
			<p>
			<h2>Mentions légals :</h2>
			TestClimat est un site web pensé, développé et administré par Quoifleur.
			<br /><br />TestClimat est un outil gratuit pour déterminer le climat (selon la classification de Köppen-Geiger) d'un lieu donné à partir de données climatiques. Un climat ainsi trouvé n'est données qu'à titre informatif. L'utilisation d'un résultat donné par TestClimat relève de la seule responsabilité de l'utilisateur.
			<br /><br />TestClimat utilise aucun cookies à but publicitaires.
			<h3>Hébergeur :</h3>
			<h3>Droit d'auteur :</h3>
			TestClimat utilise l'API de <a href="https://developers.google.com/chart?hl=fr">google chart</a>.
			<br /><br />Polices d'écritures utilisées :
			<ul>
				<li><a href="https://fonts.google.com/specimen/Merriweather?query=Sorkin+Type">Merriweather</a> par Sorkin Type.</li>
				<li><a href="https://fonts.google.com/specimen/Ubuntu?query=ubuntu">Ubuntu</a> par Dalton Maag .</li>
			</ul>
			Ces polices proviennent de <a href="https://fonts.google.com/">google font</a>.
			</p>
		</section>
		<section class="section_fin">
			<h2 id="contact">Contact :</h2>
			N'hésiter à me contacter au mail suivant : <a href="mailto:quoifleurr@gmail.com">quoifleurr@gmail.com</a>.
			<br />
			<address>Vous pouvez aussi contacter le créateur de ce site internet via la messagerie intégrée à <a rel="me" href="https://pouet.chapril.org/@quoifleur">Mastodon</a>.</address>
		</section>
	</main>
	<footer>
		<?php include('navigation/footer.php'); ?>
	</footer>
</body>

</html>