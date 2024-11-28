<?php
function super_geojson_drawing($url, $GLOBALcouleur)
{
    $features = geojson_extract($url);
    $GLOBALshape = geojson_shapeINarrays($features);
    geojson_drawing($GLOBALshape, $GLOBALcouleur);
}
