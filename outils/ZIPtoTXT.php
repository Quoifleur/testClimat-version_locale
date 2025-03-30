<?php
require('src/function_tC.php');
$fichierChargé = false;
$erreur = false;
$dossier = 'upload/';
$fichier = basename($_FILES['file']['name']);
$taille_maxi = 25000000; // 25Mo
$taille = $_FILES['file']['size'];
$extensions = array('.zip', '.rar');
$extension = strrchr($_FILES['file']['name'], '.');
//Début des vérifications de sécurité...
if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = true;
    $MessageErreur[] = 'Erreur : le fichier n\'est pas au format .zip ou .rar';
}
if ($taille > $taille_maxi) {
    $erreur = true;
    $MessageErreur[] = 'Erreur : le fichier est trop volumineux (' . $taille / 1000000 . ' Mo  (max ' . $taille_maxi / 1000000 . ' Mo))';
}
if (!$erreur) //S'il n'y a pas d'erreur, on upload
{
    // Vérifiez si le répertoire existe, sinon créez-le
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }
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
        $MessageErreur[] = 'Erreur : le fichier n\'a pas pu être copié dans le dossier de destination';
    }
} else {
    $erreur = true;
    $MessageErreur[] = 'Erreur : une erreur est survenue lors du téléchargement du fichier';
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
        $MessageErreur[] = 'Erreur : le fichier n\'a pas pu être extrait';
    }
    $Nbfichier = count_files($lienVersFichier, '.txt', 1);
    $ListeFichierGTFSprésent = [
        ['agency.txt', false, 'required', null],
        ['stops.txt', false, 'conditionally required', 'locations.geojson'], // Dépend de locations.geojson si des zones réactives sont définies.
        ['routes.txt', false, 'required', null],
        ['trips.txt', false, 'required', null],
        ['stop_times.txt', false, 'required', null],
        ['calendar.txt', false, 'conditionally required', 'calendar_dates.txt'], // Nécessite calendar_dates.txt si non défini.
        ['calendar_dates.txt', false, 'conditionally required', 'calendar.txt'], // Nécessite calendar.txt si non défini.
        ['fare_attributes.txt', false, 'optional', null],
        ['fare_rules.txt', false, 'optional', null],
        ['timeframes.txt', false, 'optional', null],
        ['fare_media.txt', false, 'optional', null],
        ['fare_products.txt', false, 'optional', null],
        ['fare_leg_rules.txt', false, 'optional', null],
        ['fare_transfer_rules.txt', false, 'optional', null],
        ['areas.txt', false, 'optional', null],
        ['stop_areas.txt', false, 'optional', null],
        ['networks.txt', false, 'conditionally forbidden', 'routes.txt'], // Interdit si network_id existe dans routes.txt.
        ['route_networks.txt', false, 'conditionally forbidden', 'routes.txt'], // Interdit si network_id existe dans routes.txt.
        ['shapes.txt', false, 'optional', null],
        ['frequencies.txt', false, 'optional', null],
        ['transfers.txt', false, 'optional', null],
        ['pathways.txt', false, 'optional', null],
        ['levels.txt', false, 'conditionally required', 'pathways.txt'], // Nécessaire pour pathway_mode=5 (ascenseurs).
        ['location_groups.txt', false, 'optional', null],
        ['location_group_stops.txt', false, 'optional', null],
        ['locations.geojson', false, 'optional', null],
        ['booking_rules.txt', false, 'optional', null],
        ['translations.txt', false, 'optional', null],
        ['feed_info.txt', false, 'conditionally required', 'translations.txt'], // Nécessaire si translations.txt est fourni.
        ['attributions.txt', false, 'optional', null]
    ];
    $Nbfichierthéorique = count($ListeFichierGTFSprésent);
    for ($i = 0; $i < $Nbfichierthéorique; $i++) {
        if (file_exists($lienVersFichier . '/' . $ListeFichierGTFSprésent[$i][0])) {
            $ListeFichierGTFSprésent[$i][1] = true;
        }
    }
}
