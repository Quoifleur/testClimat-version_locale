<?php
function baricentre($array)
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
function centroide($array)
{
    $lat = 0;
    $long = 0;
    $somme = 0;
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i]);
    }
    $lat = $somme / $n;
    $somme = 0;
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i]);
    }
    $long = $somme / $n;
    return [$lat, $long];
}

function geojson_extract($url)
{
    $fichierGEOJSON = file_get_contents($url);
    $geojson = json_decode($fichierGEOJSON, true);
    $features = $geojson['features'];
    return $features;
}
function geojson_shapeINarrays($features)
{
    $a = 0;
    $b = 0;
    $GLOBALx = array();
    $GLOBALy = array();
    $shape = array();
    for ($i = 0; isset($features[$i]); $i++) {
        //$index[$i]['id'] = $features[$i]['properties']['Name']; //id - A modifier en fonction de votre fichier geojson.
        //$index[$i]['name'] = $features[$i]['properties']['com_nom']; //name, A modifier en fonction de votre fichier geojson.
        $index[$i]['type'] = $features[$i]['geometry']['type'];
    }
    for ($i = 0; $i < count($index); $i++) {
        //$shape[$i]['id'] = $index[$i]['code_ligne'];
        $shape[$i]['type'] = $index[$i]['type'];
        switch ($index[$i]['type']) {
            case 'MultiPolygon':
                $index[$i]['barycentre'] = centroide($features[$i]['geometry']['coordinates'][0][0]);
                $index[$i]['Nbpoints'] = count($features[$i]['geometry']['coordinates'][0][0]);
                for ($j = 0; $j < $index[$i]['Nbpoints']; $j++) {
                    $GLOBALx[$a] = $features[$i]['geometry']['coordinates'][0][0][$j][0];
                    $GLOBALy[$a] = $features[$i]['geometry']['coordinates'][0][0][$j][1];
                    $shape[$i]['x'][$j] = $GLOBALx[$a];
                    $shape[$i]['y'][$j] = $GLOBALy[$a];
                    $a++;
                }
                break;
            case 'MultiLineString':
                $index[$i]['barycentre'] = centroide($features[$i]['geometry']['coordinates']);
                $index[$i]['Nbarray'] = count($features[$i]['geometry']['coordinates']);
                for ($k = 0; $k < $index[$i]['Nbarray']; $k++) {
                    $index[$i]['Nbpoints'][$b] = count($features[$i]['geometry']['coordinates'][$k]);
                    for ($j = 0; $j < $index[$i]['Nbpoints'][$b]; $j++) {
                        $GLOBALx[$a] = $features[$i]['geometry']['coordinates'][$k][$j][0];
                        $GLOBALy[$a] = $features[$i]['geometry']['coordinates'][$k][$j][1];
                        $shape[$i]['x'][$k][$j] = $GLOBALx[$a];
                        $shape[$i]['y'][$k][$j] = $GLOBALy[$a];
                        $a++;
                    }
                    $b++;
                }
                break;
            case 'MultiPoint':
                $index[$i]['barycentre'] = centroide($features[$i]['geometry']['coordinates']);
                $index[$i]['Nbpoints'] = count($features[$i]['geometry']['coordinates']);
                for ($j = 0; $j < $index[$i]['Nbpoints']; $j++) {
                    $GLOBALx[$a] = $features[$i]['geometry']['coordinates'][$j][0];
                    $GLOBALy[$a] = $features[$i]['geometry']['coordinates'][$j][1];
                    $shape[$i]['x'][$j] = $GLOBALx[$a];
                    $shape[$i]['y'][$j] = $GLOBALy[$a];
                    $a++;
                }
                break;
            case 'Polygon':
                $index[$i]['barycentre'] = centroide($features[$i]['geometry']['coordinates'][0]);
                $index[$i]['Nbpoints'] = count($features[$i]['geometry']['coordinates'][0]);
                for ($j = 0; $j < $index[$i]['Nbpoints']; $j++) {
                    $GLOBALx[$a] = $features[$i]['geometry']['coordinates'][0][$j][0];
                    $GLOBALy[$a] = $features[$i]['geometry']['coordinates'][0][$j][1];
                    $shape[$i]['x'][$j] = $GLOBALx[$a];
                    $shape[$i]['y'][$j] = $GLOBALy[$a];
                    $a++;
                }
                break;
            case 'LineString':
                $index[$i]['barycentre'] = centroide($features[$i]['geometry']['coordinates']);
                $index[$i]['Nbpoints'] = count($features[$i]['geometry']['coordinates']);
                for ($j = 0; $j < $index[$i]['Nbpoints']; $j++) {
                    $GLOBALx[$a] = $features[$i]['geometry']['coordinates'][$j][0];
                    $GLOBALy[$a] = $features[$i]['geometry']['coordinates'][$j][1];
                    $shape[$i]['x'][$j] = $GLOBALx[$a];
                    $shape[$i]['y'][$j] = $GLOBALy[$a];
                    $a++;
                }
                break;
            default: // point
                $index[$i]['barycentre'] = centroide($features[$i]['geometry']['coordinates']);
                $index[$i]['Nbpoints'] = count($features[$i]['geometry']['coordinates']);
                for ($j = 0; $j < $index[$i]['Nbpoints']; $j++) {
                    $GLOBALx[$a] = $features[$i]['geometry']['coordinates'][0];
                    $GLOBALy[$a] = $features[$i]['geometry']['coordinates'][1];
                    $shape[$i]['x'][$j] = $GLOBALx[$a];
                    $shape[$i]['y'][$j] = $GLOBALy[$a];
                    $a++;
                }
                break;
        }
    }
    return array('GLOBALx' => $GLOBALx, 'GLOBALy' => $GLOBALy, 'shape' => $shape, 'index' => $index);
}
function geojson_drawing($GLOBALshape, $GLOBALcouleur)
{
    $GLOBALx = $GLOBALshape['GLOBALx'];
    $GLOBALy = $GLOBALshape['GLOBALy'];
    $index = $GLOBALshape['index'];
    $shape = $GLOBALshape['shape'];
    $tailleIndex = count($index);
    // Trouver les valeurs minimales et maximales de longitude et de latitude
    $max_lat = max($GLOBALy);
    $min_lat = min($GLOBALy);
    $max_lon = max($GLOBALx);
    $min_lon = min($GLOBALx);

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
    return imagepng($gd, 'carte.png');
    imagedestroy($gd);
}
