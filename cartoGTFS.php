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
    $fichierBrut = file('upload/extract/' . $fichier . '/stops.txt');
    $Legende = explode(',', $fichierBrut[0]);
    $Nbligne = count($fichierBrut);
    $Nbcolonnes = count($Legende);
    for ($i = 0; $i < $Nbligne; $i++) {
        $Info[$i] = explode(',', $fichierBrut[$i]);
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
}
