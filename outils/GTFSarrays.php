<?
$stops = [
    "stop_id" => null,
    "stop_code" => null,
    "stop_name" => null,
    "tts_stop_name" => null,
    "stop_desc" => null,
    "stop_lat" => null,
    "stop_lon" => null,
    "zone_id" => null,
    "stop_url" => null,
    "location_type" => null,
    "parent_station" => null,
    "stop_timezone" => null,
    "wheelchair_boarding" => null,
    "level_id" => null,
    "platform_code" => null,
];
$trips = [
    "route_id" => null, // Identifie une route.
    "service_id" => null, // Identifie un ensemble de dates de service.
    "trip_id" => null, // Identifie un voyage unique.
    "trip_headsign" => null, // Texte de destination pour les voyageurs.
    "trip_short_name" => null, // Nom public pour identifier le voyage.
    "direction_id" => null, // Indique la direction du voyage.
    "block_id" => null, // Identifie un bloc auquel le voyage appartient.
    "shape_id" => null, // Identifie une forme géospatiale (conditionnel).
    "wheelchair_accessible" => null, // Accessibilité pour les fauteuils roulants.
    "bikes_allowed" => null, // Indique si les vélos sont autorisés.
];

$routes = [
    "route_id" => null, // Identifie une route.
    "agency_id" => null, // Agence pour la route spécifiée (conditionnel).
    "route_short_name" => null, // Nom court d'une route (ex. : "32").
    "route_long_name" => null, // Nom complet d'une route.
    "route_desc" => null, // Description d'une route.
    "route_type" => null, // Type de transport utilisé sur une route.
    "route_url" => null, // URL d'une page sur cette route.
    "route_color" => null, // Couleur publique associée à la route.
    "route_text_color" => null, // Couleur du texte pour contraste avec `route_color`.
    "route_sort_order" => null, // Ordre de tri des routes pour affichage.
    "continuous_pickup" => null, // Ramassage continu (conditionnel).
    "continuous_drop_off" => null, // Dépose continue (conditionnel).
    "network_id" => null, // Identifie un groupe de routes.
];