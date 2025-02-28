<?php
echo '<aside><h3 id="sommaire">Sommaire</h3>';
echo '<ul>
    <li><a href="#recap">Informations et Sommmaire</a></li>
    <li><a href="#chargementFichier">Fichier à visualiser</a></li>';
if ($fichierChargé) {
    for ($i = 0; $i < $Nbfichierthéorique; $i++) {
        if ($ListeFichierGTFSprésent[$i][1] == 1) {
            echo '<li><a href="#' . $ListeFichierGTFSprésent[$i][0] . '" >' . $ListeFichierGTFSprésent[$i][0] . '</a></li>';
        }
    }
}
echo '
    <li><a href="#carte">Carte</a></li>
    </ul></aside>';
