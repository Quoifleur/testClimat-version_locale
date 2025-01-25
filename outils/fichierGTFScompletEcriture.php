<?
$GTFScomplet = 'upload/extract' . $fichier . '/GTFScomplet.html';
$fichierGTFScomplet = fopen($GTFScomplet, 'w');
fwrite($fichierGTFScomplet,  '<h3 id="sommaire">Sommaire</h3>');
fwrite($fichierGTFScomplet,  '<ul>');
for ($i = 0; $i < $Nbfichierthéorique; $i++) {
    if ($ListeFichierGTFSprésent[$i][1] == 1) {
        fwrite($fichierGTFScomplet, '<li><a href="#' . $ListeFichierGTFSprésent[$i][0] . '" >' . $ListeFichierGTFSprésent[$i][0] . '</a></li>');
    }
}
fwrite($fichierGTFScomplet,  '</ul>');

for ($i = 0; $i < $Nbfichierthéorique; $i++) {
    if ($ListeFichierGTFSprésent[$i][1] == 1) {
        $filePath = 'upload/extract' . $fichier . '/' . $ListeFichierGTFSprésent[$i][0];
        $handle = fopen($filePath, 'r');
        if ($handle) {
            $Legende = fgetcsv($handle);
            $Nbcolonnes = count($Legende);
            fwrite($fichierGTFScomplet, '<h3 id="' . $ListeFichierGTFSprésent[$i][0] . '">' . $ListeFichierGTFSprésent[$i][0] . '</h3>');
            fwrite($fichierGTFScomplet, '<table>');
            fwrite($fichierGTFScomplet,'');
            fwrite($fichierGTFScomplet,'');
            for ($j = 0; $j < $Nbcolonnes; $j++) {
                fwrite($fichierGTFScomplet, '<th>' . $Legende[$j] . '</th>');
            }
            fwrite($fichierGTFScomplet,'</tr>');
        }
        while (($data = fgetcsv($handle)) !== false) {
            fwrite($fichierGTFScomplet,  '<tr>');
            for ($y = 0; $y < $Nbcolonnes; $y++) {
                if ($ListeFichierGTFSprésent[$i][0] == 'routes.txt' && $Legende[$y] == 'route_color' && $Legende[$y + 1] == 'route_text_color') {
                    $routeCouleur['route_id'][] = $data[$y -  6];
                    $routeCouleur['route_color'][] = $data[$y];
                    $routeCouleur['route_text_color'][] = $data[$y + 1];
                    fwrite($fichierGTFScomplet, '<td style="background:#' . $data[$y] . '; color:#' . $data[$y + 1] . ';">' . $data[$y] . '</td>');
                    $y++;
                    fwrite($fichierGTFScomplet,  '<td style="background:#' . $data[$y - 1] . '; color:#' . $data[$y] . ';">' . $data[$y] . '</td>');
                }else {
                    fwrite($fichierGTFScomplet,  '<td>' . $data[$y] . '</td>');
                }
            }
            fwrite($fichierGTFScomplet,'</tr>');
            $rowCount++;
        }
        fwrite($fichierGTFScomplet,'</table>');
        fwrite($fichierGTFScomplet,'<br />');
        if ($ListeFichierGTFSprésent[$i][0] == 'shapes.txt') {
            fwrite($fichierGTFScomplet, '<table><caption>Liste des id dans le fichier shape et nombre de points</caption><tr><th>shape_id</th><th>Nb points</th><th>shape_id</th><th>Nb points</th></tr>');
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
                    fwrite($fichierGTFScomplet, '<tr>');
                    fwrite($fichierGTFScomplet, '<td>' . $c . '</td>');
                    fwrite($fichierGTFScomplet, '<td>' . $a . '</td>');
                    fwrite($fichierGTFScomplet, '<td style="border-left:solid; ">' . $d . '</td>');
                    fwrite($fichierGTFScomplet, '<td>' . $b . '</td>');
                    fwrite($fichierGTFScomplet, '<td style="border-left:solid; ">' . $e . '</td>');
                    fwrite($fichierGTFScomplet, '<td>' . $f . '</td>');
                    fwrite($fichierGTFScomplet, '<td style="border-left:solid; ">' . $g . '</td>');
                    fwrite($fichierGTFScomplet, '<td>' . $h . '</td>');
                    fwrite($fichierGTFScomplet, '</tr>');
                } else {
                    $a = $dico_shapes_id['shape_names'][$j]['Nb_ligne'] ?? '';
                    $b = $dico_shapes_id['shape_names'][$j + 1]['Nb_ligne'] ?? '';
                    $c = $dico_shapes_id['shape_names'][$j]['name'] ?? '';
                    $d = $dico_shapes_id['shape_names'][$j + 1]['name'] ?? '';
                    fwrite($fichierGTFScomplet, '<tr>');
                    fwrite($fichierGTFScomplet, '<td>' . $c . '</td>');
                    fwrite($fichierGTFScomplet, '<td>' . $a . '</td>');
                    fwrite($fichierGTFScomplet, '<td  style="border-left:solid; ">' . $d . '</td>');
                    fwrite($fichierGTFScomplet, '<td>' . $b . '</td>');
                    fwrite($fichierGTFScomplet, '</tr>');
                }
            }
            fwrite($fichierGTFScomplet, '<tr>');
            fwrite($fichierGTFScomplet, '<td><b>Total Id</b></td>');
            fwrite($fichierGTFScomplet, '<td><b>Total shapes</b></td>');
            fwrite($fichierGTFScomplet, '</tr>');
            fwrite($fichierGTFScomplet, '<tr>');
            fwrite($fichierGTFScomplet, '<td>' . $dico_shapes_id['Nb_shape_id'] . '</td>');
            fwrite($fichierGTFScomplet, '<td>' . $Nbshapes . '</td>');
            fwrite($fichierGTFScomplet, '</table>');
        }
        fclose($handle);
    } else {
        fwrite($fichierGTFScomplet, 'Erreur : Impossible d\'ouvrir le fichier ' . $filePath);
    }
    
}

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename('upload/extract' . $fichier . '/GTFScomplet.html') . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('upload/extract' . $fichier . '/GTFScomplet.html'));
    unlink($GTFScomplet);
    exit;