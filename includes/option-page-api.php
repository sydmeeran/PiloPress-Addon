<?php
if ( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page(array(
        'page_title' => 'API',
        'menu_title' => 'pip_addon_options',
        'menu_slug' => 'api',
        'capability' => 'edit_posts',
        'position' => '',
        'parent_slug' => 'pilopress',
        'icon_url' => '',
        'redirect' => true,
        'post_id' => 'options',
        'autoload' => false,
        'update_button' => __( 'Mettre à jour', 'pip-addon' ),
        'updated_message' => __( 'Options mises à jour', 'pip-addon' ),
    ));
    
}
