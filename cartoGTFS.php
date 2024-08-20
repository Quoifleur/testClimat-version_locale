<?php
function baricentre($array)
{
    $lat = 0;
    $long = 0;
    $somme = 0;
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i][4]);
    }
    $lat = $somme / $n;
    $somme = 0;
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i][5]);
    }
    $long = $somme / $n;
    return $lat . ',' . $long;
}
if ($fichierChargé) {
    $fichierStops = file('upload/extract/' . $fichier . '/stops.txt');
    $Nbligne = count($fichierStops);
    for ($i = 0; $i < $Nbligne; $i++) {
        $Info[$i] = explode(',', $fichierStops[$i]);
        $stop[$i][0] = $Info[$i][2];
        $stop[$i][1] = $Info[$i][4];
        $stop[$i][2] = $Info[$i][5];
    }
    //baricentre
    $coordo = explode(',', baricentre($Info));
    //echo $coordo[0] . ',' . $coordo[1];
    $lat = json_encode($coordo[0]);
    $long = json_encode($coordo[1]);
    $NbStops = json_encode($Nbligne);
    $fichierShapes = file('upload/extract/' . $fichier . '/shapes.txt');
    //$Nbligne = count($fichierShapes);
    for ($i = 0; $i < 10000; $i++) {
        $Info[$i] = explode(',', $fichierShapes[$i]);
    }
    $id = $Info[0][0];
    $forme[0][0] = $Info[1][1];
    $forme[0][1] = $Info[1][2];
    $y = 1;
    for ($i = 0; $i < $Nbligne; $i++) {
        $forme[$i][0] = $Info[$i][1];
        $forme[$i][1] = $Info[$i][2];
        //if ($Info[$y][0] == $Info[$i][0]) {}
        $y++;
    }
    //création du fichier geojson
    $fichierGEOJSON = fopen('upload/extract/' . $fichier . '/shapes.geojson', 'w');
    fwrite($fichierGEOJSON, '{
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": [');
    $sautDeLigne = ' \n ';
    //fwrite($fichierGEOJSON, $sautDeLigne);
    //fwrite($fichierGEOJSON, '{"type": "LineString", "coordinates": [');
    for ($i = 1; $i < $Nbligne; $i++) {
        fwrite($fichierGEOJSON, '[' . $forme[$i][1] . ',' . $forme[$i][0] . ']');
        if (isset($forme[$i + 1][0])) {
            fwrite($fichierGEOJSON, ',');
        }
    }
    fwrite($fichierGEOJSON, ']},');
    fwrite($fichierGEOJSON, '"properties": {"name": "' . $id . '"}');
    fwrite($fichierGEOJSON, '}]}');
}
