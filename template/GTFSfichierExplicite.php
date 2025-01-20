<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
                    echo '<td>' . $data[$y] . '</td>';
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
                echo '<th>Nombre de points</th>';
                echo '</tr>';
                for ($j = 0; $j < $dico_shapes_id['Nb_shape_id']; $j++) {
                    echo '<tr>';
                    echo '<td>' . $dico_shapes_id['shape_names'][$j]['name'] . '</td>';
                    echo '<td>' . $dico_shapes_id['shape_names'][$j]['Nb_ligne'] . '</td>';
                    echo '</tr>';
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
