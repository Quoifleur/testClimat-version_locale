<?php
require('fonctions/function_tC.php');
$fichierChargé = false;
$erreur = false;
$dossier = 'upload/';
$fichier = basename($_FILES['file']['name']);
$taille_maxi = 9000000;
$taille = filesize($_FILES['file']['tmp_name']);
$extensions = array('.zip', '.rar');
$extension = strrchr($_FILES['file']['name'], '.');
//Début des vérifications de sécurité...
if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = true;
}
if ($taille > $taille_maxi) {
    $erreur = true;
}
if (!$erreur) //S'il n'y a pas d'erreur, on upload
{
    //On formate le nom du fichier ici...
    $fichier = strtr(
        $fichier,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
    );
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier)) {
        $fichierChargé = true;
        //setcookie('userGTFS', $fichier, time() + 3600 * 6, null, null, false, true);
    } else //Sinon (la fonction renvoie FALSE).
    {
        $erreur = true;
    }
} else {
    $erreur = true;
}
// Fin des vérifications de sécurité...
// On extrait le fichier
if (!$erreur && $fichierChargé) {
    $Nomfichier = explode('.', $fichier);
    $lienVersFichier = 'upload/extract' . $fichier;
    if (!file_exists($lienVersFichier)) {
        mkdir($lienVersFichier, 0777, true);
    }
    $ZipGTFS = new ZipArchive;
    if ($ZipGTFS->open('upload/' . $fichier) === TRUE) {
        $ZipGTFS->extractTo($lienVersFichier);
        $ZipGTFS->close();
    } else {
        $erreur = true;
    }
    $Nbfichier = count_files($lienVersFichier, '.txt', 1);
}
