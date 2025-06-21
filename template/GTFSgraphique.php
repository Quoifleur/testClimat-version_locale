<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Récupération du contexte du canvas
    var ctx = document.getElementById('myChart').getContext('2d');

    // Création du graphique en ligne
    var myLineChart = new Chart(ctx, {
        type: 'line', // Type de graphique : ligne
        data: {
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'], // Étiquettes de l'axe X
            datasets: [{
                label: 'Ventes mensuelles', // Légende du jeu de données
                data: [65, 59, 80, 81, 56, 55], // Données du jeu de données
                fill: false, // Ne pas remplir sous la ligne
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de fond de la ligne
                borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                borderWidth: 2, // Largeur de la ligne
                tension: 0.1 // Tension de la ligne (courbure)
            }]
        },
        options: {
            responsive: true, // Rendre le graphique responsive
            scales: {
                y: {
                    beginAtZero: true, // Commencer l'axe Y à zéro
                    title: {
                        display: true,
                        text: 'Ventes'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Graphique des ventes mensuelles', // Titre du graphique
                    font: {
                        size: 18
                    }
                },
                legend: {
                    position: 'top', // Position de la légende
                }
            }
        }
    });
</script>