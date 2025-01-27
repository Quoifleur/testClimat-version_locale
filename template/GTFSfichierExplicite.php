<?php
for ($i = 0; $i < count($RouteInfo); $i++) {
    $routeCouleur['route_color'][] = $RouteInfo[$i]['route_color'] ?? 'FFFFFF';
    $routeCouleur['route_text_color'][] = $RouteInfo[$i]['route_text_color'] ?? '6F6951';
}
//print_r($routeCouleur);
//print_r($RouteInfo);
for ($i = 0; $i < $Nbfichierthéorique; $i++) {
    if ($ListeFichierGTFSprésent[$i][1] == 1) {
        $filePath = 'upload/extract' . $fichier . '/' . $ListeFichierGTFSprésent[$i][0];
        $handle = fopen($filePath, 'r');
        if ($handle) {
            $Legende = fgetcsv($handle);
            $Nbcolonnes = count($Legende);
            echo '<h3 id="' . $ListeFichierGTFSprésent[$i][0] . '">' . $ListeFichierGTFSprésent[$i][0] . '</h3><a href="https://gtfs.org/documentation/schedule/reference/#' . str_replace('.', '', $ListeFichierGTFSprésent[$i][0]) . '" target="_blank">Documentation</a>';
            echo '<table>';
            echo '<caption>' . $ListeFichierGTFSprésent[$i][0] . '</caption>';
            echo '<tr>';
            for ($j = 0; $j < $Nbcolonnes; $j++) {
                echo '<th>' . $Legende[$j] . '</th>';
            }
            echo '</tr>';
            $rowCount = 0;
            $rénitialisation = false;
            while (($data = fgetcsv($handle)) !== false && $rowCount < 20) {
                echo '<tr>';
                for ($y = 0; $y < $Nbcolonnes; $y++) {
                    if ($ListeFichierGTFSprésent[$i][0] == 'routes.txt') {
                        //$routeCouleur['route_id'][] = $data[$y -  6];
                        if ($Legende[$y] == 'route_type') {
                            switch ($data[$y]) {
                                case 3:
                                    echo '<td class="table_neutre">' . $data[$y] . ' <img class="bus-icon" src="icones/route_type_3_bus.png" alt="Bus"/></td>';
                                    break;
                                default:
                                    echo '<td>' . $data[$y] . '</td>';
                            }
                            $y++;
                        }
                        if ($Legende[$y] == 'route_id') {
                            echo '<td style="background:#' . $routeCouleur['route_color'][$rowCount] . '; color:#' . $routeCouleur['route_text_color'][$rowCount] . ';">' . $data[$y] . '</td>';
                            $y++;
                        }
                        if ($Legende[$y] == 'route_color') {
                            echo '<td style="background:#' . $routeCouleur['route_color'][$rowCount] . '; color:#' . $routeCouleur['route_text_color'][$rowCount] . ';">' . $data[$y] . '</td>';
                            $y++;
                        }
                        if ($Legende[$y] == 'route_text_color') {
                            echo '<td style="background:#' . $routeCouleur['route_color'][$rowCount] . '; color:#' . $routeCouleur['route_text_color'][$rowCount] . ';">' . $data[$y] . '</td>';
                            $y++;
                        }

                        echo '<td>' . $data[$y] . '</td>';

                    } elseif ($ListeFichierGTFSprésent[$i][0] == 'agency.txt') {
                        if ($Legende[$y] == 'agency_url') {
                            echo '<td><a href="' . $data[$y] . '">' . $data[$y] . '</a></td>';
                            $y++;
                        }
                        echo '<td>' . $data[$y] . '</td>';
                    } elseif ($ListeFichierGTFSprésent[$i][0] == 'stops.txt') {
                        if ($Legende[$y] == 'route_id') {
                            echo '<td style="background:#' . $routeCouleur['route_color'][$rowCount] . '; color:#' . $routeCouleur['route_text_color'][$rowCount] . ';">' . $data[$y] . '</td>';
                            $y++;
                        }
                        if ($Legende[$y] == 'wheelchair_boarding') {
                            switch ($data[$y]) {
                                case 0:
                                    echo '<td class="table_attention">' . $data[$y] . ' <img class="wheelchair-icon" src="icones/wheelchair_accessible_0.png" alt="Accessibilité inconnue"/></td>';
                                    break;
                                case 1:
                                    echo '<td class="table_A_noter">' . $data[$y] . ' <img class="wheelchair-icon" src="icones/wheelchair_accessible_1.png" alt="Accessible en fauteuil roulant"/></td>';
                                    break;
                                case 2:
                                    echo '<td class="table_attention">' . $data[$y] . ' <img class="wheelchair-icon" src="icones/wheelchair_accessible_2.png" alt="Non accessible en fauteuil roulant"/></td>';
                                    break;
                            }
                            $y++;
                        }
                        echo '<td>' . $data[$y] . '</td>';
                    } elseif ($ListeFichierGTFSprésent[$i][0] == 'trips.txt') {

                        if ($Legende[$y] == 'route_id') {
                            echo '<td style="background:#' . $routeCouleur['route_color'][$y] . '; color:#' . $routeCouleur['route_text_color'][$y] . ';">' . $data[$y] . '</td>';
                            $y++;
                        }
                        if ($Legende[$y] == 'wheelchair_accessible') {
                            switch ($data[$y]) {
                                case 0:
                                    echo '<td class="table_attention">' . $data[$y] . ' <img class="wheelchair-icon" src="icones/wheelchair_accessible_0.png" alt="Accessibilité inconnue"/></td>';
                                    break;
                                case 1:
                                    echo '<td class="table_A_noter">' . $data[$y] . ' <img class="wheelchair-icon" src="icones/wheelchair_accessible_1.png" alt="Accessible en fauteuil roulant"/></td>';
                                    break;
                                case 2:
                                    echo '<td class="table_attention">' . $data[$y] . ' <img class="wheelchair-icon" src="icones/wheelchair_accessible_2.png" alt="Non accessible en fauteuil roulant"/></td>';
                                    break;
                            }
                            $y++;
                        }
                        if ($Legende[$y] == 'bikes_allowed') {
                            switch ($data[$y]) {
                                case 0:
                                    echo '<td class="table_attention">' . $data[$y] . ' <img class="bike-icon" src="icones/bikes_allowed_0.png" alt="Autorisation des vélos inconnue" /></td>';
                                    break;
                                case 1:
                                    echo '<td class="table_A_noter">' . $data[$y] . ' <img class="bike-icon" src="icones/bikes_allowed_1.png" alt="Vélos autorisés"/></td>';
                                    break;
                                case 2:
                                    echo '<td class="table_attention">' . $data[$y] . ' <img class="bike-icon" src="icones/bikes_allowed_2.png" alt="Vélos non autorisés"/></td>';
                                    break;
                            }
                            $y++;

                        }
                        echo '<td>' . ($data[$y] ?? null) . '</td>';
                        //echo '<td style="background:#' . $routeCouleur['route_color'][] . '; color:#' . $routeCouleur['route_text_color'] . ';">' . $data[$y] . '</td>';
                    } else {
                        echo '<td>' . $data[$y] . '</td>';
                    }
                }
                echo '</tr>';
                $rowCount++;
            }
            echo '</table>';
            echo '<br />';
            /*if ($ListeFichierGTFSprésent[$i][0] == 'trips.txt') {
                    echo '<table>';
                    echo '<caption>Liste des itinéraires</caption>';
                    echo '<tr>';
                    echo '<th>shape_id</th>';
                    echo '<th>Nb points</th>';
                }*/
            if ($ListeFichierGTFSprésent[$i][0] == 'shapes.txt') {
                $Nbcolonnes = ceil($dico_shapes_id['Nb_shape_id'] / 25);
                echo '<table>';
                echo '<caption>Liste des id dans le fichier shape et nombre de points</caption>';
                echo '<tr>';
                echo '<th>shape_id</th>';
                echo '<th>Nb points</th>';
                for ($j = 1; $j < $Nbcolonnes; $j++) {
                    echo '<th>shape_id</th><th>Nb points</th>';
                }
                echo '</tr>';

                for ($i = 0; $i < 25; $i++) {
                    echo '<tr>';
                    for ($j = 0; $j < $Nbcolonnes; $j++) {
                        $index = $i + ($j * 25);
                        $a = $dico_shapes_id['shape_names'][$index]['name'] ?? '';
                        $b = $dico_shapes_id['shape_names'][$index]['Nb_ligne'] ?? '';
                        echo '<td style="border-left:solid;">' . $a . '</td>';
                        echo '<td>' . $b . '</td>';
                    }
                    echo '</tr>';
                }

                echo '<tr>';
                echo '<td style="border-top:solid; font-weight:bold;">Total Id</td>';
                echo '<td style="border-top:solid; font-weight:bold;">Total shapes</td>';
                for ($j = 1; $j < $Nbcolonnes; $j++) {
                    echo '<td style="border-top:solid;"></td><td style="border-top:solid;"></td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . $dico_shapes_id['Nb_shape_id'] . '</td>';
                echo '<td>' . $Nbshapes . '</td>';
                for ($j = 1; $j < $Nbcolonnes; $j++) {
                    echo '<td></td><td></td>';
                }
                echo '</tr>';
                echo '</table>';
            }
            fclose($handle);
        } else {
            echo 'Erreur : Impossible d\'ouvrir le fichier ' . $filePath;
        }
    }
}
