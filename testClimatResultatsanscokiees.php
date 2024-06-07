<?php
session_start();
//Récupération des valeurs.
//Tableau des mois 
$month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
$Hémisphère = $_POST['hémisphère'];
if (isset($_POST['Tec']) && isset($_POST['Prc'])) {
    $Te = explode(",", strip_tags($_POST['Tec']));
    $Pr = explode(",", strip_tags($_POST['Prc']));
} else {
    $Te = [strip_tags($_POST['TM1']), strip_tags($_POST['TM2']), strip_tags($_POST['TM3']), strip_tags($_POST['TM4']), strip_tags($_POST['TM5']), strip_tags($_POST['TM6']), strip_tags($_POST['TM7']), strip_tags($_POST['TM8']), strip_tags($_POST['TM9']), strip_tags($_POST['TM10']), strip_tags($_POST['TM11']), strip_tags($_POST['TM12'])];
    $Pr = [strip_tags($_POST['PM1']), strip_tags($_POST['PM2']), strip_tags($_POST['PM3']), strip_tags($_POST['PM4']), strip_tags($_POST['PM5']), strip_tags($_POST['PM6']), strip_tags($_POST['PM7']), strip_tags($_POST['PM8']), strip_tags($_POST['PM9']), strip_tags($_POST['PM10']), strip_tags($_POST['PM11']), strip_tags($_POST['PM12'])];
}
for ($i = 0; $i < 11; $i++) {
    if (!is_numeric($Te[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        echo '<br /><br />L\'une des valeurs saisi n\'est pas un nombre. <br />Merci de saisir les valeurs sous cette forme, par exemple : -2.6,-2.0,2.3,8.3,12.7,17.2,21.1,21.1,17.1,12.0,5.3,0.1 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
    if (!isset($Te[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        echo '<br /><br />L\'une des valeurs saisi manque. <br />Merci de bien saisir 12 valeurs sous cette forme, par exemple : -2.6,-2.0,2.3,8.3,12.7,17.2,21.1,21.1,17.1,12.0,5.3,0.1 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
}
for ($i = 0; $i <= 11; $i++) {
    if (!is_numeric($Pr[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        '<br /><br />L\'une des valeurs entré n\'est pas un nombre. <br />Merci d\'entré les valeurs sous cette forme, par exemple : 41.4,92.4,89.9,63.0,64.9,42.4,14.1,6.7,41.0,56.6,63.6,58.0 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
    if (!isset($Pr[$i])) {
        header('refresh:7;url=http://localhost/testClimat/index.php');
        echo '<br /><br />L\'une des valeurs saisi manque. <br />Merci de bien saisir 12 valeurs sous cette forme, par exemple : 41.4,92.4,89.9,63.0,64.9,42.4,14.1,6.7,41.0,56.6,63.6,58.0 <br /><br />Vous allez être redirigé dans sept secondes. Si la redirection ne se fait pas <a href="index.php">cliquez ici</a>.';
        die();
    }
}/*
echo 'Te (température en °C)';
for ($i = 0; $i < 12; $i++) {
    echo '<br />Te[' . $i . '] >>> ' . $Te[$i];
}
echo '<br /><br /> Pr (précipitation en mm)';
for ($i = 0; $i < 12; $i++) {
    echo '<br />Pr[' . $i . ']  >>> ' . $Pr[$i];
}
echo '<br /><br />';
Détermination de l'hémisphère */
if ($Hémisphère == 'Nord') {
    $Nord = true;
    $Saison[0] = 'W';
    $Saison[1] = 'W';
    $Saison[2] = 'W';
    $Saison[9] = 'W';
    $Saison[10] = 'W';
    $Saison[11] = 'W';

    $Saison[3] = 'S';
    $Saison[4] = 'S';
    $Saison[5] = 'S';
    $Saison[6] = 'S';
    $Saison[7] = 'S';
    $Saison[8] = 'S';
} elseif ($Hémisphère == 'Sud') {
    $Nord = false;
    $Saison[3] = 'W';
    $Saison[4] = 'W';
    $Saison[5] = 'W';
    $Saison[6] = 'W';
    $Saison[7] = 'W';
    $Saison[8] = 'W';

    $Saison[0] = 'S';
    $Saison[1] = 'S';
    $Saison[2] = 'S';
    $Saison[9] = 'S';
    $Saison[10] = 'S';
    $Saison[11] = 'S';
}
/*Tableau des températures en été en °C (En fonction de l'hémisphère l'hiver et l'été sont inversés*/
if ($Nord) {
    $STe = [$Te[3], $Te[4], $Te[5], $Te[6], $Te[7], $Te[8]];
} else {
    $STe = [$Te[0], $Te[1], $Te[2], $Te[9], $Te[10], $Te[11]];
}
if ($Nord) {
    $WPr = [$Pr[0], $Pr[1], $Pr[2], $Pr[9], $Pr[10], $Pr[11]]; /*Tableau des précipitation des mois d'hiver en mm*/
    $SPr = [$Pr[3], $Pr[4], $Pr[5], $Pr[6], $Pr[7], $Pr[8]]; /*Tableau des précipitation des mois d'été en mm*/
} else {
    $SPr = [$Pr[0], $Pr[1], $Pr[2], $Pr[9], $Pr[10], $Pr[11]]; /*Tableau des précipitation des mois d'hiver (de l'hémisphère sud) en mm*/
    $WPr = [$Pr[3], $Pr[4], $Pr[5], $Pr[6], $Pr[7], $Pr[8]]; /*Tableau des précipitation des mois d'été (de l'hémisphère sud) en mm*/
}
/*
echo 'STe (température en °C)';
for ($i = 0; $i < 6; $i++) {
    echo '<br />STe[' . $i . '] >>> ' . $STe[$i];
}
echo '<br /><br /> SPr & WPr (précipitation en mm)';
for ($i = 0; $i < 6; $i++) {
    echo '<br />SPr[' . $i . ']  >>> ' . $SPr[$i];
}
for ($i = 0; $i < 6; $i++) {
    echo '<br />WPr[' . $i . ']  >>> ' . $WPr[$i];
}
echo '<br /><br />';
Calcule des variables */
$NomClimat1Trouvé = false;
$ClimatTrouvé = false;
$PTHTrouvé = false;

$b = 0;
$i = 0;
$Compte = 0;

$PTH = 0;
$Ia = 0;

$Tmax = max($Te);
$Tmin = min($Te);
$Tannuelle = array_sum($Te) / 12;

$Pmax = max($Pr);
$Psmax = max($SPr);
$Pwmax = max($WPr);
$Pmin = min($Pr);
$Psmin = min($SPr);
$Pwmin = min($WPr);
$Pannuelle = array_sum($Pr);

$Phiver = array_sum($SPr);
$Pété = array_sum($WPr);

/*Calcule de l'indice de Gaussen */
/*Tableau des mois arides */
$Ar = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
for ($i = 0; $i < 12; $i++) {
    if ($Pr[$i] < 2 * $Te[$i]) {
        $Ar[$i++] = 1;
    }
}
/*Calcule de l'indice de Martonne */
$Ia = $Pannuelle / ($Tannuelle + 10); /* Pour l'année*/
$Im = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
for ($i = 0; $i < 12; $i++) {
    $Im[$i] = 12 * $Pr[$i] / ($Te[$i] + 1);
}
/*Détermination de la variable b (il s'agit d'un régime thermique possible pour les climats tempérées) */
for ($i = 0; $i < 12; $i++) {
    if ($Te[$i] > 10) {
        $Compte++;
    }
}
if ($Compte >= 4) {
    $b = 1;
} else {
    $b = 0;
}
/*Détermination du PTH */
if (($Pannuelle * (2 / 3)) >= $Phiver) {
    $PTH = $Tannuelle * 2;
    $PTHTrouvé = true;
}
if (!$PTHTrouvé && ($Pannuelle * (2 / 3)) >= $Pété) {
    $PTH = ($Tannuelle * 2) + 28;
    $PTHTrouvé = true;
}
if (!$PTHTrouvé) {
    $PTH = ($Tannuelle * 2) + 14;
    $PTHTrouvé = true;
}
/*Détermination du climat (testClimat)*/
if ($Tmax < 10) {
    $LettreClimat1 = "E";
    $NomClimat1 = "polaire ";
    if ($Tmax >= 0 && $Tmax < 10) {
        $LettreClimat2 = "t";
        $NomClimat2 = " de toundra ";
        $ClimatTrouvé = true;
    }
    if ($Tmax <= 0 && !$ClimatTrouvé) {
        $LettreClimat2 = "f";
        $NomClimat2 = "glacier ";
        $ClimatTrouvé = true;
    }
}
if ($Pannuelle < 10 * $PTH && !$ClimatTrouvé) {
    $LettreClimat1 = "B";
    $NomClimat1 = " aride ";

    if ($Pannuelle > 5 * $PTH) {
        $LettreClimat2 = "s";
        $NomClimat2 = "de steppe ";

        if ($Tannuelle >= 18 && !$ClimatTrouvé) {
            $LettreClimat3 = "h";
            $NomClimat3 = "chaud ";
            $ClimatTrouvé = true;
        }
        if (!$ClimatTrouvé) {
            $LettreClimat3 = "k";
            $NomClimat3 = "froid ";
            $ClimatTrouvé = true;
        }
    }
    if ($Pannuelle <= 5 * $PTH && !$ClimatTrouvé) {
        $LettreClimat2 = "w";
        $NomClimat2 = "de désert ";

        if ($Tannuelle >= 18) {
            $LettreClimat3 = "h";
            $NomClimat3 = "chaud ";
            $ClimatTrouvé = true;
        }
        if ($Tannuelle < 18 && !$ClimatTrouvé) {
            $LettreClimat3 = "k";
            $NomClimat3 = "froid ";
            $ClimatTrouvé = true;
        }
    }
}
if ($Tmin >= 18 && !$ClimatTrouvé) {
    $LettreClimat1 = "A";
    $NomClimat1 = "équatorial ";

    if ($Pmin >= 60) {
        $LettreClimat2 = "f";
        $LettreClimat3 = "";
        $NomClimat2 = "avec forêt humide équatoriale ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
    if ($Pannuelle >= 25 * (100 - $Pmin) && !$ClimatTrouvé) {
        $LettreClimat2 = "m";
        $LettreClimat3 = "";
        $NomClimat2 = "avec mousson équatoriale ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
    if ($Psmin < 60 && !$ClimatTrouvé) {
        $LettreClimat2 = "s";
        $LettreClimat3 = "";
        $NomClimat2 = "avec savane équatoriale avec été sec ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
    if ($Pwmin < 60 && !$ClimatTrouvé) {
        $LettreClimat2 = "w";
        $LettreClimat3 = "";
        $NomClimat2 = "avec savane équatoriale avec hiver sec ";
        $NomClimat3 = "";
        $ClimatTrouvé = true;
    }
}
if ($Tmin > -3 && $Tmin < 18 && !$ClimatTrouvé) {
    $LettreClimat1 = "C";
    $NomClimat1 = " tempéré ";
    $NomClimat1Trouvé = true;
}

if ($Tmin <= -3 && !$ClimatTrouvé && !$NomClimat1Trouvé) {
    $LettreClimat1 = "D";
    $NomClimat1 = " continental neigeux ";
}
if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
    if ($Psmin < $Pwmin) {
        if ($Pwmax > (3 * $Psmin) && $Psmin < 40) {
            $LettreClimat2 = "s";
            $NomClimat2 = "avec été sec et hiver pluvieux ";

            if ($LettreClimat1 == "D") {
                if ($Tmin <= -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "d";
                    $NomClimat3 = "avec un été et hiver très froid";
                    $ClimatTrouvé = true;
                }
            }
            if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
                if ($Tmax >= 22 && !$ClimatTrouvé) {
                    $LettreClimat3 = "a";
                    $NomClimat3 = "avec un été chaud ";
                    $ClimatTrouvé = true;
                }
                if ($b == 1 && !$ClimatTrouvé) {
                    $LettreClimat3 = "b";
                    $NomClimat3 = "avec un été tempéré ";
                    $ClimatTrouvé = true;
                }
                if ($Tmin > -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "c";
                    $NomClimat3 = "avec un été frais et hiver froid ";
                    $ClimatTrouvé = true;
                }
            }
        }
    }
    if (!$ClimatTrouvé) {
        if ($Pwmin < $Psmin && $Psmax > 10 * $Pwmin) {
            $LettreClimat2 = "w";
            $NomClimat2 = "avec hiver sec et été pluvieux ";

            if ($LettreClimat1 == "D") {
                if ($Tmin <= -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "d";
                    $NomClimat3 = "avec un été et hiver très froid ";
                    $ClimatTrouvé = true;
                }
            }
            if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
                if ($Tmax >= 22 && !$ClimatTrouvé) {
                    $LettreClimat3 = "a";
                    $NomClimat3 = "avec un été chaud ";
                    $ClimatTrouvé = true;
                }
                if ($b == 1 && !$ClimatTrouvé) {
                    $LettreClimat3 = "b";
                    $NomClimat3 = "avec un été tempéré ";
                    $ClimatTrouvé = true;
                }
                if ($Tmin > -38 && !$ClimatTrouvé) {
                    $LettreClimat3 = "c";
                    $NomClimat3 = "avec un été frais et hiver froid ";
                    $ClimatTrouvé = true;
                }
            }
        }
    }
    if ($ClimatTrouvé == false) {
        $LettreClimat2 = "f";
        $NomClimat2 = "humide ";
        if ($LettreClimat1 == "D" && !$ClimatTrouvé) {
            if ($Tmin <= -38) {
                $LettreClimat3 = "d";
                $NomClimat3 = "été et hivers très froid ";
                $ClimatTrouvé = true;
            }
        }
        if ($LettreClimat1 == "C" || $LettreClimat1 == "D") {
            if ($Tmax >= 22) {
                $LettreClimat3 = "a";
                $NomClimat3 = "été chaud ";
                $ClimatTrouvé = true;
            }
            if ($b == 1 && !$ClimatTrouvé) {
                $LettreClimat3 = "b";
                $NomClimat3 = "été tempéré ";
                $ClimatTrouvé = true;
            }
            if ($Tmin > -38 && !$ClimatTrouvé) {
                $LettreClimat3 = "c";
                $NomClimat3 = "été frais et hivers froid ";
                $ClimatTrouvé = true;
            }
        }
    }
}
$IMmax = max($Im);
$IMmin = min($Im);
$NomClimat = $NomClimat1 . $NomClimat2 . $NomClimat3;
$LettreClimat = $LettreClimat1 . $LettreClimat2 . $LettreClimat3;
?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // table des valeurs.
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Précipitation (en mm)', 'Température (en °C)'],
                ['M1', <?php echo $Pr[0]; ?>, <?php echo $Te[0]; ?>, ],
                ['M2', <?php echo $Pr[1]; ?>, <?php echo $Te[1]; ?>, ],
                ['M3', <?php echo $Pr[2]; ?>, <?php echo $Te[2]; ?>, ],
                ['M4', <?php echo $Pr[3]; ?>, <?php echo $Te[3]; ?>, ],
                ['M5', <?php echo $Pr[4]; ?>, <?php echo $Te[4]; ?>, ],
                ['M6', <?php echo $Pr[5]; ?>, <?php echo $Te[5]; ?>, ],
                ['M7', <?php echo $Pr[6]; ?>, <?php echo $Te[6]; ?>, ],
                ['M8', <?php echo $Pr[7]; ?>, <?php echo $Te[7]; ?>, ],
                ['M9', <?php echo $Pr[8]; ?>, <?php echo $Te[8]; ?>, ],
                ['M10', <?php echo $Pr[9]; ?>, <?php echo $Te[9]; ?>, ],
                ['M11', <?php echo $Pr[10]; ?>, <?php echo $Te[10]; ?>, ],
                ['M12', <?php echo $Pr[11]; ?>, <?php echo $Te[11]; ?>, ]
            ]);

            var options = {
                title: 'Représentation graphique des valeurs',
                series: {
                    0: {
                        targetAxisIndex: 1
                    },
                    1: {
                        type: 'line',
                        targetAxisIndex: 0,
                    },
                },
                vAxis: {
                    0: {
                        title: 'Température (en °C)',
                        ticks: [0, 20, 40, 60, 80, 100, 120, 140]
                    },
                    1: {
                        title: 'Précipitation (en mm)',
                    }
                },
                hAxis: {
                    title: 'Mois'
                },
                seriesType: 'bars',
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        /*function doModifie() {
            document.getElementById('Ordonner').value = "Ordonner";
        }*/
    </script>
    <script>

    </script>
    <style>
        <?php
        include('FCSS/NORDcss.css');
        ?>
    </style>
    <?php include('navigation/head.php'); ?>
    <title>testClimatResultat</title>
</head>

<body>
    <?php include('navigation/header.php'); ?>
    <?php include('navigation/nav.php'); ?>
    <main>
        <section class="section_intro">
            <h1>TestClimat</h1>
            <p>Sans cookie, certaines fonctionnalités, comme la sauvegarde ou le téléchargement des résultats sont indisponibles. <br />Autorisez TestClimat à user des cookies pour profiter de ces fonctionnalitées.</p>
            <p><?php
                echo '<br /> Le climat trouvé est le suivant : <b>' . $NomClimat .  '</b>; Lettes associées : <b>' . $LettreClimat . '</b>'; ?></p>
        </section>
        <section class="section_milieu">
            <div>
                <br /><a href="index.php">Rentrer de nouvelles valeurs / Revenir à l'accueil.</a>
            </div>
            <table>
                <colgroup>
                    <col span="1" class="month">
                    <col span="1" class="ValeurTempérature">
                    <col span="1" class="ValeurPrécipitation">
                </colgroup>
                <tr>
                    <th class="month" scope="col"></th>
                    <th scope="col">
                        <label for="OrdreTe">Température °C</label>
                    </th>
                    <th scope="col">
                        <label for="OrdrePr">Précipitation (mm)</label>

                    </th>
                    <th scope="col">
                        <label for="OrdreGaussen">Mois Aride?</label>

                    </th>
                    <th scope="col">
                        <label for="OrdreMartonne">Indice de Martonne</label>

                    </th>
                </tr>
                <tr>
                    <th class=<?php echo $Saison[0] . 'month' ?> scope=row><?php echo $month[0]; ?></th>
                    <td class=<?php if ($Te[0] == $Tmax) {
                                    echo $Saison[0] . 'max';
                                } elseif ($Te[0] == $Tmin) {
                                    echo $Saison[0] . 'min';
                                } else {
                                    echo $Saison[0] . 'month';
                                } ?>><?php echo $Te[0] ?></td>
                    <td class=<?php if ($Pr[0] == $Pmax) {
                                    echo $Saison[0] . 'max';
                                } elseif ($Pr[0] == $Pmin) {
                                    echo $Saison[0] . 'min';
                                } else {
                                    echo $Saison[0] . 'month';
                                } ?>><?php echo $Pr[0] ?></td>
                    <td class=<?php echo $Saison[0] . 'month' ?>><?php echo $Ar[0] ?></td>
                    <td class=<?php if ($Im[0] == $IMmax) {
                                    echo $Saison[0] .  'max';
                                } elseif ($Im[0] == $IMmin) {
                                    echo $Saison[0] . 'min';
                                } else {
                                    echo $Saison[0] . 'month';
                                } ?>><?php echo $Im[0] ?></td>
                </tr>
                <tr>
                    <th class=<?php echo $Saison[1] . 'month' ?> scope="row"><?php echo $month[1]; ?></th>
                    <td class=<?php if ($Te[1] == $Tmax) {
                                    echo $Saison[1] . 'max';
                                } elseif ($Te[1] == $Tmin) {
                                    echo $Saison[1] . 'min';
                                } else {
                                    echo $Saison[1] . 'month';
                                } ?>><?php echo $Te[1] ?></td>
                    <td class=<?php if ($Pr[1] == $Pmax) {
                                    echo $Saison[1] . 'max';
                                } elseif ($Pr[1] == $Pmin) {
                                    echo $Saison[1] . 'min';
                                } else {
                                    echo $Saison[1] . 'month';
                                } ?>><?php echo $Pr[1] ?></td>
                    <td class=<?php echo $Saison[1] . 'month' ?>><?php echo $Ar[1] ?></td>
                    <td class=<?php if ($Im[1] == $IMmax) {
                                    echo $Saison[1] .  'max';
                                } elseif ($Im[1] == $IMmin) {
                                    echo $Saison[1] . 'min';
                                } else {
                                    echo $Saison[1] . 'month';
                                } ?>><?php echo $Im[1] ?></td>
                <tr>
                    <th class=<?php echo $Saison[2] . 'month' ?> scope="row"><?php echo $month[2]; ?></th>
                    <td class=<?php if ($Te[2] == $Tmax) {
                                    echo $Saison[2] . 'max';
                                } elseif ($Te[2] == $Tmin) {
                                    echo $Saison[2] . 'min';
                                } else {
                                    echo $Saison[2] . 'month';
                                } ?>><?php echo $Te[2] ?></td>
                    <td class=<?php if ($Pr[2] == $Pmax) {
                                    echo $Saison[2] . 'max';
                                } elseif ($Pr[2] == $Pmin) {
                                    echo $Saison[2] . 'min';
                                } else {
                                    echo $Saison[2] . 'month';
                                } ?>><?php echo $Pr[2] ?></td>
                    <td class=<?php echo $Saison[2] . 'month' ?>><?php echo $Ar[2] ?></td>
                    <td class=<?php if ($Im[2] == $IMmax) {
                                    echo $Saison[2] .  'max';
                                } elseif ($Im[2] == $IMmin) {
                                    echo $Saison[2] . 'min';
                                } else {
                                    echo $Saison[2] . 'month';
                                } ?>><?php echo $Im[2] ?></td>
                </tr>
                <tr>
                    <th class=<?php echo $Saison[3] . 'month' ?> scope="row"><?php echo $month[3]; ?></th>
                    <td class=<?php if ($Te[3] == $Tmax) {
                                    echo $Saison[3] . 'max';
                                } elseif ($Te[3] == $Tmin) {
                                    echo $Saison[3] . 'min';
                                } else {
                                    echo $Saison[3] . 'month';
                                } ?>><?php echo $Te[3] ?></td>
                    <td class=<?php if ($Pr[3] == $Pmax) {
                                    echo $Saison[3] . 'max';
                                } elseif ($Pr[3] == $Pmin) {
                                    echo $Saison[3] . 'min';
                                } else {
                                    echo $Saison[3] . 'month';
                                } ?>><?php echo $Pr[3] ?></td>
                    <td class=<?php echo $Saison[3] . 'month' ?>><?php echo $Ar[3] ?></td>
                    <td class=<?php if ($Im[3] == $IMmax) {
                                    echo $Saison[3] .  'max';
                                } elseif ($Im[3] == $IMmin) {
                                    echo $Saison[3] . 'min';
                                } else {
                                    echo $Saison[3] . 'month';
                                } ?>><?php echo $Im[3] ?></td>
                </tr>
                <tr>
                    <th class=<?php echo $Saison[4] . 'month' ?> scope="row"><?php echo $month[4]; ?></th>
                    <td class=<?php if ($Te[4] == $Tmax) {
                                    echo $Saison[4] . 'max';
                                } elseif ($Te[4] == $Tmin) {
                                    echo $Saison[4] . 'min';
                                } else {
                                    echo $Saison[4] . 'month';
                                } ?>><?php echo $Te[4] ?></td>
                    <td class=<?php if ($Pr[4] == $Pmax) {
                                    echo $Saison[4] . 'max';
                                } elseif ($Pr[4] == $Pmin) {
                                    echo $Saison[4] . 'min';
                                } else {
                                    echo $Saison[4] . 'month';
                                } ?>><?php echo $Pr[4] ?></td>
                    <td class=<?php echo $Saison[4] . 'month' ?>><?php echo $Ar[4] ?></td>
                    <td class=<?php if ($Im[4] == $IMmax) {
                                    echo $Saison[4] .  'max';
                                } elseif ($Im[4] == $IMmin) {
                                    echo $Saison[4] . 'min';
                                } else {
                                    echo $Saison[4] . 'month';
                                } ?>><?php echo $Im[4] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[5] . 'month' ?>" scope="row"><?php echo $month[5]; ?></th>
                    <td class=<?php if ($Te[5] == $Tmax) {
                                    echo $Saison[5] . 'max';
                                } elseif ($Te[5] == $Tmin) {
                                    echo $Saison[5] . 'min';
                                } else {
                                    echo $Saison[5] . 'month';
                                } ?>><?php echo $Te[5] ?></td>
                    <td class=<?php if ($Pr[5] == $Pmax) {
                                    echo $Saison[5] . 'max';
                                } elseif ($Pr[5] == $Pmin) {
                                    echo $Saison[5] . 'min';
                                } else {
                                    echo $Saison[5] . 'month';
                                } ?>><?php echo $Pr[5] ?></td>
                    <td class=<?php echo $Saison[5] . 'month' ?>><?php echo $Ar[5] ?></td>
                    <td class=<?php if ($Im[5] == $IMmax) {
                                    echo $Saison[5] .  'max';
                                } elseif ($Im[5] == $IMmin) {
                                    echo $Saison[5] . 'min';
                                } else {
                                    echo $Saison[5] . 'month';
                                } ?>><?php echo $Im[5] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[6] . 'month' ?>" scope="row"><?php echo $month[6]; ?></th>
                    <td class=<?php if ($Te[6] == $Tmax) {
                                    echo $Saison[6] .  'max';
                                } elseif ($Te[6] == $Tmin) {
                                    echo $Saison[6] . 'min';
                                } else {
                                    echo $Saison[6] . 'month';
                                } ?>><?php echo $Te[6] ?></td>
                    <td class=<?php if ($Pr[6] == $Pmax) {
                                    echo $Saison[6] .  'max';
                                } elseif ($Pr[6] == $Pmin) {
                                    echo $Saison[6] . 'min';
                                } else {
                                    echo $Saison[6] . 'month';
                                } ?>><?php echo $Pr[6] ?></td>
                    <td class=<?php echo $Saison[6] . 'month' ?>><?php echo $Ar[6] ?></td>
                    <td class=<?php if ($Im[6] == $IMmax) {
                                    echo $Saison[6] .  'max';
                                } elseif ($Im[6] == $IMmin) {
                                    echo $Saison[6] . 'min';
                                } else {
                                    echo $Saison[6] . 'month';
                                } ?>><?php echo $Im[6] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[7] . 'month' ?>" scope="row"><?php echo $month[7]; ?></th>
                    <td class=<?php if ($Te[7] == $Tmax) {
                                    echo $Saison[7] .  'max';
                                } elseif ($Te[7] == $Tmin) {
                                    echo $Saison[7] . 'min';
                                } else {
                                    echo $Saison[7] . 'month';
                                } ?>><?php echo $Te[7] ?></td>
                    <td class=<?php if ($Pr[7] == $Pmax) {
                                    echo $Saison[7] .  'max';
                                } elseif ($Pr[7] == $Pmin) {
                                    echo $Saison[7] . 'min';
                                } else {
                                    echo $Saison[7] . 'month';
                                } ?>><?php echo $Pr[7] ?></td>
                    <td class=<?php echo $Saison[7] . 'month' ?>><?php echo $Ar[7] ?></td>
                    <td class=<?php if ($Im[7] == $IMmax) {
                                    echo $Saison[7] .  'max';
                                } elseif ($Im[7] == $IMmin) {
                                    echo $Saison[7] . 'min';
                                } else {
                                    echo $Saison[7] . 'month';
                                } ?>><?php echo $Im[7] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[8] . 'month' ?>" scope="row"><?php echo $month[8]; ?></th>
                    <td class=<?php if ($Te[8] == $Tmax) {
                                    echo $Saison[8] .  'max';
                                } elseif ($Te[8] == $Tmin) {
                                    echo $Saison[8] . 'min';
                                } else {
                                    echo $Saison[8] . 'month';
                                } ?>><?php echo $Te[8] ?></td>
                    <td class=<?php if ($Pr[8] == $Pmax) {
                                    echo $Saison[8] .  'max';
                                } elseif ($Pr[8] == $Pmin) {
                                    echo $Saison[8] . 'min';
                                } else {
                                    echo $Saison[8] . 'month';
                                } ?>><?php echo $Pr[8] ?></td>
                    <td class=<?php echo $Saison[8] . 'month' ?>><?php echo $Ar[8] ?></td>
                    <td class=<?php if ($Im[8] == $IMmax) {
                                    echo $Saison[8] .  'max';
                                } elseif ($Im[8] == $IMmin) {
                                    echo $Saison[8] . 'min';
                                } else {
                                    echo $Saison[8] . 'month';
                                } ?>><?php echo $Im[8] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[9] . 'month' ?>" scope="row"><?php echo $month[9]; ?></th>
                    <td class=<?php if ($Te[9] == $Tmax) {
                                    echo $Saison[9] .  'max';
                                } elseif ($Te[9] == $Tmin) {
                                    echo $Saison[9] . 'min';
                                } else {
                                    echo $Saison[9] . 'month';
                                } ?>><?php echo $Te[9] ?></td>
                    <td class=<?php if ($Pr[9] == $Pmax) {
                                    echo $Saison[9] .  'max';
                                } elseif ($Pr[9] == $Pmin) {
                                    echo $Saison[9] . 'min';
                                } else {
                                    echo $Saison[9] . 'month';
                                } ?>><?php echo $Pr[9] ?></td>
                    <td class=<?php echo $Saison[9] . 'month' ?>><?php echo $Ar[9] ?></td>
                    <td class=<?php if ($Im[9] == $IMmax) {
                                    echo $Saison[9] .  'max';
                                } elseif ($Im[9] == $IMmin) {
                                    echo $Saison[9] . 'min';
                                } else {
                                    echo $Saison[9] . 'month';
                                } ?>><?php echo $Im[9] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[10] . 'month' ?>" scope="row"><?php echo $month[10]; ?></th>
                    <td class=<?php if ($Te[10] == $Tmax) {
                                    echo $Saison[10] .  'max';
                                } elseif ($Te[10] == $Tmin) {
                                    echo $Saison[10] . 'min';
                                } else {
                                    echo $Saison[10] . 'month';
                                } ?>><?php echo $Te[10] ?></td>
                    <td class=<?php if ($Pr[10] == $Pmax) {
                                    echo $Saison[10] .  'max';
                                } elseif ($Pr[10] == $Pmin) {
                                    echo $Saison[10] . 'min';
                                } else {
                                    echo $Saison[10] . 'month';
                                } ?>><?php echo $Pr[10] ?></td>
                    <td class=<?php echo $Saison[10] . 'month' ?>><?php echo $Ar[10] ?></td>
                    <td class=<?php if ($Im[10] == $IMmax) {
                                    echo $Saison[10] .  'max';
                                } elseif ($Im[10] == $IMmin) {
                                    echo $Saison[10] . 'min';
                                } else {
                                    echo $Saison[10] . 'month';
                                } ?>><?php echo $Im[10] ?></td>
                </tr>
                <tr>
                    <th class="<?php echo $Saison[11] . 'month' ?>" scope="row"><?php echo $month[11]; ?></th>
                    <td class=<?php if ($Te[11] == $Tmax) {
                                    echo $Saison[11] .  'max';
                                } elseif ($Te[11] == $Tmin) {
                                    echo $Saison[11] . 'min';
                                } else {
                                    echo $Saison[11] . 'month';
                                } ?>><?php echo $Te[11] ?></td>
                    <td class=<?php if ($Pr[11] == $Pmax) {
                                    echo $Saison[11] .  'max';
                                } elseif ($Pr[11] == $Pmin) {
                                    echo $Saison[11] . 'min';
                                } else {
                                    echo $Saison[11] . 'month';
                                } ?>><?php echo $Pr[11] ?></td>
                    <td class=<?php echo $Saison[11] . 'month' ?>><?php echo $Ar[11] ?></td>
                    <td class=<?php if ($Im[11] == $IMmax) {
                                    echo $Saison[11] .  'max';
                                } elseif ($Im[11] == $IMmin) {
                                    echo $Saison[11] . 'min';
                                } else {
                                    echo $Saison[11] . 'month';
                                } ?>><?php echo $Im[11] ?></td>
                </tr>
            </table>
            <p class="legende">
                Pour détermier si un mois est aride nous utilisons l'indice Gaussen.
                <br /> Cette indice est calculé ainsi : Un mois est aride si P
                < 2T. <br /><br />Pour en savoir plus sur l'indice de Martonne <a href="https://fr.wikipedia.org/wiki/Aridit%C3%A9">Indice de Martonne</a>, <a href="testClimatAide.php#Martonne">Aide.</a>
            </p>
        </section>
        <section class="section_fin">
            <p>
                <?php
                /*Annonce du climat trouvé */
                /*echo 'Variable ClimatTrouvé : ' . $ClimatTrouvé;*/
                echo /*'<br /> Variable Nord et */ 'Hémisphère : '/* . $Nord . ' ; '*/ . $Hémisphère;
                echo '<br /> Le climat trouvé est le suivant : <b>' . $NomClimat .  '</b>; Lettes associées : <b>' . $LettreClimat . '</b>';

                /*Annonce des variables calculé */
                echo '<br /><br /> Variables Tmax, Tmin et Tmannuelle : ' . $Tmax . '  ' . $Tmin . ' ; ' . $Tannuelle;
                echo '<br /><br /> Variables Pmax : '/*, Pmax et Pwmax : '*/ . $Pmax /*. ' ; ' . $Pmax . ' ; ' . $Pwmax*/;
                echo '<br /> Variables Pmin : '/*, Pmin et Pwmin : '*/ . $Pmin/* . ' ; ' . $Pmin . ' ; ' . $Pwmin*/;
                echo '<br /> Variables Pannuelle,' /* Phiver et Pété : '*/ . $Pannuelle/* . ' ; ' . $Phiver . ' ; ' . $Pété*/;
                //echo '<br /><br />' . /*'Variables PTHTrouvé et'*/ 'PTH : '/* . $PTHTrouvé . ' ; '*/ . $PTH;
                /*echo '<br /><br /> Variables b, i et Compte : ' . $b . ' ; ' . $i . ' ; ' . $Compte; */
                //echo '<br /><br /> Nombre de mois aride : ' . $NbAride . ' (Selon l \'indice de Gaussen).';
                ?>
            </p>
            <p>
            <div id="chart_div" class="chart_div"></div>
            D'après le tableau de valeurs ci-dessus.
            </p>
        </section>
    </main>
    <footer>
        <?php include('navigation/footer.php'); ?>
    </footer>
</body>
</body>

</html>