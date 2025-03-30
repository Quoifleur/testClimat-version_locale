<?php
echo '<div class="texte">
    <h1 id="debug">GTFS Debug</h1>
    <h2>Temps d\'exécution</h2>
   Temps d\'exécution GTFcsvTOmap : ' . ($execution_time_GTFcsvTOmap / 1e9) . ' secondes <br/>
   Temps d\'exécution Explicite : ' . ($execution_time_fichierExplicite / 1e9) . ' secondes <br/>
    Temps d\'exécution GTFSmap : ' . ($execution_time_GTFSmap / 1e9) . ' secondes <br/>
    Temps d\'exécution total : ' . (($execution_time_GTFSmap + $execution_time_fichierExplicite + $execution_time_GTFcsvTOmap) / 1e9) . ' secondes <br/>

    <h2>Notification(s)</h2>';

for ($i = 0; $i < count($MessageErreur); $i++) {
    echo $MessageErreur[$i] . '<br/>';
}
echo '<h2>Autres informations</h2>';
echo 'Taille du fichier chargé : ' . $taille . ' octets (soit ' . round($taille / 1000000, 3) . ' Mo)<br/>';
echo '</div>';

