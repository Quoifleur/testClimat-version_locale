<?php
session_start();
include('connexion/bdconnexion.php');
$USERclef = strip_tags($_COOKIE['logged']) ?? null;
if ($USERclef == null) {
    header('Location: userThingsLogin.php');
    exit();
}
$sqlQuery = 'SELECT * FROM user WHERE clef = :clef';
$verifUser = $db->prepare($sqlQuery);
$verifUser->execute(['clef' => $USERclef]);
$user = $verifUser->fetch();

if (isset($_POST['suppDef'])) {
    if ($_POST['suppDef'] == 'suppDef') {
        $user = strip_tags($_COOKIE['logged']);
        $sqlQuery = 'SELECT * FROM user WHERE clef = :clef';
        $verifuser = $db->prepare($sqlQuery);
        $verifuser->execute(['clef' => $user]);
        $rowUser = $verifuser->fetchAll();
        if ($rowUser != null) {
            $deleteUser = $db->prepare('DELETE FROM user WHERE clef = :clef');
            $deleteUser->execute(['clef' => $user]) or die(print_r($db->errorInfo()));
            $deleteClimat = $db->prepare('DELETE FROM climat WHERE clef = :clef');
            $deleteClimat->execute(['clef' => $user]) or die(print_r($db->errorInfo()));
        }
        setcookie('logged', "", time() + 1, '/', 'testclimat.ovh', true, true);
        unset($_COOKIE['user']);
        unset($_COOKIE['logged']);
        echo 'Votre compte ainsi que toutes vos données ont été supprimé définitevement avec succès <br /><br />Nous vous invitons à fermer cette page.<br /><a href="index.php">Pour revenir à l\'accueil  de testClimat cliquez ici</a>';
        exit();
    }
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
            <h1>Gestion du compte</h1>
            <h2>Information sur votre compte</h2>
            <p>Vous êtes connecté en tant que :
                <?php
                echo $user['mail'];
                //echo '<br />votre clef (celle-ci permet d\'enregistrer vos climats) est : <br />' . $user['clef'];
                echo '<br />Votre date d\'inscription est : ' . $user['dateInscription'];
                echo '<br />Votre mail est vérifié : ';
                $mailVERIF = $user['mailVerifie'] ? '1' : 'non';
                echo $mailVERIF;
                ?>
            </p>
        </section>
        <section class="section_milieu">
            <h2>Suppression du compte</h2>
            <h3>Présentation des cookies</h3>
            <p>Le cookie est un petit fichier texte stocké dans votre navigateur internet. <br />Dans le cas de testClimat, le cookie est utilisé pour stocker un identifiant unique qui permet de vous associer à vos normales climatiques dans un base de données. Cette base de données est utilisée pour stocker les climats que vous avez sauvegardé. Par conséquent, si vous avez désactivé les cookies, vous ne pourrez pas sauvegarder vos climats.</p>
            <p><b> Le bouton ci-dessous effacera votre compte et vos données climatiques enregistré </b></p>
        </section>
        <section class="section_fin">
            <div class="attention">
                <div class="attention_titre">Attention</div>
                <p><b>Toutes les données effacées seront irrémédiablement effacées</b><br />Nous vous conseillons de telécharger vos climats enregistrés.</p>

                <form method='post'>
                    <button method='post' type="submit" name="supp" value="supp">Supprimer mon cookie et la base de données associée</button>
                </form>
                <form method='post'>
                    <?php
                    if (isset($_POST['supp'])) {
                        if ($_POST['supp'] == 'supp') {
                            echo '<br /><button method="post" type="submit" name="suppDef" value="suppDef">Confirmer la suppression de mon compte</button>';
                        }
                        if (isset($_POST['suppDef'])) {
                            if ($_POST['suppDef'] == 'suppDef') {
                                echo 'Votre compte ainsi que toutes vos données ont été supprimé <br /><br />Nous vous invitons à fermer cette page.<br /><a href="index.php">Pour revenir à l\'accueil  de testClimat cliquez ici</a>';
                            }
                        }
                    }
                    ?>
                </form>
            </div>

        </section>
    </main>
    <footer>
        <?php include('navigation/footer.php'); ?>
    </footer>
</body>

</html>