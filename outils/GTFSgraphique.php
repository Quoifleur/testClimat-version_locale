<?php
$trip_id_selectionne = $_POST['graphique-trips-select'] ?? null;

$filePath = 'upload/extract' . $fichier . '/stop_times.txt';
$handle = new SplFileObject($filePath, 'r');
$handle->setFlags(SplFileObject::READ_CSV);
$data = $handle->fgetcsv();
$arrival_time_key = array_search('arrival_time', $data) ?? null;
$departure_time_key = array_search('departure_time', $data) ?? null;
$trip_id_key = array_search('trip_id', $data) ?? null;
$data = $handle->fgetcsv();
$témoin = 0;

if ($arrival_time_key !== false && $departure_time_key !== false && $trip_id_key !== false && $trip_id_selectionne !== null) {
    $stop_times = [];
    while (($data = $handle->fgetcsv()) !== false) {
        if (($data[$trip_id_key] ?? null) === $trip_id_selectionne) {
            $stop_times[] = [
                'travel_time' => $data[$arrival_time_key] . ',' . $data[$departure_time_key] ?? null,
                'trip_id' => $data[$trip_id_key] ?? null
            ];
        }
    }
    unset($data, $arrival_time_key, $departure_time_key, $trip_id_key, $handle, $filePath);
} else {
    echo "Erreur : Impossible de trouver les clés nécessaires dans le fichier stop_times.txt.";
    exit;
}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Récupération du contexte du canvas
    var ctx = document.getElementById('myChart').getContext('2d');
    var travelTimes = <?php echo json_encode(array_column($stop_times, 'travel_time')); ?>;
    // Création du graphique en ligne
    var myLineChart = new Chart(ctx, {
        type: 'line', // Type de graphique : ligne
        data: {
            labels: [], // Étiquettes de l'axe X
            datasets: [{
                label: 'Ventes mensuelles', // Légende du jeu de données
                data: travelTimes, // Données du jeu de données
                fill: false, // Ne pas remplir sous la ligne
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de fond de la ligne
                borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                borderWidth: 2, // Largeur de la ligne
                tension: 0 // Tension de la ligne (courbure)
            }]
        },
        options: {
            responsive: true, // Rendre le graphique responsive
            scales: {
                y: {
                    beginAtZero: true, // Commencer l'axe Y à zéro
                    title: {
                        display: true,
                        text: 'Arrêts'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Heures'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Graphique', // Titre du graphique
                    font: {
                        size: 20
                    }
                },
                legend: {
                    position: 'top', // Position de la légende
                }
            }
        }
    });
</script>