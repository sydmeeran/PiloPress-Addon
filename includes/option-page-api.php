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
        'update_button' => 'Mettre à jour',
        'updated_message' => 'Options mise à jour',
    ));
    
}
