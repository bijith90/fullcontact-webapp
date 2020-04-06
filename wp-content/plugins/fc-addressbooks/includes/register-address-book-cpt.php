<?php 
// Register Address Custom Post Type
function fc_register_address_cpt() {
    register_post_type('fc_address',
        array(
            'labels'      => array(
                'name'          => __('Addresses', 'fcaddressbooks'),
                'singular_name' => __('Address', 'fcaddressbooks'),
            ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 6,
            'menu_icon'             => 'dashicons-book-alt',
            'show_in_nav_menus'     => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'has_archive'           => true,
            'query_var'             => true,
            'can_export'            => true,
            'rewrite'               => array('slug' => 'address')
        )
    );

    flush_rewrite_rules();
}
add_action('init', 'fc_register_address_cpt');
?>