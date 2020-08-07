<?php

/**
 * Pagination
 *
 * @param string $num_pages
 * @param string $page_range
 * @param string $paged
 */
function pip_pagination( $num_pages = '', $page_range = '', $paged = '' ) {

    // Set page_range if empty
    $page_range = $page_range ? $page_range : 2;

    // Set paged if empty
    global $paged;
    $paged = $paged ? $paged : 1;

    // Set num_pages
    global $wp_query;
    $num_pages = $num_pages ? $num_pages : $wp_query->max_num_pages ? $wp_query->max_num_pages : 1;

    // Get paginate links
    $paginate_links = paginate_links(
        array(
            'base'         => get_pagenum_link( 1 ) . '%_%',
            'format'       => 'page/%#%',
            'total'        => $num_pages,
            'current'      => $paged,
            'show_all'     => false,
            'end_size'     => 1,
            'mid_size'     => $page_range,
            'prev_next'    => false,
            'type'         => 'plain',
            'add_args'     => false,
            'add_fragment' => '',
        )
    );

    // If no paginate links, return
    if ( !$paginate_links ) {
        return;
    }

    // Display pagination links
    echo '<div class="pagination flex items-center justify-between w-full">' . $paginate_links . '</div>';
}


/**
 *  PIP - Helper
 *  - Retrieve layouts based on given "acf_fc_layout" in the pip_flexible of given post
 *
 *  @param mixed $layouts, string or array of strings of the layouts' "acf_fc_layout"
 *  @param integer $post_id
 *  @return mixed false if no layouts were found, if found an array of layouts
 */

function pip_get_flexible_layout( $layouts, $post_id = '' ) {

    $response = false;

    if ( !$layouts ) {
        return $response;
    }

    $pip_flexible_name = (string) PIP_Flexible::get_flexible_field_name();
    $post_id           = $post_id ?? get_the_ID();
    $pip_flexible      = get_field( $pip_flexible_name, $post_id );

    if ( !$pip_flexible ) {
        return $response;
    }

    if ( !is_array( $layouts ) ) {
        $layouts = array( $layouts );
    }

    $found_layouts = array();
    foreach ( $pip_flexible as $position => $layout ) {
        $layout_name = pip_maybe_get( $layout, 'acf_fc_layout' );

        if ( in_array( $layout_name, $layouts ) ) {
            $found_layouts[ $position ] = pip_maybe_get( $pip_flexible, $position );
        }
    }

    if ( !empty( $found_layouts ) ) {
        $response = $found_layouts;
    }

    return $response;

}
