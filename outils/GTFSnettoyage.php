<?
//Ce fichier supprime automatiquement les fichiers GTFS chargés.
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
unlink('./upload/'. $fichier);