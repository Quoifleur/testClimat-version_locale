<?php
if (!$fichierChargé) {
    echo '<div class="A_noter">
    <div class="A_noter_titre">A noter</div>
    <p>Le fichier doit obligatoirement être au format .zip et ne pas dépasser la taille de 9000000 octets (9Mo).</p>
</div>
    ';
}
?>

<form method="POST" action="horsThemeGTFS.php" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE">
    <input type="file" name="file" id="file" accept=".zip">
    <input type="submit" value="Envoyer">
</form>
<?php
if ($fichierChargé) {
    echo '<div class="A_noter">
    <div class="A_noter_titre">A noter</div>
    <p>Le fichier <b>' . $Nomfichier[0] . '</b> a été chargé avec succès </p>
</div>';
} else {
    echo '<div class="attention">
    <div class="attention_titre">Attention </div>
    <p>Aucun fichier n\'a été chargé. Pour se faire utilisez le formulaire ci-dessus. Si vous rencontrer un problème merci de me contacter. Noter que le fichier doit être au format zip</p>
</div>';
}
if ($erreur) {
    echo '<div class="attention">
    <div class="attention_titre">Attention </div>
    <p>Une erreur est survenue. Le fichier doit être au format zip et ne doit pas dépasser 9000000 octets</p>';
}
