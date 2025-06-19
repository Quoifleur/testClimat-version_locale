<?php
function rrmdir($dir)
{

    if (is_dir($dir)) {

        $objects = scandir($dir);

        foreach ($objects as $object) {

            if ($object != "." && $object != "..") {

                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);

            }

        }

        reset($objects);

        rmdir($dir);

    }

}
// Fonction pour supprimer récursivement tous les fichiers et sous-dossiers
function deleteDirectory($dir)
{
    if (!is_dir($dir)) {
        echo "Erreur : $dir n'est pas un répertoire valide.\n";
        return false;
    }

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $dir . '/' . $file;
            if (is_dir($filePath)) {
                // Appel récursif pour les sous-dossiers
                if (!deleteDirectory($filePath)) {
                    echo "Erreur : Impossible de supprimer le sous-dossier $filePath.\n";
                    return false;
                }
            } else {
                // Supprime le fichier
                if (!unlink($filePath)) {
                    echo "Erreur : Impossible de supprimer le fichier $filePath.\n";
                    return false;
                }
            }
        }
    }

    // Vérifiez à nouveau que le répertoire est vide
    $files = scandir($dir);
    if (count($files) > 2) { // Plus de 2 signifie qu'il reste des fichiers (car . et .. sont toujours présents)
        echo "Erreur : Le répertoire $dir n'est pas vide.\n";
        return false;
    }

    // Supprime le dossier une fois qu'il est vide
    if (!rmdir($dir)) {
        echo "Erreur : Impossible de supprimer le dossier $dir.\n";
        return false;
    }

    return true;
}

// Chemin du répertoire à supprimer
$dir = 'upload/extract' . $fichier;

// Supprime le répertoire et son contenu
if (deleteDirectory($dir)) {
    echo "Info : Le fichier GTFS chargé a été supprimé avec succès.\n";
} else {
    echo "Erreur : Le fichier GTFS chargé n'a pas pu être supprimé.\n";
}

// Supprime le fichier ZIP
if (file_exists('./upload/' . $fichier)) {
    if (!unlink('./upload/' . $fichier)) {
        echo "Erreur : Impossible de supprimer le fichier ZIP ./upload/$fichier.\n";
    } else {
        echo "<br>Info : Le fichier ZIP ./upload/$fichier a été supprimé avec succès.\n";
    }
}
echo $fichier;
$dirname = 'upload/extract' . $fichier;
closedir(opendir($dirname));
rrmdir($dirname);