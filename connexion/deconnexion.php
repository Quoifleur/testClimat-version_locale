<?php
//ession_start();
// Déconnexion
if (isset($_POST['deconnexion']) && isset($_COOKIE['logged'])) {
    // Supprimez le cookie en définissant une date d'expiration passée
    setcookie('logged', '', time() - 3600, '/');

    // Supprimez la variable de cookie
    unset($_COOKIE['logged']);

    // Libérez toutes les variables de session
    session_unset();

    // Détruisez la session
    session_destroy();

    // Redirigez l'utilisateur vers la page de connexion
    //header('Location: ../userThingsLogin.php');
    echo 'Vous avez été déconnecté. <br />Si la redirection ne fonctionne pas, <a href="../userThingsLogin.php">cliquez ici</a>';
    exit();
}
