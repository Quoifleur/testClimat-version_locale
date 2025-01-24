<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$routeCouleur = ['route_id', 'route_color', 'route_text_color'];
for ($i = 0; $i < $Nbfichierthéorique; $i++) {
    if ($ListeFichierGTFSprésent[$i][1] == 1) {
        $filePath = 'upload/extract' . $fichier . '/' . $ListeFichierGTFSprésent[$i][0];
        $handle = fopen($filePath, 'r');
        if ($handle) {
            $Legende = fgetcsv($handle);
            $Nbcolonnes = count($Legende);
            echo '<h3 id="' . $ListeFichierGTFSprésent[$i][0] . '">' . $ListeFichierGTFSprésent[$i][0] . '</h3>';
            echo '<table>';
            echo '<caption>' . $ListeFichierGTFSprésent[$i][0] . '</caption>';
            echo '<tr>';
            for ($j = 0; $j < $Nbcolonnes; $j++) {
                echo '<th>' . $Legende[$j] . '</th>';
            }
            echo '</tr>';
            $rowCount = 0;
            while (($data = fgetcsv($handle)) !== false && $rowCount < 10) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    if ($ListeFichierGTFSprésent[$i][0] == 'routes.txt' && $Legende[$y] == 'route_color' && $Legende[$y + 1] == 'route_text_color') {
                        $routeCouleur['route_id'][] = $data[$y -  6];
                        $routeCouleur['route_color'][] = $data[$y];
                        $routeCouleur['route_text_color'][] = $data[$y + 1];
                        echo '<td style="background:#' . $data[$y] . '; color:#' . $data[$y + 1] . ';">' . $data[$y] . '</td>';
                        $y++;
                        echo '<td style="background:#' . $data[$y - 1] . '; color:#' . $data[$y] . ';">' . $data[$y] . '</td>';
                    }/* elseif ($ListeFichierGTFSprésent[$i][0] == 'trips.txt' && $Legende[$y] == 'route_id') {
                        foreach ($routeCouleur['route_id'] as $key => $value) {
                            if ($value == $data[$y]) {
                                $route_colo[$y] = $routeCouleur['route_color'][$key];
                                $data[$y + 1] = $routeCouleur['route_text_color'][$key];
                            }
                        }
                        //echo '<td style="background:#' . $routeCouleur['route_color'][] . '; color:#' . $routeCouleur['route_text_color'] . ';">' . $data[$y] . '</td>';
                    }*/ else {
                        echo '<td>' . $data[$y] . '</td>';
                    }
                }
                echo '</tr>';
                $rowCount++;
            }
            echo '</table>';
            echo '<br />';
            if ($ListeFichierGTFSprésent[$i][0] == 'shapes.txt') {
                echo '<table>';
                echo '<caption>Liste des id dans le fichier shape et nombre de points</caption>';
                echo '<tr>';
                echo '<th>shape_id</th>';
                echo '<th>Nb points</th>';
                echo '<th>shape_id</th>';
                echo '<th>Nb points</th>';
                echo '</tr>';
                for ($j = 0; $j < $dico_shapes_id['Nb_shape_id']; $j++) {
                    if ($dico_shapes_id['Nb_shape_id']  > 100) {
                        $a = $dico_shapes_id['shape_names'][$j]['Nb_ligne'] ?? '';
                        $b = $dico_shapes_id['shape_names'][$j + 1]['Nb_ligne'] ?? '';
                        $c = $dico_shapes_id['shape_names'][$j]['name'] ?? '';
                        $d = $dico_shapes_id['shape_names'][$j + 1]['name'] ?? '';
                        $e = $dico_shapes_id['shape_names'][$j + 2]['name'] ?? '';
                        $f = $dico_shapes_id['shape_names'][$j + 2]['Nb_ligne'] ?? '';
                        $g = $dico_shapes_id['shape_names'][$j + 3]['name'] ?? '';
                        $h = $dico_shapes_id['shape_names'][$j + 3]['Nb_ligne'] ?? '';
                        echo '<tr>';
                        echo '<td>' . $c . '</td>';
                        echo '<td>' . $a . '</td>';
                        echo '<td style="border-left:solid; ">' . $d . '</td>';
                        echo '<td>' . $b . '</td>';
                        echo '<td style="border-left:solid; ">' . $e . '</td>';
                        echo '<td>' . $f . '</td>';
                        echo '<td style="border-left:solid; ">' . $g . '</td>';
                        echo '<td>' . $h . '</td>';
                        echo '</tr>';
                    } else {
                        $a = $dico_shapes_id['shape_names'][$j]['Nb_ligne'] ?? '';
                        $b = $dico_shapes_id['shape_names'][$j + 1]['Nb_ligne'] ?? '';
                        $c = $dico_shapes_id['shape_names'][$j]['name'] ?? '';
                        $d = $dico_shapes_id['shape_names'][$j + 1]['name'] ?? '';
                        echo '<tr>';
                        echo '<td>' . $c . '</td>';
                        echo '<td>' . $a . '</td>';
                        echo '<td  style="border-left:solid; ">' . $d . '</td>';
                        echo '<td>' . $b . '</td>';
                        echo '</tr>';
                    }
                }
                echo '<tr>';
                echo '<td><b>Total Id</b></td>';
                echo '<td><b>Total shapes</b></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . $dico_shapes_id['Nb_shape_id'] . '</td>';
                echo '<td>' . $Nbshapes . '</td>';
                echo '</table>';
            }
            fclose($handle);
        } else {
            echo 'Erreur : Impossible d\'ouvrir le fichier ' . $filePath;
        }
    }
}
