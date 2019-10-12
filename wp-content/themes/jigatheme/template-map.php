<?php
/*
Template Name: Carte
*/

?><!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Carte des poteaux</title>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" rel="stylesheet" />
        <script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />
        <style>
            html, body{
                height: 100%;
            }
        </style>
    </head>
    <body class="">

        <!--<h1>Carte des lampadaires de la ville</h1>-->

        <div id='map' style='width: 100%; height: 100%;'></div>

        <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYXJuYXVka3N0dWQiLCJhIjoiY2sxbm1xeHdiMGM3NzNjcWtzZHhuY3g0NCJ9.414u70WFpax7al_AuexSQQ';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v10',
        center: [ 3.083156, 45.773540 ],
        zoom: 19
        });
        
        map.on('load', function() {
        map.addSource("earthquakes", {
        type: "geojson",
        data: "<?php echo get_template_directory_uri(); ?>/points.json",
        cluster: true,
        clusterMaxZoom: 16,
        clusterRadius: 50
        });
        
        map.addLayer({
        id: "clusters",
        type: "circle",
        source: "earthquakes",
        filter: ["has", "point_count"],
        paint: {
        "circle-color": [
        "step",
        ["get", "point_count"],
        "#51bbd6",
        100,
        "#f1f075",
        750,
        "#f28cb1"
        ],
        "circle-radius": [
        "step",
        ["get", "point_count"],
        20,
        100,
        30,
        750,
        40
        ]
        }
        });
        
        map.addLayer({
        id: "cluster-count",
        type: "symbol",
        source: "earthquakes",
        filter: ["has", "point_count"],
        layout: {
        "text-field": "{point_count_abbreviated}",
        "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
        "text-size": 12
        }
        });
        
        map.addLayer({
        id: "unclustered-point",
        type: "circle",
        source: "earthquakes",
        filter: ["!", ["has", "point_count"]],
        paint: {
        "circle-color": "#11b4da",
        "circle-radius": 8 ,
        "circle-stroke-width": 1,
        "circle-stroke-color": "#fff"
        }
        });
        
        map.on('click', 'clusters', function (e) {
        var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
        var clusterId = features[0].properties.cluster_id;
        map.getSource('earthquakes').getClusterExpansionZoom(clusterId, function (err, zoom) {
        if (err)
        return;
        
        map.easeTo({
        center: features[0].geometry.coordinates,
        zoom: zoom
        });
        });
        });
        
        map.on('mouseenter', 'clusters', function () {
        map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'clusters', function () {
        map.getCanvas().style.cursor = '';
        });
        });
        </script>

    </body>
</html>