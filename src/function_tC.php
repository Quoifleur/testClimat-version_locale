<?php
function NettoyageString($string)
{
    $string = strip_tags($string);
    $string = str_replace("'", "’", strip_tags($string));
    $string = str_replace('"', '“', $string);
    $string = str_replace('<', '«', $string);
    $string = str_replace('>', '»', $string);
    return $string;
}
function detectionErreur($array)
{
    for ($i = 0; $i < 11; $i++) {
        if (!is_numeric($array[$i])) {
            header('refresh:7;url=http://localhost/testClimat/index.php');
            echo '<br /><br />L\'une des valeurs saisi n\'est pas un nombre.<br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
            die();
        }
        if (!isset($array[$i])) {
            header('refresh:7;url=http://localhost/testClimat/index.php');
            echo '<br /><br />L\'une des valeurs saisi manque. <br />Merci de bien saisir 12 valeurs<br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
            die();
        }
    }
}
function debugVar($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
function SUPER_gestionErreur($array)
{
    if (isset($array)) {
        debugVar($array);
        detectionErreur($array);
    } else {
        echo 'array non définie <br />';
    }
}
function random_string($length)
{
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}


/*---------------------------------------------------------------*/
/*
    Titre : Compte le nombre de fichiers d'un répertoire                                                               
                                                                                                                          
    URL   : https://phpsources.net/code_s.php?id=51
    Auteur           : R@f                                                                                                
    Date édition     : 01 Sept 2004                                                                                       
    Date mise à jour : 13 Aout 2019                                                                                      
    Rapport de la maj:                                                                                                    
    - fonctionnement du code vérifié                                                                                
    - maintenance du code                                                                                                 
*/
/*---------------------------------------------------------------*/

function count_files($folder, $ext, $subfolders)
{
    // on rajoute le / à  la fin du nom du dossier s'il ne l'est pas
    if (substr($folder, -1) != '/')
        $folder .= '/';

    // $ext est un tableau?
    $array = 0;
    if (is_array($ext))
        $array = 1;

    // ouverture du répertoire
    $rep = @opendir($folder);
    if (!$rep)
        return -1;

    $nb_files = 0;
    // tant qu'il y a des fichiers
    while ($file = readdir($rep)) {
        // répertoires . et ..
        if ($file == '.' || $file == '..')
            continue;

        // si c'est un répertoire et qu'on peut le lister
        if (is_dir($folder . $file) && $subfolders)
            // on appelle la fonction
            $nb_files += count_files($folder . $file, $ext, 1);
        // vérification de l'extension avec $array = 0
        else if (!$array && substr($file, -strlen($ext)) == $ext)
            $nb_files++;
        // vérification de l'extension avec $array = 1   
        else if ($array == 1 && in_array(
            strtolower(substr(strrchr($file, "."), 1)),
            $ext
        ))
            $nb_files++;
    }

    // fermeture du rep
    closedir($rep);
    return $nb_files;
}
function contrasteColor($color)
{
    if (isset($color) && is_string($color)) {
        if (strlen($color) === 6) {
            $color = '#' . $color;

            // Convertir la couleur hexadécimale en RGB manuellement
            $r = intval(substr($color, 1, 2), 16);
            $g = intval(substr($color, 3, 2), 16);
            $b = intval(substr($color, 5, 2), 16);

            // Calculer la luminance relative
            $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

            // Retourner noir pour les couleurs claires et blanc pour les couleurs sombres
            return ($luminance > 0.5) ? '6F6951' : 'fff9df';
        } else {
            return '6F6951';
        }
    } else {
        return '6F6951';
    }
}
function baricentrebis($array)
{
    $lat = 0;
    $long = 0;
    $somme = 0;
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i][0]);
    }
    $lat = round($somme / $n, 3);
    $somme = 0;
    for ($i = 0; $i < $n; $i++) {
        $somme += floatval($array[$i][1]);
    }
    $long = round($somme / $n, 3);
    return $lat . ',' . $long;
}
