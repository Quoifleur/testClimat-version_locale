<?

$url = 'upload/extract/' . $fichier . '/shapes.geojson';
$GLOBALcouleur = ['ligne' => [0, 0, 255], 'point' => [255, 255, 255], 'surface' => [50, 50, 255], 'autre' => [100, 100, 255]];
$features = geojson_extract($url);
$GLOBALshape = geojson_shapeINarrays($features);
centroide($GLOBALshape);

$NbStops = count($stop);
for ($i = 1; $i < $NbStops; $i++) {
    $STOPglobalX[$i - 1] = $stop[$i]['x'];
    $STOPglobalY[$i - 1] = $stop[$i]['y'];
}

$GLOBALx = $GLOBALshape['GLOBALx'];
$GLOBALy = $GLOBALshape['GLOBALy'];
$index = $GLOBALshape['index'];
$shape = $GLOBALshape['shape'];
$tailleIndex = count($index);
// Trouver les valeurs minimales et maximales de longitude et de latitude
$max_lat = max($STOPglobalY);
$min_lat = min($STOPglobalY);
$max_lon = max($STOPglobalX);
$min_lon = min($STOPglobalX);

// Créer une image vide
$largeur = 1000;
$hauteur = 1000;

// Calculer les facteurs d'échelle
$lon_scale = $largeur / ($max_lon - $min_lon);
$lat_scale = $hauteur / ($max_lat - $min_lat);

$gd = imagecreatetruecolor($largeur, $hauteur);
$couleur = imagecolorallocate($gd, $GLOBALcouleur['autre'][0], $GLOBALcouleur['autre'][1], $GLOBALcouleur['autre'][2]);
$ligne = imagecolorallocate($gd, $GLOBALcouleur['ligne'][0], $GLOBALcouleur['ligne'][1], $GLOBALcouleur['ligne'][2]);
$point = imagecolorallocate($gd, $GLOBALcouleur['point'][0], $GLOBALcouleur['point'][1], $GLOBALcouleur['point'][2]);
$Nbpoints = count($GLOBALx);

for ($j = 0; $j < $Nbpoints; $j++) {
    $x = ($GLOBALx[$j] - $min_lon) * $lon_scale;
    $y = ($max_lat - $GLOBALy[$j]) * $lat_scale; // Inverser l'axe y pour correspondre aux coordonnées géographiques
    if ($x >= 0 && $x < $largeur && $y >= 0 && $y < $hauteur) {
        imagesetpixel($gd, round($x), round($y), $couleur);
    }
}
for ($i = 0; $i < $tailleIndex; $i++) {
    if ($shape[$i]['type'] == 'Point' || $shape[$i]['type'] == 'MultiPoint') {
        for ($j = 0; $j < $index[$i]['Nbpoints']; $j++) {
            $x = ($shape[$i]['x'][$j] - $min_lon) * $lon_scale;
            $y = ($max_lat - $shape[$i]['y'][$j]) * $lat_scale;
            $ptsatracer = [
                ['image' => $gd, 'couleur' => null, 'point' => false],
                ['x' => $x, 'y' => $y, 'couleur' => $point],
            ];
            dessin_croix($ptsatracer);
            $barycentre = [
                ['image' => $gd, 'couleur' => null, 'point' => false],
                ['x' => $index[$i]['barycentre'][0], 'y' => $index[$i]['barycentre'][1], 'couleur' => $point],
            ];
            dessin_croix($barycentre);
        }
    } elseif ($shape[$i]['type'] != 'MultiLineString') {
        for ($j = 0; $j < $index[$i]['Nbpoints'] - 1; $j++) {
            $x1 = ($shape[$i]['x'][$j] - $min_lon) * $lon_scale;
            $y1 = ($max_lat - $shape[$i]['y'][$j]) * $lat_scale;
            $x2 = ($shape[$i]['x'][$j + 1] - $min_lon) * $lon_scale;
            $y2 = ($max_lat - $shape[$i]['y'][$j + 1]) * $lat_scale;
            $ligneatracer = [
                ['image' => $gd, 'couleur' => null, 'point' => false],
                ['x1' => $x1, 'y1' => $y1, 'x2' => $x2, 'y2' => $y2, 'couleur' => $ligne],
            ];
            dessin_ligne($ligneatracer);
            $barycentre = [
                ['image' => $gd, 'couleur' => null, 'point' => false],
                ['x' => $index[$i]['barycentre'][0], 'y' => $index[$i]['barycentre'][1], 'couleur' => $point],
            ];
            dessin_croix($barycentre);
        }
    } else {
        //print_r($shape);
        for ($k = 0; $k < $index[$i]['Nbarray']; $k++) {
            for ($j = 0; $j < $index[$i]['Nbpoints'][$k] - 1; $j++) {
                $x1 = ($shape[$i]['x'][$k][$j] - $min_lon) * $lon_scale;
                $y1 = ($max_lat - $shape[$i]['y'][$k][$j]) * $lat_scale;
                $x2 = ($shape[$i]['x'][$k][$j + 1] - $min_lon) * $lon_scale;
                $y2 = ($max_lat - $shape[$i]['y'][$k][$j + 1]) * $lat_scale;
                $ligneatracer = [
                    ['image' => $gd, 'couleur' => null, 'point' => false],
                    ['x1' => $x1, 'y1' => $y1, 'x2' => $x2, 'y2' => $y2, 'couleur' => $ligne],
                ];
                dessin_ligne($ligneatracer);
                $barycentre = [
                    ['image' => $gd, 'couleur' => null, 'point' => false],
                    ['x' => $index[$i]['barycentre'][0], 'y' => $index[$i]['barycentre'][1], 'couleur' => $point],
                ];
                dessin_croix($barycentre);
            }
        }
    }
}
//print_r($stop);
for ($i = 1; $i < $NbStops; $i++) {
    $x = ($stop[$i]['x'] - $min_lon) * $lon_scale;
    $y = ($max_lat - $stop[$i]['y']) * $lat_scale;
    $ptsatracer = [
        ['image' => $gd, 'couleur' => null, 'point' => false],
        ['x' => $x, 'y' => $y, 'couleur' => $point],
    ];
    dessin_croix($ptsatracer);
}
return imagepng($gd, 'carte.png');
imagedestroy($gd);
