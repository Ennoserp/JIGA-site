<?php
    header('Content-Type: application/json');

    $lamps = get_posts(
        [
            'post_type' => 'lampadaire'
        ]
    );
?>{
    "type": "FeatureCollection",
    "crs": {
        "type": "name",
        "properties": {
            "name": "lamps"
        }
    },
    "features": [

        <?php if( is_array( $lamps ) ) : ?>
        <?php foreach( $lamps as $key => $lamp ) : ?>
        

        <?php echo $key > 0 ? ',' : ''; ?>

        {
            "type": "Feature",
            "properties": {
                "id": "<?php echo esc_html( $lamp->post_title ); ?>"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    <?php echo esc_html( get_field( 'lng', $lamp->ID ) ); ?>,
                    <?php echo esc_html( get_field( 'lat', $lamp->ID ) ); ?>         
                ]
            }
        }

        <?php endforeach ; ?>
        <?php endif ; ?>

    ]
}