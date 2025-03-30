<?
//Ce fichier supprime automatiquement les fichiers GTFS chargés.
$dir = 'upload/extract' . $fichier;
if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            unlink($dir . '/' . $file);
        }
    }

    rmdir($dir);
}
unlink('./upload/' . $fichier);
//verification de la suppression du fichier
if (is_dir($dir)) {
    $MessageErreur[] = 'Erreur : Le fichier GTFS chargé n\'a pas pu être supprimé.';
    $MessageErreur[] = 'ATTENTION : MERCI DE ME CONTACTER (<a href="mailto:victor.maury@testclimat.ovh">victor.maury@testclimat.ovh</a>) POUR QUE JE PUISSE LE FAIRE MANUELLEMENT.';
} else {
    $MessageErreur[] = 'Info : Le fichier GTFS chargé a été supprimé avec succès.';
}