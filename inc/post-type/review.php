<?php

/**
 * Register Custom Post Type
 *
 */
function wp_simple_reviews_post_type() {

    $labels = array(
        'name'                  => _x( 'Review', 'Post Type General Name', 'wp-simple-reviews' ),
        'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'wp-simple-reviews' ),
        'menu_name'             => __( 'Reviews', 'wp-simple-reviews' ),
        'name_admin_bar'        => __( 'Review', 'wp-simple-reviews' ),
        'archives'              => __( 'Review Archives', 'wp-simple-reviews' ),
        'attributes'            => __( 'Review Attributes', 'wp-simple-reviews' ),
        'all_items'             => __( 'All Reviews', 'wp-simple-reviews' ),
        'add_new_item'          => __( 'Add New Review', 'wp-simple-reviews' ),
        'add_new'               => __( 'Add New Review', 'wp-simple-reviews' ),
        'new_item'              => __( 'New Review', 'wp-simple-reviews' ),
        'edit_item'             => __( 'Edit Review', 'wp-simple-reviews' ),
        'update_item'           => __( 'Update Review', 'wp-simple-reviews' ),
        'view_item'             => __( 'View Review', 'wp-simple-reviews' ),
        'view_items'            => __( 'View Reviews', 'wp-simple-reviews' ),
        'search_items'          => __( 'Search Review', 'wp-simple-reviews' ),
        'not_found'             => __( 'Not found', 'wp-simple-reviews' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'wp-simple-reviews' ),
        'insert_into_item'      => __( 'Insert into Review', 'wp-simple-reviews' ),
        'uploaded_to_this_item' => __( 'Uploaded to this review', 'wp-simple-reviews' ),
        'items_list'            => __( 'Reviews list', 'wp-simple-reviews' ),
        'items_list_navigation' => __( 'Reviews list navigation', 'wp-simple-reviews' ),
        'filter_items_list'     => __( 'Filter Reviews list', 'wp-simple-reviews' ),
    );
    $capabilities = array(
        'edit_post' => 'edit_review',
        'edit_posts' => 'edit_reviews',
        'edit_others_posts' => 'edit_other_reviews',
        'publish_posts' => 'publish_reviews',
        'read_post' => 'read_review',
        'read_private_posts' => 'read_private_reviews',
        'delete_posts' => 'delete_reviews'
    );
    $args = array(
        'label'                 => __( 'Review', 'wp-simple-reviews' ),
        'description'           => __( 'Managing review entries', 'wp-simple-reviews' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-quote',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'review',
        'capabilities'          => $capabilities,
        'show_in_rest'          => true,
    );
    register_post_type( 'review', $args );

}
add_action( 'init', 'wp_simple_reviews_post_type', 0 );


/**
 * Add columns to post type
 *
 */

// Add the custom columns to the book post type:
function set_custom_columns_to_review($columns) {
    unset( $columns['author'] );
    unset( $columns['date'] );

    return array_merge ( $columns, array (
        'company' => __( 'Company', 'wp-simple-reviews' ),
        'fullname' => __( 'Name', 'wp-simple-reviews' ),
        'rating' => __( 'Rating', 'wp-simple-reviews' ),
        'date' => __('Date')
    ) );

}
add_filter( 'manage_review_posts_columns', 'set_custom_columns_to_review' );


// Add the data to the custom columns for the book post type:
function custom_review_column( $column, $post_id ) {
    switch ( $column ) {

        case 'company' :
            if ( get_post_meta( $post_id , 'review_company' , true ) ) {
                echo get_post_meta( $post_id , 'review_company' , true );
            } else {
                echo '-';
            }
            break;

        case 'fullname' :
            if ( get_post_meta( $post_id , 'review_first_name' , true ) OR get_post_meta($post_id, 'review_last_name') ) {
                echo get_post_meta( $post_id , 'review_first_name' , true ) . ' '. get_post_meta( $post_id , 'review_last_name' , true ) ;
            } else {
                echo '-';
            }
            break;

        case 'rating' :
            if ( get_post_meta( $post_id , 'review_rating' , true ) ) {
                echo get_post_meta( $post_id , 'review_rating' , true );
            } else {
                echo '-';
            }
            break;

    }
}
add_action( 'manage_review_posts_custom_column' , 'custom_review_column', 10, 2 );