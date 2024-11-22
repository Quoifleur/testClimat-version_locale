<?php session_start();
include('connexion/bdconnexion.php');
include('fonctions/function_tC.php');
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
                $codeConnexion = random_string(6);
                $query = $db->prepare('UPDATE user SET CODEverif = :CODEverif WHERE mail = :mail');
                $user = $query->execute(['mail' => $email, 'CODEverif' => $codeConnexion]);
                //Le message
                $resetLink = "https://www.testclimat.ovh/userThingsLoginNewMDP.php";
                $message = 'Merci de ne pas répondre à ce message. Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant : ' . $resetLink . ' code=' . $codeConnexion . ' Si vous n\'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer ce message.';
                $message = wordwrap($message, 70, "\r\n");
                // Envoi du mail
                $NEWmail = mail($email, 'Rénitialisation du mot de passe', $message);
                $SENDmail = true;
                break;
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
            <p>Merci de rentrer votre mail, si celui-ci existe dans notre base de données un mail vous sera envoyé pour réinitialiser votre mot de passe.</p>
            <p>Si vous ne recevez pas de mail, vérifiez votre dossier spam.</p>
            <form action="userThingsLoginMAIL.php" method="post">
                <label for="FORemail">Email</label>
                <input type="email" name="FORemail" id="FORemail" required>
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