<?php
/* Add bg-color to configuratino layout */
add_filter('acf/load_field/name=bg_color', 'pip_load_color_to_config');
function pip_load_color_to_config($field) {

    $field['choices'] = array();
    $new_colors = array();
    $colors = PIP_TinyMCE::get_custom_colors();

    foreach ($colors as $color):
        $new_class = str_replace("text-", "", $color['classes']);
        $new_colors[] = array(
            'name'      =>  $color['name'],
            'font'      =>  $color['name'],
            'classes'   =>  'bg-'.$new_class,
        ); 
    endforeach;

    if (is_array($new_colors)):
        foreach($new_colors as $color):
            $value = $color['classes'];
            $label = $color['name'];
            $field['choices'][$value] = $label;  
        endforeach;
    endif;
    return $field;
}

/* Pagination */
function pip_pagination($numpages = '', $pagerange = '', $paged='') {

    if (empty($pagerange)):
        $pagerange = 2;
    endif;

    global $paged;
    if (empty($paged)):
        $paged = 1;
    endif;

    if ($numpages == ''):
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if(!$numpages):
            $numpages = 1;
        endif;
    endif;
    $paginate_links = paginate_links(
        array(
            'base'            => get_pagenum_link(1) . '%_%',
            'format'          => 'page/%#%',
            'total'           => $numpages,
            'current'         => $paged,
            'show_all'        => false,
            'end_size'        => 1,
            'mid_size'        => $pagerange,
            'prev_next'       => false,
            'type'            => 'plain',
            'add_args'        => false,
            'add_fragment'    => ''
        )
    );
    if ($paginate_links):
        echo '<div><div class="pagination flex items-center justify-between w-full">'  . $paginate_links . '</div></div>';
    endif;
}