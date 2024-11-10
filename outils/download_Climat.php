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
