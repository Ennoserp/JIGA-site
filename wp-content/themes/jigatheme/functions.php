<?php
    function wpm_custom_post_type() {

        $labels = array(
            'name'                => _x( 'Lampadaires', 'Post Type General Name'),
            'singular_name'       => _x( 'Lampadaire', 'Post Type Singular Name'),
            'menu_name'           => __( 'Lampadaires'),
            'all_items'           => __( 'Tous les lampadaires'),
            'view_item'           => __( 'Voir les lampadaires'),
            'add_new_item'        => __( 'Ajouter un lampadaire'),
            'add_new'             => __( 'Ajouter'),
            'edit_item'           => __( 'Editer un lampadaire'),
            'update_item'         => __( 'Modifier un lampadaire'),
            'search_items'        => __( 'Rechercher un lampadaires'),
            'not_found'           => __( 'Non trouvée'),
            'not_found_in_trash'  => __( 'Non trouvée dans la corbeille'),
        );
        
        $args = array(
            'label'               => __( 'Lampadaires'),
            'description'         => __( 'Tous les lampadaires'),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'show_in_rest'        => true,
            'hierarchical'        => false,
            'public'              => true,
            'has_archive'         => true,
            'menu_icon'           => 'dashicons-lightbulb',
            'rewrite'			  => array( 'slug' => 'lampadaire'),
    
        );

        register_post_type( 'lampadaire', $args );
    
    }
    
    add_action( 'init', 'wpm_custom_post_type', 0 );