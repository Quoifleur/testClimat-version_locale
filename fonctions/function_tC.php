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
