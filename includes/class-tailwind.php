<?php

defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'PIP_Addon_Tailwind' ) ) {

    /**
     * Class PIP_Addon_Tailwind
     */
    class PIP_Addon_Tailwind {

        /**
         * PIP_Addon_Tailwind constructor.
         */
        public function __construct() {

            // Pilo'Press v0.4
            add_filter( 'acf/load_value/key=field_body_classes', array( $this, 'tw_body_class' ), 20, 1 );
            add_filter( 'acf/load_value/name=pip_typography', array( $this, 'tw_typography' ), 20, 1 );
            add_filter( 'acf/load_value/name=pip_simple_colors', array( $this, 'tw_simple_colors' ), 20, 1 );
            add_filter( 'acf/load_value/name=pip_colors_shades', array( $this, 'tw_color_variants' ), 20, 1 );
            add_filter( 'acf/load_value/name=pip_button', array( $this, 'tw_buttons' ), 20, 1 );
            add_filter( 'acf/load_value/name=pip_container', array( $this, 'tw_container' ), 20, 1 );
            add_filter( 'acf/load_value/name=pip_tailwind_style_components', array( $this, 'tw_style_components' ), 20, 1 );

            $has_tailwind_pre_config = get_option( 'pipaddon_tailwind_pre_config' );
            if ( $has_tailwind_pre_config === '1' ) {
                return;
            }

            update_option( 'pipaddon_tailwind_pre_config', '1' );

            // Default override colors
            update_field( 'override_colors', '1', 'pip_styles_configuration' );

            // TailwindCSS - CSS - Base import
            update_field( 'add_base_import', '1', 'pip_styles_configuration' );

            // TailwindCSS - CSS - Utilities import
            update_field( 'add_utilities_import', '1', 'pip_styles_configuration' );

        }

        // Body Classes
        public function tw_body_class( $value ) {
            if ( $value ) {
                return $value;
            }

            $default_body_classes = 'text-base text-black font-primary antialiased overflow-x-hidden';
            return $default_body_classes;
        }

        // Typography
        public function tw_typography( $value ) {

            // If value has been modified, return
            if ( $value ) {
                $first_text_style_row     = reset( $value );
                $first_text_style_classes = acf_maybe_get( $first_text_style_row, 'field_typography_classes', '' );
                if ( $first_text_style_classes ) {
                    return $value;
                }
            }

            // Add default values
            $new_values = array();
            for ( $i = 1; $i <= 6; $i++ ) {
                $new_values[] = array(
                    'field_typography_label'            => __( 'Titre', 'pilopress' ) . ' ' . $i,
                    'field_typography_class_name'       => 'h' . $i,
                    'field_typography_classes_to_apply' => '',
                );
            }

            // Set default heading values
            $new_values[0]['field_typography_classes'] = 'font-primary leading-tight font-semibold text-black text-4xl';
            $new_values[1]['field_typography_classes'] = 'font-primary leading-tight font-semibold text-black text-2xl';
            $new_values[2]['field_typography_classes'] = 'font-primary leading-tight font-semibold text-black text-xl';
            $new_values[3]['field_typography_classes'] = 'font-primary leading-tight font-semibold text-black text-xl';
            $new_values[4]['field_typography_classes'] = 'font-primary leading-tight font-semibold text-black text-lg';
            $new_values[5]['field_typography_classes'] = 'font-primary leading-tight font-semibold text-black text-base';

            // Return default values
            return $new_values;
        }

        // Colors - Simple
        public function tw_simple_colors( $value ) {

            // If value has been modified, return
            if ( $value ) {
                $first_simple_color_row   = reset( $value );
                $first_simple_color_value = acf_maybe_get( $first_simple_color_row, 'field_simple_color_value', '' );
                if ( $first_simple_color_value ) {
                    return $value;
                }
            }

            // Add default values
            $new_values = array(
                array(
                    'field_simple_color_label'         => 'Transparente',
                    'field_simple_color_name'          => 'transparent',
                    'field_simple_color_value'         => 'transparent',
                    'field_simple_color_add_to_editor' => '',
                ),
                array(
                    'field_simple_color_label'         => 'Actuelle',
                    'field_simple_color_name'          => 'current',
                    'field_simple_color_value'         => 'currentColor',
                    'field_simple_color_add_to_editor' => '',
                ),
                array(
                    'field_simple_color_label'         => 'Noire',
                    'field_simple_color_name'          => 'black',
                    'field_simple_color_value'         => '#2E2B28',
                    'field_simple_color_add_to_editor' => '1',
                ),
                array(
                    'field_simple_color_label'         => 'Blanche',
                    'field_simple_color_name'          => 'white',
                    'field_simple_color_value'         => '#ffffff',
                    'field_simple_color_add_to_editor' => '1',
                ),
            );

            // Return default values
            return $new_values;
        }

        // Colors - Variants
        public function tw_color_variants( $value ) {

            // If value has been modified, return value
            if ( $value ) {
                $first_color_variant_row = reset( $value );
                if ( !empty( $first_color_variant_row ) ) {
                    $first_color_variant_shades = acf_maybe_get( $first_color_variant_row, 'field_colors_shades_shades', array() );
                    if ( !empty( $first_color_variant_shades ) ) {
                        $first_shade       = reset( $first_color_variant_shades );
                        $first_shade_value = acf_maybe_get( $first_shade, 'field_shade_value', '' );
                        if ( $first_shade_value ) {
                            return $value;
                        }
                    }
                }
            }

            // Add default values
            $new_values = array(
                array(
                    'field_colors_shades_color_name' => 'gray',
                    'field_colors_shades_shades'     => array(
                        array(
                            'field_shade_label'         => 'Gris',
                            'field_shade_name'          => 'DEFAULT',
                            'field_shade_value'         => '#71717A',
                            'field_shade_add_to_editor' => '',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 100',
                            'field_shade_name'          => '100',
                            'field_shade_value'         => '#F4F4F5',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 200',
                            'field_shade_name'          => '200',
                            'field_shade_value'         => '#E4E4E7',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 300',
                            'field_shade_name'          => '300',
                            'field_shade_value'         => '#D4D4D8',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 400',
                            'field_shade_name'          => '400',
                            'field_shade_value'         => '#A1A1AA',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 500',
                            'field_shade_name'          => '500',
                            'field_shade_value'         => '#71717A',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 600',
                            'field_shade_name'          => '600',
                            'field_shade_value'         => '#52525B',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 700',
                            'field_shade_name'          => '700',
                            'field_shade_value'         => '#3F3F46',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 800',
                            'field_shade_name'          => '800',
                            'field_shade_value'         => '#27272A',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Gris 900',
                            'field_shade_name'          => '900',
                            'field_shade_value'         => '#18181B',
                            'field_shade_add_to_editor' => '1',
                        ),
                    ),
                ),
                array(
                    'field_colors_shades_color_name' => 'primary',
                    'field_colors_shades_shades'     => array(
                        array(
                            'field_shade_label'         => 'Primaire',
                            'field_shade_name'          => 'DEFAULT',
                            'field_shade_value'         => '#1f2932',
                            'field_shade_add_to_editor' => '',
                        ),
                        array(
                            'field_shade_label'         => 'Primaire 300',
                            'field_shade_name'          => '300',
                            'field_shade_value'         => '#1f2932',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Primaire 500',
                            'field_shade_name'          => '500',
                            'field_shade_value'         => '#1f2932',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Primaire 700',
                            'field_shade_name'          => '700',
                            'field_shade_value'         => '#1f2932',
                            'field_shade_add_to_editor' => '1',
                        ),
                    ),
                ),
                array(
                    'field_colors_shades_color_name' => 'secondary',
                    'field_colors_shades_shades'     => array(
                        array(
                            'field_shade_label'         => 'Secondaire',
                            'field_shade_name'          => 'DEFAULT',
                            'field_shade_value'         => '#30b3df',
                            'field_shade_add_to_editor' => '',
                        ),
                        array(
                            'field_shade_label'         => 'Secondaire 300',
                            'field_shade_name'          => '300',
                            'field_shade_value'         => '#30b3df',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Secondaire 500',
                            'field_shade_name'          => '500',
                            'field_shade_value'         => '#30b3df',
                            'field_shade_add_to_editor' => '1',
                        ),
                        array(
                            'field_shade_label'         => 'Secondaire 700',
                            'field_shade_name'          => '700',
                            'field_shade_value'         => '#30b3df',
                            'field_shade_add_to_editor' => '1',
                        ),
                    ),
                ),
            );

            // Return default values
            return $new_values;
        }

        // Buttons
        public function tw_buttons( $value ) {

            // If value has been modified, return
            if ( $value ) {
                $first_button_row     = reset( $value );
                $first_button_classes = acf_maybe_get( $first_button_row, 'field_custom_button_classes', '' );
                if ( $first_button_classes ) {
                    return $value;
                }
            }

            // Add default values
            $new_values = array(
                array(
                    'field_custom_button_label'         => 'Bouton principal',
                    'field_custom_button_class'         => 'btn-primary',
                    'field_custom_button_classes'       => 'relative transition-all duration-300 inline-flex items-center justify-center text-sm text-white uppercase px-4 py-2 leading-none font-primary font-bold bg-primary border-2 border-solid border-primary mr-2 mb-2',
                    'field_custom_button_add_to_editor' => '1',
                    'field_custom_button_states'        => array(
                        array(
                            'field_state_type'             => 'hover',
                            'field_state_classes_to_apply' => 'bg-primary-700 border-primary-700',
                        ),
                        array(
                            'field_state_type'             => 'active',
                            'field_state_classes_to_apply' => 'bg-primary-700 border-primary-700',
                        ),
                    ),
                ),
                array(
                    'field_custom_button_label'         => 'Bouton secondaire',
                    'field_custom_button_class'         => 'btn-secondary',
                    'field_custom_button_classes'       => 'relative transition-all duration-300 inline-flex items-center justify-center text-sm text-white uppercase px-4 py-2 leading-none font-secondary font-bold bg-secondary border-2 border-solid border-secondary mr-2 mb-2',
                    'field_custom_button_add_to_editor' => '1',
                    'field_custom_button_states'        => array(
                        array(
                            'field_state_type'             => 'hover',
                            'field_state_classes_to_apply' => 'bg-secondary-700 border-secondary-700',
                        ),
                        array(
                            'field_state_type'             => 'active',
                            'field_state_classes_to_apply' => 'bg-secondary-700 border-secondary-700',
                        ),

                    ),

                ),
            );

            // Return default values
            return $new_values;
        }

        // Container
        public function tw_container( $value ) {

            // If value has been modified, return
            if ( $value ) {
                $first_container_row          = reset( $value );
                $first_container_padding_rows = acf_maybe_get( $first_container_row, 'field_container_padding_values', '' );
                if ( $first_container_padding_rows ) {
                    return $value;
                }
            }

            // Add default values
            $new_values = array(
                'field_container_center'            => '1',
                'field_container_add_padding_value' => '1',
                'field_container_padding_values'    => array(
                    array(
                        'field_container_padding_breakpoint' => 'DEFAULT',
                        'field_container_padding_value' => '2rem',
                    ),
                    array(
                        'field_container_padding_breakpoint' => 'lg',
                        'field_container_padding_value' => '0',
                    ),
                ),
            );

            // Return default values
            return $new_values;
        }

        // TailwindCSS - CSS - Components import
        public function tw_style_components( $value ) {

            // If value has been modified, return
            if ( $value ) {
                $first_style_components_row = reset( $value );
                $first_style_components_url = acf_maybe_get( $first_style_components_row, 'field_tailwind_style_after_components', '' );
                if ( $first_style_components_url ) {
                    return $value;
                }
            }

            // Add default values
            $new_values = array(
                'field_add_components_import'           => '1',
                'field_tailwind_style_after_components' => '
body {
max-width: 100vw;
}

button:focus {
outline: none;
}

ul {
@apply list-disc list-inside;
}

ol {
@apply list-decimal list-inside;
}

ul[class],
ol[class] {
@apply list-none;
}

/** Images */
picture {
@apply block align-middle;

& > img {
    all: inherit;
}

/** Fix when img are replaced with picture */
&:not([class*="wp-image"]) > img {
    @apply w-full h-full object-cover;
}
}

/** Headings */
h1 {
@apply h1;

/* Desktop size */
@screen lg {
    @apply text-5xl;
}
}

.h1 {
/* Desktop size */
@screen lg {
    @apply text-5xl;
}
}

h2 {
@apply h2;

/* Desktop size */
@screen lg {
    @apply text-3xl;
}
}

.h2 {
/* Desktop size */
@screen lg {
    @apply text-3xl;
}
}

h3 {
@apply h3;

/* Desktop size */
@screen lg {
    @apply text-2xl;
}
}

.h3 {
/* Desktop size */
@screen lg {
    @apply text-2xl;
}
}

h4 {
@apply h4;
}

h5 {
@apply h5;
}

h6 {
@apply h6;
}

/* Inputs */
input[type="email"],
input[type="password"],
input[type="text"],
input[type="tel"],
input[type="number"],
select,
textarea,
.select2 > .selection > .select2-selection {
@apply h-auto text-sm border-2 border-gray-500 rounded p-3 !important;
}

/* Select2 - Fix margin */
.select2 > .selection > .select2-selection {
@apply m-0 !important;
}

/* Select2 - Fix arrow position */
.select2 > .selection > .select2-selection > .select2-selection__arrow {
top: 50%;
right: 1%;
transform: translateY(-50%);
}

/* Select2 - Fix clear icon position */
.select2 > .selection .select2-selection__clear {
@apply px-2 py-0 !important;
margin-right: calc(1% + 1em) !important;
}

/* Select2 - Fix select style */
.select2 > .selection > .select2-selection > .select2-selection__rendered {
@apply p-0 !important;
line-height: inherit !important;
}

/** Select2 - Dropdown - Option selected - Hover */
.select2-results > .select2-results__options > .select2-results__option--highlighted[aria-selected],
.select2-results > .select2-results__options > .select2-results__option--highlighted[data-selected] {
/* @apply bg-secondary !important; */
}

/** WYSIWYG alignment styles */
.aligncenter {
@apply mx-auto;
}

.alignleft {
@apply mr-auto;
}

.alignright {
@apply ml-auto;
}

/* Pagination */
.pagination {
@apply flex items-center justify-center text-black w-full pt-6 border-t border-gray-500;

.page-numbers {
    @apply px-1 mr-1;
}

/* Hover, current */
.page-numbers.current,
.prev:hover,
.next:hover {
    @apply text-primary;
}
}

/**
* Button basic styling
* (extend it to create your buttons)
*/
.btn-base {
@apply relative inline-flex items-center justify-center text-sm text-black uppercase;
@apply px-4 py-2 leading-none font-primary font-bold bg-gray-300 border-2 border-solid border-gray-300 mr-2 mb-2;

&:hover {
    @apply bg-gray-700 border-gray-700;
}
}

/** Icon Font Awesome - Left position */
.icon-left {
&::before {
    content: "";
    display: inline-block;
    font-family: "Font Awesome 5 Pro";
    font-weight: 400;
    color: currentcolor;
    margin-right: 12px;
    text-align: center;
}
}

/** Icon Font Awesome - Right position */
.icon-right {
&::after {
    content: "";
    display: inline-block;
    font-family: "Font Awesome 5 Pro";
    font-weight: 400;
    color: currentcolor;
    margin-left: 12px;
    text-align: center;
}
}

/** ----------------------------------
* Put your custom styles here below...
* ---------------------------------- */

',
            );

            // Return default values
            return $new_values;
        }

    }

    // Instantiate
    new PIP_Addon_Tailwind();
}
