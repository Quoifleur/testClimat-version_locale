# testGTFS

testGTFS est une visionneuse de fichier GTFS (https://testclimat.ovh/horsThemeGTFS.php).

## Les fichiers GTFS

Le General Transit Feed Specification (GTFS) est un format de fichier qui contient les horaires des transports en commun. Il est utilisé par de nombreuses applications de transport en commun, telles que Google Maps, pour afficher les horaires des bus, des trains et des métros. Le GTFS est un format de fichier simple et facile à utiliser qui permet aux développeurs de créer des applications de transport en commun.

## Fonctionnement
Voir les fichiers ZIPtoTXT.php -> GTFScsvTOmap.php -> GTFSmap.php -> GTFSexplicite.php -> GTFSnettoyage.php
Aucun fichier n'est sauvegardé par testGTFS. Tous les fichiers uploadés sont immédiatement supprimés du serveur. Les données ne sont sauvegardées dans aucune base de données.

# testClimat

Le site internet testClimat (https://testclimat.ovh/) permet à partir de normales climatiques de déterminer le cliamt d'un lieu selon la classification de Koppen-Geigger.
Il s'agit ici de la version locale du site. En tant que tel le site fonctionne donc en local avec MAMP.

## Différence entre le site testClimat et sa version locale

> [!NOTE]
> Des différences mineures subsistent entre le site et la version ici présente.

La version de testClimat ici présente est une verison de développement configurer pour fonctionner en local. Aussi les nouvelles fonctionnonalités et autres mises à jours sont d'abords testé via cette version de testClimat.
Cette version de testClimat est donc plus instable.
Néanmoins le fonctionnement global des deux versions reste le même.

## Script testClimat

Vous pouvez retrouver le script testClimat (la partie du site chargé de détermnier le climat) ici : https://github.com/Quoifleur/testClimat/tree/main
Cette version du script est codé en python (et non en PHP comme sur le site, voir la page testClimatinSQLTer.PHP) et se concentre sur l'essentiel.

## Pour aller plus loin

La page de documentation et d'aide du site testClimat : https://testclimat.ovh/testClimatAide.php

Mon contact : victor.maury@testclimat.ovh

# Installation

## Pré-requis

- Un environnement de serveur local comme MAMP (ou équivalent).
- PHP version 8.0.1

## Configuration

1. Téléchargez et glisser ce repositorie dans le dossier `htdocs` (Si vous utilisez MAMP, le nom du dossier peut différer en fonction de votre solution utilisé pour avoir l'environnement de serveur local).

Dans votre serveur local :

2. Créez une base de données nommées `testClimat`.
3. Dans cette base de données, importez les tables `user` et `CLIMAT` (vous trouverez ces deux fichiers dans le dossier DATABASE de ce repositorie).
