<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
function baricentrebis($array)
{
    $lat = 0;
    $long = 0;
    $somme = 0;
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i][0]);
    }
    $lat = round($somme / $n, 3);
    $somme = 0;
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i][1]);
    }
    $long = round($somme / $n, 3);
    return $lat . ',' . $long;
}

$filePath = 'upload/extract' . $fichier . '/stops.txt';
$handle = fopen($filePath, 'r');
if ($handle) {
    $legende = fgetcsv($handle);
    $Nbcolonnes = count($legende);
    $Xkey = array_search('stop_lat', $legende);
    $Ykey = array_search('stop_lon', $legende);
    $Nbpoints = 0;
    while (($data = fgetcsv($handle)) !== false) {
        //print_r($legende);
        //print_r($data);
        $StopsPositionXY[$Nbpoints] = [$data[$Xkey], $data[$Ykey]];
        $Nbpoints++;
    }
    echo $Nbpoints;
    //print_r($PositionXY);
    fclose($handle);
} else {
    echo 'Erreur : Impossible d\'ouvrir le fichier ' . $filePath;
}

$baricentre = explode(',', baricentrebis($StopsPositionXY));
//print_r($baricentre);

$ShapesPresent = false;
$filePath = 'upload/extract' . $fichier . '/shapes.txt';
if (IS_FILE($filePath)) {
    $handle = new SplFileObject($filePath, 'r');
    $ShapesPresent = true;
}

if ($handle && $ShapesPresent) {
    $handle->setFlags(SplFileObject::READ_CSV);
    $legende = $handle->fgetcsv();
    $Xkey = array_search('shape_pt_lat', $legende);
    $Ykey = array_search('shape_pt_lon', $legende);
    $Nbcolonnes = count($legende);
    $Nbshapes = 0;
    $ShapesPositionXY = [];
    $memoryLimit = 128 * 1024 * 1024; // 128 MB

    while (!$handle->eof()) {
        $data = $handle->fgetcsv();
        if ($data && count($data) > 2) {
            $ShapesPositionXY[$Nbshapes] = [$data[$Xkey], $data[$Ykey]];
            $Nbshapes++;

            // Vérifier l'utilisation de la mémoire
            if (memory_get_usage() > $memoryLimit) {
                $MessageErreur[0] = 'Processus arrêté : utilisation de la mémoire trop élevée. <br />';
                $MessageErreur[1] = 'Nombre de shapes : ' . $Nbshapes . '<br />';
                break;
            }
        }
    }
    //print_r($ShapesPositionXY);
} else {
    echo 'Erreur : Impossible d\'ouvrir le fichier ' . $filePath;
}
