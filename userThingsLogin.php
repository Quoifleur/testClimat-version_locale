<?php session_start();
try {
    $db = new PDO('mysql:host=localhost;dbname=testclimat;charset=utf8', 'root', 'root', [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],);
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}
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
    setcookie('logged', '', time() + 1, null, null, false, true);
    unset($_COOKIE['logged']);
    header('Location: userThingsLogin.php');
    exit();
}

// Inscription
if (isset($_POST['SIGemail']) && isset($_POST['SIGpassword'])) {
    // Préparation des variables
    $clef = random_string(64);
    $email = strip_tags($_POST['SIGemail']);
    $password = strip_tags($_POST['SIGpassword']);
    $passwordAverifer = strip_tags($_POST['SIGpassword']);
    $password = password_hash($password, PASSWORD_BCRYPT);
    $dateInscription = date('Y-m-d H:i:s');
    // Vérification de l'unicité de l'email, si bon mot de passe, connexion, sinon création du compte.
    $query = $db->prepare('SELECT * FROM user WHERE mail = :mail');
    $query->execute(['mail' => $email]);
    $user = $query->fetch();
    if ($user) {
        $query = $db->prepare('SELECT * FROM user');
        $query->execute();
        $user = $query->fetch();
        // Vérification du mot de passe
        if ($user && password_verify($passwordAverifer, $user['password'])) {
            $_SESSION['user'] = $user;
            if (isset($_POST['SIGcheckbox'])) {
                setcookie('logged', $user['clef'], time() + 3600 * 24 * 365, null, null, false, true);
            } else {
                setcookie('logged', $user['clef'], time() + 3600 * 24, null, null, false, true);
            }
            header('Location: userThings.php');
            exit();
            // Si le mot de passe est incorrect
        } else {
            echo '<b> Mot de passe incorrect </b><br /> Pour retourner à la page précédente, <a href="userThingsLogin.php">cliquez ici</a> <br /> Pour retourner à la page d\'accueil, <a href="index.php">cliquez ici</a>';
            exit();
        }
    } else {
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
        header('Location: userThings.php');
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
        </section>
        <section class="section_milieu">
            <?php
            if (isset($_COOKIE['logged'])) {
                echo '<p>Vous êtes déjà connecté</p><br />';
                echo '<form method="post"><button method="post" type="submit" name="deconnexion" value="deconnexion">Déconnexion</button></form>';
            } else {
                include('connexion/formulaireLogin.php');
            }
            ?>
        </section>
        <section class="section_fin">
        </section>
    </main>

</body>
<?php include('navigation/footer.php'); ?>

</html>