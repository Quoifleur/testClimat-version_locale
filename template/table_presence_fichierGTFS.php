<?php

for ($i = 0; $i < $Nbfichierthéorique; $i++) {
    echo '<tr>';
    if ($ListeFichierGTFSprésent[$i][1] == 1) {
        echo '<td><a href="#' . $ListeFichierGTFSprésent[$i][0] . '" style="color:#6F6951">' . $ListeFichierGTFSprésent[$i][0] . '</a></td>';
    } else {
        echo '<td>' . $ListeFichierGTFSprésent[$i][0] . '</td>';
    }
    echo '<td>' . $ListeFichierGTFSprésent[$i][1] . '</td>';
    echo '<td>' . $ListeFichierGTFSprésent[$i][2] . '</td>';
    echo '</tr>';
}
