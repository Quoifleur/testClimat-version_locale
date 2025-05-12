<?php
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

    // Supprime le dossier une fois qu'il est vide
    if (!rmdir($dir)) {
        echo "Erreur : Impossible de supprimer le dossier $dir.\n";
        return false;
    }

    return true;
}

unset($handle);
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
        echo "Info : Le fichier ZIP ./upload/$fichier a été supprimé avec succès.\n";
    }
}
