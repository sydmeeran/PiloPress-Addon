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