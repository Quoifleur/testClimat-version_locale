<?php
function dessin_croix($array)
{
    $image = $array[0]['image'] ?? null;
    $couleur = $array[0]['couleur'] ?? null;
    $GLOBALimage = $image == null ? false : true;
    $GLOBALcouleur = $couleur == null ? false : true;
    for ($i = 1; $i < count($array); $i++) {
        $image = $GLOBALimage == false ? $array[$i]['image'] : $image;
        $couleur = $GLOBALcouleur == false ? $array[$i]['couleur'] : $couleur;
        $x = $array[$i]['x'];
        $y = $array[$i]['y'];
        imageline($image, $x - 3, $y, $x + 3, $y, $couleur);
        imageline($image, $x, $y - 3, $x, $y + 3, $couleur);
    }
}
function dessin_ligne($array)
{
    $image = $array[0]['image'] ?? null;
    $couleur = $array[0]['couleur'] ?? null;
    $point = $array[0]['point'] ?? false;
    $GLOBALimage = $image == null ? false : true;
    $GLOBALcouleur = $couleur == null ? false : true;
    for ($i = 1; $i < count($array); $i++) {
        $image = $GLOBALimage == false ? $array[$i]['image'] : $image;
        $couleur = $GLOBALcouleur == false ? $array[$i]['couleur'] : $couleur;
        $x1 = $array[$i]['x1'];
        $y1 = $array[$i]['y1'];
        $x2 = $array[$i]['x2'];
        $y2 = $array[$i]['y2'];
        imageline($image, $x1, $y1, $x2, $y2, $couleur);
        if ($point == true) {
            $pointatracer = [
                ['image' => $image, 'couleur' => null],
                ['x' => $x1, 'y' => $y1, 'couleur' => $couleur],
                ['x' => $x2, 'y' => $y2, 'couleur' => $couleur]
            ];
            dessin_croix($pointatracer);
        }
    }
}
