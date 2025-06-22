<?php
$TripsByRoute = [];
if (isset($TripInfo)) {
    foreach ($TripInfo as $trip) {
        if (isset($trip['route_id'], $trip['trip_id'])) {
            $TripsByRoute[$trip['route_id']][] = $trip['trip_id'];
        }
    }
}
?>
<script>
    var tripsData = <?php echo json_encode($TripsByRoute); ?>;
    document.addEventListener('DOMContentLoaded', function () {
        const routeSelect = document.getElementById('graphique-route-select');
        const tripForm = document.getElementById('graphique-trips-form');
        const tripSelect = document.getElementById('graphique-trips-select');

        routeSelect.addEventListener('change', function () {
            const routeId = this.value;
            tripSelect.innerHTML = '';
            if (tripsData[routeId] && tripsData[routeId].length > 0) {
                tripsData[routeId].forEach(function (tripId) {
                    const option = document.createElement('option');
                    option.value = tripId;
                    option.textContent = tripId;
                    tripSelect.appendChild(option);
                });
                tripForm.style.display = '';
            } else {
                tripForm.style.display = 'none';
            }
        });

        // Optionnel : déclenche la sélection sur la première route au chargement
        if (routeSelect.value) {
            routeSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
<form id="graphique-form">
    <label for="graphique-route-select">Route</label>
    <select id="graphique-route-select" name="graphique-route-select">
        <?php
        if (isset($RouteInfo)) {
            foreach ($RouteInfo as $route) {
                if (isset($route['route_id']) && isset($route['route_color']) && isset($route['route_text_color'])) {
                    echo '<option value="' . htmlspecialchars($route['route_id']) . '" style="color: #' . htmlspecialchars($route['route_text_color']) . '; background-color: #' . htmlspecialchars($route['route_color']) . ';">' . htmlspecialchars($route['route_id']) . '</option>';
                }
            }
        } else {
            echo '<option value="NA">Aucune route disponible</option>';
        }
        ?>
    </select>
</form>
<form id="graphique-trips-form" style="display:none;">
    <label for="graphique-trips-select">Trip</label>
    <select id="graphique-trips-select" name="graphique-trips-select">
    </select>
    <button type="submit">Valider</button>
</form>

<canvas id="myChart" width="400" height="400"></canvas>