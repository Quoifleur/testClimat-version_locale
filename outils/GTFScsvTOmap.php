<?php
//ini_set('memory_limit', '128M'); // Augmente la limite de mémoire à 256 MB
$start_time = 0;
$end_time = 0;
$start_time = hrtime(true);

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
            $TripInfo[$Nbpoints]['trip_id'] = $data[$trips['trip_id']];
            $TripInfo[$Nbpoints]['service_id'] = $data[$trips['service_id']];
            $TripInfo[$Nbpoints]['route_id'] = $data[$trips['route_id']];
            if (isset($trips['shape_id'])) {
                $TripInfo[$Nbpoints]['shape_id'] = $data[$trips['shape_id']];
            } else {
                $TripInfo[$Nbpoints]['shape_id'] = null;
            }
            $Nbpoints++;
        }
        //echo $Nbpoints;
        fclose($handle);
    } else {
        $MessageErreur[] = 'Erreur : Arrêt du processus trips';
    }
}
unset($trips, $Nbtrips, $Nbpoints, $legende, $data, $filePath);
//print_r($TripInfo);
//calendar_dates
$filePath = 'upload/extract' . $fichier . '/calendar.txt';
$handle = fopen($filePath, 'r') ?? null;
if ($handle) {
    $legende = fgetcsv($handle);
    $NbCalendar = count($legende);
    $NbCalendarVariables = count($calendar);
    for ($i = 0; $i < $NbCalendarVariables; $i++) {
        $calendar[array_keys($calendar)[$i]] = array_search(array_keys($calendar)[$i], $legende);
    }
    $Nbpoints = 0;
    if (isset($calendar['service_id'])) {
        while (($data = fgetcsv($handle)) !== false) {
            $CalendarInfo[$Nbpoints] = [
                'service_id' => $data[$calendar['service_id']],
                $data[$calendar['service_id']] => ''
            ];

            for ($i = 0; $i < 7; $i++) {
                $CalendarInfo[$Nbpoints][$data[$calendar['service_id']]] .= $data[$calendar['monday'] + $i];
                $CalendarInfo[$Nbpoints][$data[$calendar['service_id']]] .= ($i == 6) ? '' : '-';
            }

            $Nbpoints++;
        }
    } else {
        $MessageErreur[] = 'Erreur : Arrêt du processus trips';
    }
    fclose($handle);
}
unset($Calendar, $NbCalendar, $Nbpoints, $legende, $data, $filePath);
//print_r($CalendarInfo);

//routes
$filePath = 'upload/extract' . $fichier . '/routes.txt';
$handle = fopen($filePath, 'r');
if ($handle) {
    $legende = fgetcsv($handle);
    $Nbroutes = count($legende);
    //$NbroutesVariables = count($trips);
    for ($i = 0; $i < $NbtripsVariables; $i++) {
        $routes[array_keys($routes)[$i]] = array_search(array_keys($routes)[$i], $legende);
    }
    $Nbpoints = 0;
    if (isset($routes['route_id'])) {
        while (($data = fgetcsv($handle)) !== false) {
            $RouteInfo[$Nbpoints]['route_id'] = $data[$routes['route_id']];
            $RouteInfo[$Nbpoints]['route_color'] = $data[$routes['route_color']];
            $RouteInfo[$Nbpoints]['route_text_color'] = $data[$routes['route_text_color']];

            $Nbpoints++;
        }
        fclose($handle);
    } else {
        $MessageErreur[] = 'Erreur : Arrêt du processus routes';
    }
}
unset($routes, $Nbroutes, $Nbpoints, $legende, $data, $filePath);
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
        $MessageErreur[] = 'Info : Nombre d\'arrêts : ' . $Nbpoints;
        $MessageErreur[] = 'Info : Nombre de variables dans stops.txt : ' . $NbstopsVariables;
    } else {
        $MessageErreur[] = 'Erreur : stop_id non trouvés dans le fichier stops.txt. Cette variable est requise.<br />';
        $MessageErreur[] = 'Erreur : Arrêt du processus stops';
    }
} else {
    echo 'Info : Impossible d\'ouvrir le fichier ' . $filePath;
}
$baricentre = explode(',', baricentrebis($StopsPositionXY ?? [0, 0]));
unset($stops, $NbstopsVariables, $legende, $data, $filePath);
clearstatcache();
$ShapesPresent = false;
$filePath = 'upload/extract' . $fichier . '/shapes.txt';
if (file_exists($filePath) == true) {
    $handle = new SplFileObject($filePath, 'r') ?? null;
    $ShapesPresent = true ?? false;
}
//shapes
// Shapes
$ShapesPresent = false;
$filePath = 'upload/extract' . $fichier . '/shapes.txt';
if (file_exists($filePath)) {
    $handle = new SplFileObject($filePath, 'r');
    $ShapesPresent = true;
}

