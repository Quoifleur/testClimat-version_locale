<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('connexion/bdconnexion.php');
function random_string($length)
{
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
$CanHaveNewPassword = false;
if (isset($_POST['FORcode'])) {
    $FORcode = strip_tags($_POST['FORcode']);
    if ($FORcode === $_COOKIE['MAILverif']) {
        $CanHaveNewPassword = true;
    }
}

if ($CanHaveNewPassword && isset($_POST['FORpassword'])) {
    $FORpassword = strip_tags($_POST['FORpassword']);
    $password = password_hash($FORpassword, PASSWORD_BCRYPT);
    $query = $db->prepare('UPDATE user SET password = :password WHERE mail = :mail');
    $query->execute(['mail' => $email, 'password' => $password]);
    $user = $query->fetch();
}
$SENDmail = false;
if (isset($_POST['FORemail'])) {
    $FORemail = strip_tags($_POST['FORemail']);
    $email = filter_var($FORemail, FILTER_VALIDATE_EMAIL);
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
                $mailFIND = true;
                setcookie('MAILverif',  random_string(6), time() + 1800, '/', 'testclimat.ovh', false, true);
                //Le message
                $message = 'Merci ne ne pas répondre à ce message. (Notez que ce code expirera au bout d\'une demie heure. Code : ' . $_COOKIE['MAILverif'] . '';
                // Envoi du mail
                $NEWmail = mail($email, 'Rénitialisation du mot de passe', $message);
                $SENDmail = true;
            }
        }
        if ($mailFIND && !$SENDmail) {
            echo 'Une erreur est survenue lors de l\'envoi du mail<br /> Pour retourner à la page précédente, <a href="userThingsLoginMAIL.php">cliquez ici</a> <br />Pour retourner à la page de connexion, <a href="userThingsLogin.php">cliquez ici</a> <br /> Pour retourner à la page d\'accueil, <a href="index.php">cliquez ici</a>';
            exit();
        } elseif (!$mailFIND) {
            echo '<b> Mail introuvable </b><br /> Pour retourner à la page précédente, <a href="userThingsLoginMAIL.php">cliquez ici</a> <br /> Pour retourner à la page de connexion, <a href="userThingsLogin.php">cliquez ici</a> <br /> Pour retourner à la page d\'accueil, <a href="index.php">cliquez ici</a>';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include('navigation/head.php'); ?>
    <title>UserThingsLoginMAIL</title>
</head>

<body>
    <?php include('navigation/header.php'); ?>
    <?php include('navigation/nav.php'); ?>
    <main>
        <section class="section_intro">
            <h1>Mot de passe oublié?</h1>
            <p>Merci de rentrer votre mail, si celui-ci existe dans notre base de données un mail vous sera envoyé pour réinitialiser votre mot de passe</p>
            <form action="userThingsLoginMAIL.php" method="post">
                <label for="FORemail">Email</label>
                <input type="email" name="FORemail" id="FORemail" required>
                <input type="submit" value="Valider mon mail">
            </form>
            <?php
            if ($SENDmail) {
                echo
                'Un mail vous a été envoyé pour réinitialiser votre mot de passe. Entrez le code reçu ci-dessous.
                <form action="userThingsLoginMAIL.php" method="post">
                <label for="FORcode">code</label>
                <input type="texte" placeholder="code reçu par mail" name="FORcode" id="FORcode" maxlength="6" required>
                <input type="submit" value="Valider mon code">
            </form>';
            }
            if ($CanHaveNewPassword) {
                echo
                'Code correct, entrez votrz nouveau mot de passe.
                <form action="userThingsLoginMAIL.php" method="post">
                <label for="FORpassword">Nouveau mot de passe</label>
                <input type="password" placeholder="Nouveau mot de passe" name="FORpassword" id="FORpassword" required>
                <input type="submit" value="Valider mon nouveau mot de passe">
                </form>';
            }
            ?>
        </section>
        <section class="section_milieu">
        </section>
        <section class="section_fin">
        </section>
    </main>
    <?php include('navigation/footer.php'); ?>
</body>

</html>