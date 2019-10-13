<?php
/*
Template Name: Carte
*/

if( ! is_user_logged_in() ) {
    wp_redirect( get_home_url() );
}

get_header();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Carte des lampadaires</h1>
  <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Exporter les données</a>
</div>

        <div id='map' style='width: 100%; height: 700px;'></div>

        <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYXJuYXVka3N0dWQiLCJhIjoiY2sxbm1xeHdiMGM3NzNjcWtzZHhuY3g0NCJ9.414u70WFpax7al_AuexSQQ';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v10',
        center: [ 3.086290380287169, 45.77695487061216 ],
        zoom: 16
        });
        
        map.on('load', function() {
        map.addSource("earthquakes", {
        type: "geojson",
        data: "<?php echo get_site_url(); ?>/api/",
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

        <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

<?php

get_footer();