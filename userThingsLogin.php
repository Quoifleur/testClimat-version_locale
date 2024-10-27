<?php session_start();
include('connexion/bdconnexion.php');
function random_string($length)
{
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
// Déconnexion
if (isset($_POST['deconnexion']) && isset($_COOKIE['logged'])) {
    setcookie('logged', $value['clef'], time() + 1, '/', 'testclimat.ovh', true, true);
    unset($_COOKIE['logged']);
    session_destroy();
    header('Location: userThingsLogin.php');
    exit();
}

$newUser = false;
$dateInscription = date('Y-m-d H:i:s');
if (isset($_POST['SIGemail']) && isset($_POST['SIGpassword'])) {
    // Préparation des variables
    $clef = random_string(64);
    $email = filter_var(strip_tags($_POST['SIGemail']), FILTER_VALIDATE_EMAIL);
    $passwordAverifier = strip_tags($_POST['SIGpassword']);
    if (!$email || !$passwordAverifier) {
        echo '<b>Adresse mail ou incorrecte</b><br /> Pour retourner à la page précédente, <a href="userThingsLogin.php">cliquez ici</a> <br /> Pour retourner à la page d\'accueil, <a href="index.php">cliquez ici</a>';
        exit();
    }
    $password = password_hash($passwordAverifier, PASSWORD_BCRYPT);
    // Vérification de l'existence de l'utilisateur
    $query = $db->prepare('SELECT * FROM user');
    $query->execute();
    $users = $query->fetchALL();
    foreach ($users as $value) {
        $USERSid[] = $value['id'];
        $USERSclef[] = $value['clef'];
        $USERSmail[] = $value['mail'];
        $USERSpassword[] = $value['password'];
        $USERSmailverif[] = $value['mailVerifie'];
    }
    if (isset($USERSid[0]) && !empty($USERSid[0])) {
        $NbRowInTable = count($USERSid);
        for ($i = 0; $i < $NbRowInTable; $i++) {
            if ($USERSmail[$i] === $email) {
                if ($USERSmail[$i] === $email && password_verify($passwordAverifier, $USERSpassword[$i])) {
                    $newUser = false;
                    if (isset($_POST['SIGcheckbox'])) {
                        setcookie('logged', $USERSclef[$i], time() + 3600 * 24 * 365, '/', 'testclimat.ovh', true, true);
                    } else {
                        setcookie('logged', $USERSclef[$i], time() + 3600 * 24, '/', 'testclimat.ovh', true, true);
                    }
                    $newUser = false;
                    header('Location: userThingsTer.php');
                    exit();
                } else {
                    $newUser = false;
                    echo '<b> Mauvais mot de passe </b><br /> Pour retourner à la page précédente, <a href="userThingsLogin.php">cliquez ici</a> <br /> Pour retourner à la page d\'accueil, <a href="index.php">cliquez ici</a>';
                    exit();
                }
            }
        }
    }
    $newUser = true;
    if ($newUser) {
        $query = $db->prepare('INSERT INTO user (clef, mail, password, dateInscription) VALUES (:clef, :mail, :password, :dateInscription)');
        $query->execute(['clef' => $clef, 'mail' => $email, 'password' => $password, 'dateInscription' => $dateInscription]);
        $user = $query->fetch();
        if (isset($_POST['SIGcheckbox'])) {
            setcookie('logged', $user['clef'], time() + 3600 * 24 * 365, null, null, false, true);
        } else {
            setcookie('logged', $user['clef'], time() + 3600 * 24, null, null, false, true);
        }
        if (!isset($_COOKIE['user'])) {
            $_COOKIE['user'] = $_COOKIE['logged'];
        }
        header('Location: userThingsTer.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include('navigation/head.php'); ?>
    <title>loginAndSingup</title>
</head>
<?php include('navigation/header.php'); ?>
<?php include('navigation/nav.php'); ?>

<body>
    <main>
        <section class="section_intro">
            <h1>testClimat-Compte</h1>
            <p>Connectez-vous pour pouvoir sauvegarder vos données et plus encore.</p>
            <p>Si vous souhaitez vous inscrire, en renplissant le formulaire vous acceptez les <a href="testClimatAPropos.php">conditions d'utilisation</a> de testClimat. Notez que testClimat ne collecte aucune données personnelles à des fins commerciales. Les données personnelles collectées sont uniquement utilisées pour la connexion et l'inscription des utilisateurs. <b>Ces données sont partagées avec aucun tiers.</b>
            </p>
        </section>
        <section class="section_milieu">
            <?php
            if (isset($_COOKIE['logged'])) {
                echo '<p>Vous êtes déjà connecté</p><br />';
                echo '<form method="post"><button method="post" type="submit" name="deconnexion" value="deconnexion">Déconnexion</button></form>';
            } else {
                include('connexion/formulaireLogin.php');
                echo 'Mot de passe oublié ? <a href="userThingsLoginMAIL.php">Cliquez ici</a>';
            }
            ?>
        </section>
        <section class="section_fin">
        </section>
    </main>

</body>
<?php include('navigation/footer.php'); ?>

</html>