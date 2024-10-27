<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('connexion/bdconnexion.php');
if (isset($_POST['NEWemail'])) {
    $NEWemail = strip_tags($_POST['NEWemail']);
    $NEWcode = strip_tags($_POST['NEWcode']);
    $NEWpassword = strip_tags($_POST['NEWpassword']);
    $query = $db->prepare('SELECT * FROM user WHERE mail = :mail');
    $query->execute(['mail' => $NEWemail]);
    $users = $query->fetchALL();
    if ($users != null) {
        foreach ($users as $value) {
            $USERSid[] = $value['id'];
            $USERSclef[] = $value['clef'];
            $USERSmail[] = $value['mail'];
            $USERSpassword[] = $value['password'];
            $USERSmailverif[] = $value['mailVerifie'];
            $USERScode[] = $value['CODEverif'];
        }
        if ($USERSmail[0] === $NEWemail && $USERScode[0] === $NEWcode) {
            $password = password_hash($NEWpassword, PASSWORD_BCRYPT);
            $query = $db->prepare('UPDATE user SET password = :password WHERE mail = :mail');
            $user = $query->execute(['mail' => $NEWemail, 'password' => $password]);
            header('Location: userThingsLogin.php');
            exit();
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
            <h1>nouveau mot de passe</h1>
            <p>Merci de rentrer le code de vérification envoyé par mail, votre mail et votre nouveau mot de passe</p>
            <form action="userThingsLoginNewMDP.php" method="post">
                <label for="NEWcode">code</label>
                <input type="texte" placeholder="code reçu par mail" name="NEWcode" id="NEWcode" maxlength="6" required>
                <label for="NEWemail">Email</label>
                <input type="email" name="NEWemail" id="NEWemail" required>
                <label for="NEWpassword">Nouveau mot de passe</label>
                <input type="password" placeholder="Nouveau mot de passe" name="NEWpassword" id="NEWpassword" required>
                <input type="submit" value="Valider mon mail">
            </form>
        </section>
        <section class="section_milieu">
        </section>
        <section class="section_fin">
        </section>
    </main>
    <?php include('navigation/footer.php'); ?>
</body>

</html>