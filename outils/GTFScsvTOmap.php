<?php
//ini_set('memory_limit', '128M'); // Augmente la limite de mémoire à 256 MB

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

require('GTFSarrays.php');

//trips
$filePath = 'upload/extract' . $fichier . '/trips.txt';
$handle = fopen($filePath, 'r');
if ($handle) {
    $legende = fgetcsv($handle);
    $Nbtrips = count($legende);
    $NbtripsVariables = count($trips);
    for ($i = 0; $i < $NbtripsVariables; $i++) {
        $trips[array_keys($trips)[$i]] = array_search(array_keys($trips)[$i], $legende);
    }
    $Nbpoints = 0;
    if (isset($trips['route_id']) && isset($trips['service_id']) && isset($trips['trip_id'])) {
        while (($data = fgetcsv($handle)) !== false) {
            for ($i = 0; $i < $NbtripsVariables; $i++) {
                $TripInfo[$Nbpoints][array_keys($trips)[$i]] = $data[$trips[array_keys($trips)[$i]]];
            }
            $Nbpoints++;
        }
        //echo $Nbpoints;
        fclose($handle);
    } else {
        $MessageErreur[] = 'Erreur : Arrêt du processus trips';
    }
}
//print_r($TripInfo);
//routes
$filePath = 'upload/extract' . $fichier . '/routes.txt';
$handle = fopen($filePath, 'r');
if ($handle) {
    $legende = fgetcsv($handle);
    $Nbroutes = count($legende);
    $NbroutesVariables = count($trips);
    for ($i = 0; $i < $NbroutesVariables; $i++) {
        $routes[array_keys($routes)[$i]] = array_search(array_keys($routes)[$i], $legende);
    }
    $Nbpoints = 0;
    if (isset($routes['route_id'])) {
        while (($data = fgetcsv($handle)) !== false) {
            for ($i = 0; $i < $NbroutesVariables; $i++) {
                $key = array_keys($routes)[$i];
                //echo $key . '<br />';
                $index = $routes[$key];
                //echo $index . '<br />';
                if (is_numeric($index)) {
                    $RouteInfo[$Nbpoints][array_keys($routes)[$i]] = $data[$routes[array_keys($routes)[$i]]];
                } else {
                    $RouteInfo[$Nbpoints][array_keys($routes)[$i]] = null;
                }
                //$RouteInfo[$Nbpoints][array_keys($routes)[$i]] = $data[$routes[array_keys($routes)[$i]]];
            }
            $Nbpoints++;
        }
        //echo $Nbpoints;
        fclose($handle);
    } else {
        $MessageErreur[] = 'Erreur : Arrêt du processus routes';
    }
}
//print_r($RouteInfo);
//stops
$filePath = 'upload/extract' . $fichier . '/stops.txt';
$handle = fopen($filePath, 'r');
if ($handle) {
    $legende = fgetcsv($handle);
    $Nbcolonnes = count($legende);
    $NbstopsVariables = count($stops);
    for ($i = 0; $i < +$NbstopsVariables; $i++) {
        $stops[array_keys($stops)[$i]] = array_search(array_keys($stops)[$i], $legende) ?? null;
    }
    //print_r($stops);
    $Nbpoints = 0;
    if (isset($stops['stop_id'])) {
        while (($data = fgetcsv($handle)) !== false) {
            for ($i = 0; $i < $NbstopsVariables; $i++) {
                $key = array_keys($stops)[$i];
                //echo $key . '<br />';
                $index = $stops[$key];
                //echo $index . '<br />';
                if (is_numeric($index)) {
                    $stopsInfo[$Nbpoints][$key] = $data[$index];
                } else {
                    $stopsInfo[$Nbpoints][$key] = null;
                }
            }
            if (isset($data[$stops['stop_lat']]) && isset($data[$stops['stop_lon']])) {
                $StopsPositionXY[$Nbpoints] = [$data[$stops['stop_lat']], $data[$stops['stop_lon']]];
            } else {
                $StopsPositionXY[$Nbpoints] = [null, null]; // ou des valeurs par défaut
            }
            $Nbpoints++;
        }
        //echo $Nbpoints;
        fclose($handle);
    } else {
        $MessageErreur[] = 'Erreur : stop_id non trouvés dans le fichier stops.txt. Cette variable est requise.<br />';
        $MessageErreur[] = 'Erreur : Arrêt du processus stops';
    }
} else {
    echo 'Info : Impossible d\'ouvrir le fichier ' . $filePath;
}
$baricentre = explode(',', baricentrebis($StopsPositionXY ?? [0, 0]));

clearstatcache();
$ShapesPresent = false;
$filePath = 'upload/extract' . $fichier . '/shapes.txt';
if (file_exists($filePath) == true) {
    $handle = new SplFileObject($filePath, 'r') ?? null;
    $ShapesPresent = true ?? false;
}

//shapes
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
    $memoryLimit = $memoryLimit - 10;

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
    $MessageErreur[] = '<br>Info : Impossible d\'ouvrir le fichier ' . $filePath;
}
unset($value);
$NbtripsLIGNE = count($TripInfo);
for ($i = 0; $i < $NbtripsLIGNE; $i++) {
    $CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']] = [
        'trip_id' => $TripInfo[$i]['trip_id'],
        'route_id' => $TripInfo[$i]['route_id'],
        'route_color' => null,
        'route_text_color' => null,
    ];
    if (isset($RouteInfo)) {
        foreach ($CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']] as $key => $value) {
            if ($key == 'route_id') {
                foreach ($RouteInfo as $route) {
                    if ($route['route_id'] == $value) {
                        $CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']]['route_color'] = $route['route_color'];
                        $CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']]['route_text_color'] = $route['route_text_color'];
                    }
                }
            }
        }
    }
}

//print_r($CorrespondanceShapeRoute);
//print_r($MessageErreur);