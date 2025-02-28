<?php
echo '
<div class="texte">
<h3 id="recap">Informations et Sommmaire</h3>
<p>
Cliquez sur le nom du fichier pour accéder à son contenu.
</p>
<table>';
echo '<caption>Informations sur le fichier chargé</caption>
                <tr>
                    <th>Fichier</th>
                    <th>Présence</th>
                    <th>Présence</th>
                </tr>';
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
$Message = $MessageErreur ?? null;
echo '</table></div>';
/*echo '<h3 id="Informations et erreurs">Informations et erreurs</h3>';
echo '<table>';
echo '<caption>Informations et erreurs</caption>';
if (isset($Message)) {
    echo '<tr><th>Types</th><th>Messages</th></tr>';
    for ($i = 0; $i < count($MessageErreur); $i++) {
        $affichage[$i] = explode(':', $MessageErreur[$i]);
        echo '<tr>';
        echo $affichage[$i][0];
        echo $affichage[$i][1];
        echo '</tr>';
    }
} else {
    echo '<tr><td>Aucune erreur</td></tr>';
    echo '<br/>';
}*/
