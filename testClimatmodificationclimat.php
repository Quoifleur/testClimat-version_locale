<?php
session_start();
include('fonctions/function_tC.php');
$ClimataMofifier = '';
$ClimataMofifier = NettoyageString($_GET['modifier']);
?>
<!DOCTYPE html>
<html lang="fr">

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
            echo $ClimataMofifier . '<br />';
            ?>
            <p>Pour vous connecter ou pvous inscrire merci d'aller sur la <a href="userThingsLogin.php">page de connection et d'inscription</a></p>
            <p>
                TestClimat est un outil gratuit pour déterminer le climat (selon la classification de <a href="https://fr.wikipedia.org/wiki/Classification_de_K%C3%B6ppen">Köppen-Geiger</a>) d'un lieu donné à partir de données climatiques.
            </p>
        </section>
        <section class="section_milieu">

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
        </section>
    </main>
    <footer>
        <?php include('navigation/footer.php'); ?>
    </footer>
</body>

</html>