<?php

/**
 * Pagination
 *
 * @param string $num_pages
 * @param string $page_range
 * @param string $paged
 * @param string $query
 */
function pip_pagination( $num_pages = '', $page_range = '', $paged = '', $query = '' ) {

    // Set page_range if empty
    $page_range = $page_range ? $page_range : 2;

    // Set paged if empty
    global $paged;
    $paged = $paged ? $paged : 1;

    // Set num_pages
    global $wp_query;
    if ( $query ) {
        $wp_query = $query;
    }

    $num_pages = ( $num_pages ? $num_pages : $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;

    // Get paginate links
    $pagination_numbers = paginate_links(
        array(
            'base'         => trailingslashit( get_pagenum_link( 1 ) ) . '%_%',
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
    if ( !$pagination_numbers ) {
        return;
    }

    // Display pagination links
    ob_start(); ?>
    <div class="pagination relative flex items-center justify-center w-full">

        <?php
        // Page précédente
        if ( $paged > 1 ) : ?>
        <a
            class="pagination-previous mr-auto hidden md:block"
            href="<?php echo get_pagenum_link( $paged - 1 ); ?>"
            >
            <span class="far fa-sm fa-arrow-left mr-1"></span>
            <?php _e( 'Page précédente', 'pilot-in' ); ?>
        </a>
        <?php endif; ?>

        <?php
        // Pages numérotées ?>
        <div class="pagination-numbers absolute inset-auto">
            <?php echo $pagination_numbers; ?>
        </div>

        <?php
        // Page suivante
        if ( $paged < $num_pages ) : ?>
        <a
            class="pagination-next ml-auto hidden md:block"
            href="<?php echo get_pagenum_link( $paged + 1 ); ?>"
            >
            <?php _e( 'Page suivante', 'pilot-in' ); ?>
            <span class="far fa-sm fa-arrow-right ml-1"></span>
        </a>
        <?php endif; ?>

    </div>
    <?php
    echo ob_get_clean();
}

/**
 *  Retrieve layouts based on given "acf_fc_layout" in the pip_flexible of given post
 *
 * @param mixed  $layouts , string or array of strings of the layouts' "acf_fc_layout"
 * @param string $post_id
 *
 * @return mixed false if no layouts were found, if found an array of layouts
 */
function pip_get_flexible_layout( $layouts, $post_id = '' ) {

    $response = false;

    if ( !$layouts ) {
        return $response;
    }

    $pip_flexible_name = (string) PIP_Flexible::get_flexible_field_name();
    $post_id           = $post_id ? $post_id : get_the_ID();
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

/**
 *  Flatten a multidimensional array
 *
 * @param $array
 *
 * @return array|false
 */
function array_flatten_recursive( $array ) {

    if ( !$array ) {
        return false;
    }

    $flat = array();
    $RII  = new RecursiveIteratorIterator( new RecursiveArrayIterator( $array ) );

    foreach ( $RII as $value ) {
        $flat[] = $value;
    }

    return $flat;
}

/**
 *  PIP - Get Sized Image URL - Usefull for getting sized URL in one line (most usefull case with ACF Image)
 *
 *  @param mixed $img image array or image ID
 *  @param string $size image size
 *
 *	@return string URL of the sized image
 *
 *  Example of use case : echo pip_get_sized_image_url( get_sub_field('img'), 'full' )
 */
function pip_get_sized_image_url( $img, $size = 'thumbnail' ) {
    if ( empty( $img ) ) {
        return;
    }

    if ( is_array( $img ) ) {
        $img = pip_maybe_get( $img, 'ID' );
    }

    $attachment = wp_get_attachment_image_src( $img, $size );

    return reset( $attachment );
}
