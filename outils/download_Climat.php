<?php
$downloadPossible = false;
$climatSelect =  strip_tags($_GET['climat-select'] ?? null);
$climatAtelecharger = explode('-', $climatSelect);
$instruction = strip_tags($_GET['Télécharger'] ?? null);
$ecriture = array();
$downloadNom = 'climat';
$ecritureLegende = '"id","DATEcollecte","DATEentre","TEMPORALITEperiode","TEMPORALITEmois","NOMlocalisation","NOMgenerique","POSITIONhemisphere","POSITIONx","POSITIONy","POSITIONz","SAISON","NORMALETe","NORMALEPr","NORMALE2","NORMALE3","NORMALE4","RESULTATkoge","RESULTATgaus","RESULTATmart"';
//$ecritureSynthetiqueLegende = '"ClimatNumero","Nom","NomClimat","LettreClimat","hémisphère","Gaussen","Martonne"';

$ecritureSynthetiqueValeurLegendeMois = '"Mois","';
$ecritureSynthetiqueValeurLegendeTe = '"Température","';
$ecritureSynthetiqueValeurLegendePr = '"Précipitation","';
$ponctuation = '","';
$ponctuationFinal = '"';
if ($climatAtelecharger != null && $instruction != null) {
    $downloadPossible = true;
    if ($climatAtelecharger[1] == 'all') {
        $downloadNom = 'tousLesClimats.csv';
        for ($i = 0; $i < $NbRowInTable; $i++) {
            $ecriture[$i] = ($id[$i] ?? 'n/a') . ',' .
                ($DATEcollecte[$i] ?? 'n/a') . ',' .
                ($DATEentre[$i] ?? 'n/a') . ',' .
                ($TEMPORALITEperiode[$i]  ?? 'n/a') . ',' .
                (str_replace(',', ':', $TEMPORALITEmois[$i])  ?? 'n/a') . ',' .
                ($NOMlocalisation[$i]  ?? 'n/a') . ',' .
                ($NOMgenerique[$i]  ?? 'n/a') . ',' .
                ($hémisphère[$i] ?? 'n/a') . ',' .
                ($POSITIONx[$i]  ?? 'n/a') . ',' .
                ($POSITIONy[$i]  ?? 'n/a') . ',' .
                ($POSITIONz[$i]  ?? 'n/a') . ',' .
                (str_replace(',', ':', $SAISON[$i]  ?? 'n/a')) . ',' .
                (str_replace(',', ':', $NORMALETe[$i]) ?? 'n/a') . ',' .
                (str_replace(',', ':', $NORMALEPr[$i])  ?? 'n/a') . ',' .
                ($NORMALE2[$i]  ?? 'n/a') . ',' .
                ($NORMALE3[$i]  ?? 'n/a') . ',' .
                ($NORMALE4[$i]  ?? 'n/a') . ',' .
                (str_replace(',', '-', $RESULTATkoge[$i]) ?? 'n/a') . ',' .
                (str_replace(',', ':', $RESULTATgaus[$i])  ?? 'n/a') . ',' .
                (str_replace(',', ':', $RESULTATmart[$i])  ?? 'n/a');
        }

        $fichier = fopen($downloadNom, 'c+b');
        if ($fichier === false) {
            die("Erreur: Impossible d'ouvrir le fichier $downloadNom.");
        }
        fwrite($fichier, $ecritureLegende);
        $a = 0;
        while (isset($ecriture[$a])) {
            fwrite($fichier, "\r\n");
            fwrite($fichier, $ecriture[$a]);
            $a++;
        }
        fclose($fichier);
    } else {
        $downloadNom = 'climat' . $climatAtelecharger[0] . '.csv';
        $i = array_search($climatAtelecharger[0], $id);
        $ecriture[$i] = ($id[$i] ?? 'n/a') . ',' .
            ($DATEcollecte[$i] ?? 'n/a') . ',' .
            ($DATEentre[$i] ?? 'n/a') . ',' .
            ($TEMPORALITEperiode[$i]  ?? 'n/a') . ',' .
            (str_replace(',', ':', $TEMPORALITEmois[$i])  ?? 'n/a') . ',' .
            ($NOMlocalisation[$i]  ?? 'n/a') . ',' .
            ($NOMgenerique[$i]  ?? 'n/a') . ',' .
            ($hémisphère[$i] ?? 'n/a') . ',' .
            ($POSITIONx[$i]  ?? 'n/a') . ',' .
            ($POSITIONy[$i]  ?? 'n/a') . ',' .
            ($POSITIONz[$i]  ?? 'n/a') . ',' .
            (str_replace(',', ':', $SAISON[$i]  ?? 'n/a')) . ',' .
            (str_replace(',', ':', $NORMALETe[$i]) ?? 'n/a') . ',' .
            (str_replace(',', ':', $NORMALEPr[$i])  ?? 'n/a') . ',' .
            ($NORMALE2[$i]  ?? 'n/a') . ',' .
            ($NORMALE3[$i]  ?? 'n/a') . ',' .
            ($NORMALE4[$i]  ?? 'n/a') . ',' .
            (str_replace(',', '-', $RESULTATkoge[$i]) ?? 'n/a') . ',' .
            (str_replace(',', ':', $RESULTATgaus[$i])  ?? 'n/a') . ',' .
            (str_replace(',', ':', $RESULTATmart[$i])  ?? 'n/a');
        // Ouvrez le fichier en mode écriture
        $fichier = fopen($downloadNom, 'c+b');
        if ($fichier === false) {
            die("Erreur: Impossible d'ouvrir le fichier $downloadNom.");
        }
        fwrite($fichier, $ecritureLegende);
        $a = 0;
        while (isset($ecriture[$a])) {
            fwrite($fichier, "\r\n");
            fwrite($fichier, $ecriture[$a]);
            $a++;
        }
        fclose($fichier);
    }
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($downloadNom) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($downloadNom));
    readfile($downloadNom);
    unlink($downloadNom);
    exit;
}
/* Pour un affichage moins compacts. Mise en page différntes. (pas tout à fait satisfaisant)
        for ($i = 0; $i < $NbRowInTable; $i++) {
            $ligne = ''; // Initialiser une chaîne vide pour chaque ligne
            for ($y = 0; $y < 12; $y++) {
                // Accumuler les valeurs dans la chaîne $ligne
                $ligne .= ($id[$i] ?? 'n/a') . ',' .
                    ($ADATEcollecte[$i][$i] ?? 'n/a') . ',' .
                    ($ADATEentre[$i][$i] ?? 'n/a') . ',' .
                    ($ATEMPORALITEperiode[$i][$y] ?? 'n/a') . ',' .
                    ($mois[$i][$y] ?? 'n/a') . ',' .
                    ($ANOMlocalisation[$i][$y] ?? 'n/a') . ',' .
                    ($ANOMgenerique[$i][$y] ?? 'n/a') . ',' .
                    ($hémisphère[$i] ?? 'n/a') . ',' .
                    ($APOSITIONx[$i][$y] ?? 'n/a') . ',' .
                    ($APOSITIONy[$i][$y] ?? 'n/a') . ',' .
                    ($APOSITIONz[$i][$y] ?? 'n/a') . ',' .
                    ($ASAISON[$i][$y] ?? 'n/a') . ',' .
                    ($Te[$i][$y] ?? 'n/a') . ',' .
                    ($Pr[$i][$y] ?? 'n/a') . ',' .
                    ($ANORMALE2[$i][$y] ?? 'n/a') . ',' .
                    ($ANORMALE3[$i][$y] ?? 'n/a') . ',' .
                    ($ANORMALE4[$i][$y] ?? 'n/a') . ',' .
                    ($Ikg[$i][$i] ?? 'n/a') . ',' .
                    ($Ar[$i][$y] ?? 'n/a') . ',' .
                    ($Im[$i][$y] ?? 'n/a') . "\n"; // Ajouter un saut de ligne à la fin de chaque itération interne
            }
            $ecriture[$i] = $ligne; // Ajouter la chaîne accumulée à $ecriture[$i]
        }*/