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
$stops_id = '';
$stops = [
    "stop_id" => null,
    "stop_code" => null,
    "stop_name" => null,
    "tts_stop_name" => null,
    "stop_desc" => null,
    "stop_lat" => null,
    "stop_lon" => null,
    "zone_id" => null,
    "stop_url" => null,
    "location_type" => null,
    "parent_station" => null,
    "stop_timezone" => null,
    "wheelchair_boarding" => null,
    "level_id" => null,
    "platform_code" => null,
];

$filePath = 'upload/extract' . $fichier . '/stops.txt';
$handle = fopen($filePath, 'r');
if ($handle) {
    $legende = fgetcsv($handle);
    $Nbcolonnes = count($legende);
    $NbstopsVariables = count($stops);
    for ($i = 0; $i < $NbstopsVariables; $i++) {
        $stops[array_keys($stops)[$i]] = array_search(array_keys($stops)[$i], $legende);
    }

    $Nbpoints = 0;
    if (isset($stops['stop_lat']) && isset($stops['stop_lon'])) {
        while (($data = fgetcsv($handle)) !== false) {
            for ($i = 0; $i < $NbstopsVariables; $i++) {
                $stopsInfo[$Nbpoints][array_keys($stops)[$i]] = $data[$stops[array_keys($stops)[$i]]];
            }
            //print_r($legende);
            //print_r($data);
            $StopsPositionXY[$Nbpoints] = [$data[$stops['stop_lat']], $data[$stops['stop_lon']]];
            $Nbpoints++;
        }
        echo $Nbpoints;
        //print_r($stopsInfo);
        //print_r($PositionXY);
        fclose($handle);
    } else {
        $MessageErreur[0] = 'Erreur : stop_lat ou stop_lon non trouvés dans le fichier stops.txt. <br />';
        $MessageErreur[1] = 'Arrêt du processus.';
    }
} else {
    echo 'Info : Impossible d\'ouvrir le fichier ' . $filePath;
}

$baricentre = explode(',', baricentrebis($StopsPositionXY ?? [0, 0]));
//print_r($baricentre);

clearstatcache();
$ShapesPresent = false;
$filePath = 'upload/extract' . $fichier . '/shapes.txt';
if (file_exists($filePath) == true) {
    $handle = new SplFileObject($filePath, 'r') ?? null;
    $ShapesPresent = true ?? false;
}

//echo isset($handle) ? 'true' : 'false';
//echo isset($ShapesPresent) ? 'true' : 'false';
if ($handle == true && $ShapesPresent == true) {
    $handle->setFlags(SplFileObject::READ_CSV);
    $legende = $handle->fgetcsv();
    $Xkey = array_search('shape_pt_lat', $legende);
    $Ykey = array_search('shape_pt_lon', $legende);
    $Nbcolonnes = count($legende);
    $Nbshapes = 0;
    $NbligneParShape = 0;
    $ShapesPositionXY = [];
    $dico_shapes_id = [
        'Nb_shape_id' => 0,
        'shape_names' => [
            'name' => null,
            'Nb_ligne' => 0,
        ]
    ];
    $shape_id = '';
    $memoryLimit = 128 * 1024 * 1024; // 128 MB
    $memoryLimit = 128 * 1024 * 1024 - 10;

    while (!$handle->eof()) {
        $data = $handle->fgetcsv();
        if ($data && count($data) > 2) {
            // Vérifier l'utilisation de la mémoire
            if (memory_get_usage() > $memoryLimit) {
                $MessageErreur[] = 'ERREUR : Processus arrêté : utilisation de la mémoire trop élevée. <br />';
                $MessageErreur[] = 'Info : Nombre de shapes : ' . $Nbshapes . '<br />';
                break;
            }
            if ($shape_id != $data[0]) {
                $shape_id = $data[0];
                $dico_shapes_id['Nb_shape_id']++;
                $dico_shapes_id['shape_names'][] = [
                    'name' => $shape_id,
                    'Nb_ligne' => $NbligneParShape,
                ];
                $NbligneParShape = 0;
            }
            $ShapesPositionXY[$Nbshapes] = [$shape_id, $data[$Xkey], $data[$Ykey]];
            $Nbshapes++;
            if ($shape_id == $ShapesPositionXY[$Nbshapes - 1][0] && $Nbshapes > 0) {
                $NbligneParShape++;
            } else {
                $NbligneParShape = 1;
            }
        }
    }
    $lastshape = $dico_shapes_id['Nb_shape_id'];
    for ($i = 0; $i < $lastshape; $i++) {
        if (isset($dico_shapes_id['shape_names'][$i + 1]['Nb_ligne'])) {
            $dico_shapes_id['shape_names'][$i] = [
                'name' => $dico_shapes_id['shape_names'][$i]['name'],
                'Nb_ligne' => $dico_shapes_id['shape_names'][$i + 1]['Nb_ligne']
            ];
        } else {
            $dico_shapes_id['shape_names'][$lastshape - 1] = [
                'name' => $dico_shapes_id['shape_names'][$lastshape - 1]['name'],
                'Nb_ligne' => $NbligneParShape,
            ];
        }
    }
} else {
    $MessageErreur[] =  '<br>Info : Impossible d\'ouvrir le fichier ' . $filePath;
}
