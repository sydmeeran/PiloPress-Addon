<?php
get_header();

if ( function_exists( 'the_pip_content' ) ) {

    $current_term       = get_queried_object();
    $current_taxo_name  = pip_maybe_get( $current_term, 'taxonomy' );
    $current_taxo       = $current_taxo_name ? get_taxonomy( $current_taxo_name ) : '';
    $posts_type_related = pip_maybe_get( $current_taxo, 'object_type' );
    $post_type_related  = !empty( $posts_type_related ) ? reset( $posts_type_related ) : '';

    switch ( $post_type_related ) {
        case 'post':
            $archive_id = get_option( 'page_for_posts' );
            break;

        case 'product':
            $archive_id = wc_get_page_id( 'shop' );
            break;

        default:
            $archive_id = $post_type_related . '_archive';
            break;
    }

    the_pip_content( $archive_id );
}

get_footer();
