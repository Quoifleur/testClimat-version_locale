<?php
echo '<ul>';
for ($i = 0; $i < $Nbfichierthéorique; $i++) {
    if ($ListeFichierGTFSprésent[$i][1] == 1) {
        echo '<li><a href="#' . $ListeFichierGTFSprésent[$i][0] . '" >' . $ListeFichierGTFSprésent[$i][0] . '</a></li>';
    }
}
echo '</ul>';
