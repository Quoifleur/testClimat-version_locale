<?php
echo '
<aside>
<div class="menu">';
echo '
    <div class="SousMenu_sommaire"><a href="#introduction">Introduction</a></div>
    <div class="SousMenu_sommaire"><a href="#recap">Sommmaire</a></div>
    <div class="SousMenu_sommaire"><a href="#chargementFichier">Visualiser un fichier</a></div>';
if ($fichierChargé) {
    for ($i = 0; $i < $Nbfichierthéorique; $i++) {
        if ($ListeFichierGTFSprésent[$i][1] == 1) {
            echo '<div class="SousMenu_sommaire"><a href="#' . $ListeFichierGTFSprésent[$i][0] . '" >' . $ListeFichierGTFSprésent[$i][0] . '</a></div>';
        }
    }
}
echo '
    <div class="SousMenu_sommaire"><a href="#carte">Carte</a></div>
</div>
</aside>
';
