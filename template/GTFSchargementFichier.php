<?php
if (!$fichierChargé) {
    echo '<div class="A_noter">
    <div class="A_noter_titre">A noter</div>
    <p>Le fichier doit obligatoirement être au format .zip et ne pas dépasser la taille de 29Mo.</p>
</div><br />';
}
?>

<form method="POST" action="horsThemeGTFS.php" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE">
    <input type="file" name="file" id="file" accept=".zip">
    <input type="submit" value="Envoyer">
</form>
<!-- Formulaire de chargement de fichier format drag and drop, finctionnel mais pas satisfaisant, à revoir
<form id="uploadForm" method="POST" class="formulaire" action="horsThemeGTFS.php" enctype="multipart/form-data">
    <input type="file" id="fileInput" name="file" accept=".zip" style="display: none;">
    <div id="dropZone" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
        Glissez-déposez un fichier .zip ici (max 25 Mo) ou <label for="fileInput" style="cursor: pointer; text-decoration: underline;">cliquez pour sélectionner</label>.
    </div>
    <div id="content">Cliquez sur le bouton pour charger le contenu.</div>
    <button onclick="loadContent()">Charger le contenu</button>
</form>-->

<?php
if ($fichierChargé) {
    echo '<br />
    <div class="A_noter">
    <div class="A_noter_titre">A noter</div>
    <p>Le fichier <b>' . htmlspecialchars($Nomfichier[0]) . '</b> a été chargé avec succès </p>
</div>';
} elseif ($erreur) {
    echo '<br />
    <div class="attention">
    <div class="attention_titre">Attention </div>
    <p>Une erreur est survenue. Le fichier doit être au format zip et ne doit pas dépasser 25Mo</p>
</div>';
} else {
    echo '<br />
    <div class="attention">
    <div class="attention_titre">Attention </div>
    <p>Aucun fichier n\'a été chargé. Pour ce faire utilisez le formulaire ci-dessus. Si vous rencontrez un problème merci de me contacter. Noter que le fichier doit être au format zip et ne doit pas dépasser 25Mo</p>
</div>';
}

?>