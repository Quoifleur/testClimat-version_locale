<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=testclimat;charset=utf8', 'root', 'root', [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],);
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}
