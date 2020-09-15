<?php
get_header();

if ( function_exists( 'the_pip_content' ) ) {

    $post_type_related  = get_post_type();
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
