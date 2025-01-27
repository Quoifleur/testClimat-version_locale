<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<?php include('navigation/head.php'); ?>
	<style>
        .changelog h1,
        .changelog h2,
        .changelog h3,
        .changelog p,
        .changelog li,
		.changelog {
            width: 100% !important;
            color: #6F6951 !important;
        }
    </style>
	<title>testClimat</title>
</head>

<body>
	<?php include('navigation/header.php'); ?>
	<?php include('navigation/nav.php'); ?>
	<?php include('navigation/aside.php'); ?>
	<main class="containeur">
		<h1>Changelog</h1>
		<div class="changelog" style="color: #6F6951"><script  src="https://gist.github.com/Quoifleur/a759d77e81e1d0099b17e1bfa2ccabfe.js"></script></div>
</div>
	</main>
	<footer>
		<?php include('navigation/footer.php'); ?>
	</footer>
</body>

</html>