$shape_id = '';
$memoryLimit = 127000000; // 128 MB
if ($handle && $ShapesPresent) {
    $handle->setFlags(SplFileObject::READ_CSV);
    $legende = $handle->fgetcsv();
    $Nbcolonnes = count($legende);
    $Nbshapes = 0;
    $NbligneParShape = 0;
    $dico_shapes_id = [
        'Nb_shape_id' => 0,
        'shape_names' => []
    ];

    while (!$handle->eof()) {
        if (memory_get_usage() >= $memoryLimit) {
            $handle->fseek(0, SEEK_SET); // Rewind the file pointer to the beginning
            $handle->fgetcsv(); // Skip the header line
            break; // Exit the loop if memory limit is reached
        }
        $data = $handle->fgetcsv();
        if ($data && count($data) > 2) {
            if ($shape_id != $data[0]) {
                $shape_id = $data[0];
                $dico_shapes_id['Nb_shape_id']++;
                $dico_shapes_id['shape_names'][] = [
                    'name' => $shape_id,
                    'Nb_ligne' => 0,
                ];
            }
            $ShapesPositionXY[] = [$shape_id];
            $dico_shapes_id['shape_names'][$dico_shapes_id['Nb_shape_id'] - 1]['Nb_ligne']++;
        }
    }
} else {
    $messageErreur[] = "Info : Impossible d'ouvrir le fichier $filePath.";
}
unset($Xkey, $Ykey, $Nbcolonnes, $NbligneParShape, $data, $legende,  $ShapesPositionXY);
if (isset($TripInfo)) {
    $NbtripsLIGNE = count($TripInfo);
    for ($i = 0; $i < $NbtripsLIGNE; $i++) {
        $CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']] = [
            'trip_id' => $TripInfo[$i]['trip_id'],
            'route_id' => $TripInfo[$i]['route_id'],
            'service_id' => $TripInfo[$i]['service_id'],
            'route_color' => null,
            'route_text_color' => null,
            'calendar' => null
        ];
        if (isset($CalendarInfo)) {
            foreach ($CalendarInfo as $key => $value) {
                if ($TripInfo[$i]['service_id'] == $value['service_id']) {
                    $CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']]['calendar'] = $value[$TripInfo[$i]['service_id']];
                }
            }
        }
        if ($CorrespondanceShapeRoute[$TripInfo[$i]['shape_id']]['service_id']) {
        }
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
}
if (isset($RouteInfo)) {
    for ($i = 0; $i < count($RouteInfo); $i++) {
        $routeCouleur['route_color'][] = $RouteInfo[$i]['route_color'];
        $routeCouleur['route_text_color'][] = $RouteInfo[$i]['route_text_color'] ?? contrasteColor($RouteInfo[$i]['route_color']);
    }
}
unset($TripInfo, $RouteInfo, $CalendarInfo);

$end_time = hrtime(true);
$execution_time_GTFcsvTOmap = $end_time - $start_time;
