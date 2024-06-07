<?php
session_start();
include('navigation/bdconnexion.php');
if ($_POST['suppDef'] == 'suppDef') {
    $user = strip_tags($_COOKIE['user']);
    $sqlQuery = "SHOW TABLES FROM testclimat LIKE '" . $user . "'";
    $verifTable = $db->prepare($sqlQuery);
    $verifTable->execute();
    $table = $verifTable->fetchAll();
    if ($table != null) {
        $deleteUserDataBase = $db->prepare('DROP TABLE ' . $user);
        $deleteUserDataBase->execute([]) or die(print_r($db->errorInfo()));
    }
    unset($_COOKIE['user']);
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
            <h1>Gestion du cookie</h1>
            <h2>Présentation</h2>
            <p>Le cookie est un petit fichier texte stocké dans votre navigateur internet. <br />Dans le cas de testClimat, le cookie est utilisé pour stocker un identifiant unique qui permet de vous associer à une base de données. Cette base de données est utilisée pour stocker les climats que vous avez sauvegardé. Par conséquent, si vous avez désactivé les cookies, vous ne pourrez pas sauvegarder vos climats.</p>
            <p>
                Votre cookie : <?php if (isset($_COOKIE['user'])) {
                                    echo '<div class="flou"> ' . $_COOKIE["user"] . ' </div> (passez votre souris au dessus pour le voir).';
                                }
                                if (isset($_COOKIE['logged'])) {
                                    echo '<div class="flou"> ' . $_COOKIE["logged"] . ' </div> (passez votre souris au dessus pour le voir).';
                                } else {
                                    echo 'Aucun cookie ne vous est assigné.';
                                    echo '<br />Aucune base de données ne vous est assigné.';
                                }
                                ?>
            </p>
        </section>
        <section class="section_milieu">
            <h2>Suppression du cookie</h2>
            <p>Pensez à refuser l'accès au cookie à testClimat sans quoi celui en recréra un à votre prochaine connexion. <br /><b> Le bouton ci-dessous effacera votre cookie et la base de données associée. </b><br />En effet, une base de données au nom de votre cookie se créer automatiquement à la première utilisation de testClimat (en mode avec cookie).<br /><br />
            <div class="A_noter">
                <div class="A_noter_titre">A noter</div>
                Si vous réutilisez testClimat par la suite sans avoir désactivé les cookies pour le site, une nouvelle table dans la base de données vous sera associée.
            </div>
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
                            echo '<br /><button method="post" type="submit" name="suppDef" value="suppDef">Confirmer la suppréssion de mon cookie et de la base de données associée</button>';
                        }
                        if (isset($_POST['suppDef'])) {
                            if ($_POST['suppDef'] == 'suppDef') {
                                echo 'Votre cookie ainsi que votre base de données ont été supprimé <br /><br />Nous vous invitons à fermer cette fenêtre.<br /><a href="index.php">Pour revenir à l\'accueil  de testClimat cliquez ici</a><br /><b>Attention, si vous avez pas refusé l\'accès au cookie à testClimat depuis votre navigateur, un nouveau cookie se régénéra si vous cliquer sur le lien</b>';
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