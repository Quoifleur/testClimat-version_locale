<?php
// protocole utilisé : http ou https ?
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') $url = "https://";
else $url = "http://";
// hôte (nom de domaine voire adresse IP)
$url .= $_SERVER['HTTP_HOST'];
// emplacement de la ressource (nom de la page affichée). Utiliser $_SERVER['PHP_SELF'] si vous ne voulez pas afficher les paramètres de la requête
$url .= $_SERVER['REQUEST_URI'];
// récupération du contenu de la page
$pageCourante = explode('/', $url);
$content = file_get_contents($pageCourante[4]);
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$headers = $xpath->query('//h1|//h2|//h3|//h4|//h5|//h6');

foreach ($headers as $header) {
    // Créer un id unique pour chaque titre
    $id = 'section-' . $idCounter++;
    $header->setAttribute('id', $id);

    // Déterminer le niveau actuel
    $currentLevel = (int) substr($header->nodeName, 1);

    if ($currentLevel > $lastLevel) {
        // Ouvrir un nouveau niveau de liste
        $toc .= '<ul>';
        $openLists[] = true;
    } elseif ($currentLevel < $lastLevel) {
        // Fermer les niveaux de liste
        while ($currentLevel < $lastLevel) {
            $toc .= '</ul>';
            array_pop($openLists);
            $lastLevel--;
        }
    }

    // Ajouter un élément de liste au sommaire
    $toc .= '<li><a href="#' . $id . '"classe="section_titre">' . $header->nodeValue . '</a></li>';

    // Mettre à jour le dernier niveau
    $lastLevel = $currentLevel;
}

// Fermer tous les niveaux de liste restants
while ($lastLevel > 0) {
    $toc .= '</ul>';
    $lastLevel--;
}
/* Initialiser les éléments du sommaire
$toc = '<ul classe="sommaire">';
$idCounter = 1;
$niveauTitre = [];
$ordreTitre = [];
$nomTitre = [];
$i = 0;

foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $tag) {
    $headers = $dom->getElementsByTagName($tag);
    foreach ($headers as $header) {
        // Créer un id unique pour chaque titre
        $id = 'section-' . $idCounter++;
        $header->setAttribute('id', $id);
        $niveauTitre[$i] = $currentLevel = (int) substr($tag, 1);
        $ordreTitre[$i] = $id;
        $nomTitre[$i] = $header->nodeValue;
        $i++;
    }
}
$a = 0;
print_r($niveauTitre);
print_r($ordreTitre);
print_r($nomTitre);
while ($a != $i) {
    $currentLevel = $niveauTitre[$a];
    $currentOrder = $ordreTitre[$a];
    $currentName = $nomTitre[$a];
    $currentName = trim($currentName);
    $toc .= '<li classe="sommaire"><a href="#' . $currentOrder . '" classe="SH' . $currentLevel . '">' . $currentLevel . ' ' . $currentName . '</a></li>';
    $a++;
}*/
$toc .= '</ul>';
// Sauvegarder le contenu avec les ancres ajoutées
$contentWithAnchors = $dom->saveHTML();
?>
<aside class="containeur">
    <?php echo $toc; ?>
</aside>
<?php //echo $contentWithAnchors; 
?>