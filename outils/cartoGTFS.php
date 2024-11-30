<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require('src/function_geojson.php');
if ($fichierChargé) {
    $fichierStops = file('upload/extract/' . $fichier . '/stops.txt');
    $Nbligne = count($fichierStops);
    for ($i = 0; $i < $Nbligne; $i++) {
        $Info[$i] = explode(',', $fichierStops[$i]);
        $stop[$i]['name'] = $Info[$i][2];
        $stop[$i]['x'] = $Info[$i][4];
        $stop[$i]['y'] = $Info[$i][5];
    }
    //baricentre
    $coordo = explode(',', baricentre($Info));
    //echo $coordo[0] . ',' . $coordo[1];
    $lat = json_encode($coordo[0]);
    $long = json_encode($coordo[1]);
    $NbStops = json_encode($Nbligne);
    $fichierShapes = file('upload/extract/' . $fichier . '/shapes.txt');
    $Nbligne = count($fichierShapes);
    //echo $Nbligne;
    for ($i = 0; $i < 100000; $i++) {
        $Info[$i] = explode(',', $fichierShapes[$i]);
        $forme[$i + 1][0] = $Info[$i][1];
        $forme[$i + 1][1] = $Info[$i][2];
    }
    $id = str_replace('"', '', $Info[1][0]);
    //print_r($forme);
    //$forme[0][0] = $Info[1][1];
    //$forme[0][1] = $Info[1][2];
    $y = 1;
    //for ($i = 0; $i < $Nbligne; $i++) {
    //if ($Info[$y][0] == $Info[$i][0]) {}
    //$y++;
    //}
    //création du fichier geojson
    $fichierGEOJSON = fopen('upload/extract/' . $fichier . '/shapes.geojson', 'w');
    fwrite($fichierGEOJSON, '{
    "type": "FeatureCollection",
    "name": "' . $id . '",
    "features": [
        ' . "\t" . '{
            ' . "\t" . '"type": "Feature",
            ' . "\t" . '"geometry": {
            ' . "\t" . '"type": "LineString",
             ' . "\t" . '"coordinates": [');
    $sautDeLigne = ' \r\n ';
    //fwrite($fichierGEOJSON, $sautDeLigne);
    //fwrite($fichierGEOJSON, '{"type": "LineString", "coordinates": [');
    for ($i = 1; $i < 100000; $i++) {
        fwrite($fichierGEOJSON, "\r\n[" . $forme[$i][0] . "," . $forme[$i][1] . "]");
        if (isset($forme[$i + 1][0])) {
            fwrite($fichierGEOJSON, ",");
        }
    }
    fwrite($fichierGEOJSON, "]},");
    fwrite($fichierGEOJSON, "\r\n\"properties\": {\"name\": \"" . $id . "\"}");
    fwrite($fichierGEOJSON, "}]}");
}
