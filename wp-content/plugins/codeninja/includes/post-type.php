<?php

namespace CN\Film;

// Register Custom Post Type
add_action( 'init', function () {

    $labels = array(
        'name'                  => _x( 'Films', 'Post Type General Name', 'cn' ),
        'singular_name'         => _x( 'Film', 'Post Type Singular Name', 'cn' ),
        'menu_name'             => __( 'Films', 'cn' ),
        'name_admin_bar'        => __( 'Film', 'cn' ),
        'archives'              => __( 'Item Archives', 'cn' ),
        'attributes'            => __( 'Item Attributes', 'cn' ),
        'parent_item_colon'     => __( 'Parent Item:', 'cn' ),
        'all_items'             => __( 'All Items', 'cn' ),
        'add_new_item'          => __( 'Add New Item', 'cn' ),
        'add_new'               => __( 'Add New', 'cn' ),
        'new_item'              => __( 'New Item', 'cn' ),
        'edit_item'             => __( 'Edit Item', 'cn' ),
        'update_item'           => __( 'Update Item', 'cn' ),
        'view_item'             => __( 'View Item', 'cn' ),
        'view_items'            => __( 'View Items', 'cn' ),
        'search_items'          => __( 'Search Item', 'cn' ),
        'not_found'             => __( 'Not found', 'cn' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'cn' ),
        'featured_image'        => __( 'Featured Image', 'cn' ),
        'set_featured_image'    => __( 'Set featured image', 'cn' ),
        'remove_featured_image' => __( 'Remove featured image', 'cn' ),
        'use_featured_image'    => __( 'Use as featured image', 'cn' ),
        'insert_into_item'      => __( 'Insert into item', 'cn' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'cn' ),
        'items_list'            => __( 'Items list', 'cn' ),
        'items_list_navigation' => __( 'Items list navigation', 'cn' ),
        'filter_items_list'     => __( 'Filter items list', 'cn' ),
    );
    $args = array(
        'label'                 => __( 'Films', 'cn' ),
        'description'           => __( 'Post Type Description', 'cn' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'film-category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'film', $args );


    $labels = array(
        'name'                       => _x( 'Film categories', 'Taxonomy General Name', 'cn' ),
        'singular_name'              => _x( 'Film category', 'Taxonomy Singular Name', 'cn' ),
        'menu_name'                  => __( 'Categories', 'cn' ),
        'all_items'                  => __( 'All Items', 'cn' ),
        'parent_item'                => __( 'Parent Item', 'cn' ),
        'parent_item_colon'          => __( 'Parent Item:', 'cn' ),
        'new_item_name'              => __( 'New Item Name', 'cn' ),
        'add_new_item'               => __( 'Add New Item', 'cn' ),
        'edit_item'                  => __( 'Edit Item', 'cn' ),
        'update_item'                => __( 'Update Item', 'cn' ),
        'view_item'                  => __( 'View Item', 'cn' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'cn' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'cn' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'cn' ),
        'popular_items'              => __( 'Popular Items', 'cn' ),
        'search_items'               => __( 'Search Items', 'cn' ),
        'not_found'                  => __( 'Not Found', 'cn' ),
        'no_terms'                   => __( 'No items', 'cn' ),
        'items_list'                 => __( 'Items list', 'cn' ),
        'items_list_navigation'      => __( 'Items list navigation', 'cn' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'film-category', array( 'film' ), $args );


}, 0);

add_filter( 'the_content', function ( $content ) {
    if ( is_singular('film') ) {

        $subtitle = get_post_meta( get_the_ID(), 'subtitle', true );
        if ( $subtitle ) {
            $content = '<h2 class="entry-subtitle">' . $subtitle . '</h2>' . $content;
        }
    }
    return $content;
});