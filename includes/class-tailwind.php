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
            add_filter( 'acf/load_field/name=tailwind_config', array( $this, 'pip_tailwind_config_default' ), 20 );
            add_filter( 'acf/load_field/name=tailwind_style', array( $this, 'pip_tailwind_style_default' ), 20 );
        }

        /**
         *  Change tailwind config default value
         *
         * @param $field
         *
         * @return mixed
         */
        public function pip_tailwind_config_default( $field ) {

            ob_start(); ?>
            const { colors, fontFamily } = require('tailwindcss/defaultTheme')
            const plugin = require('tailwindcss/plugin')
            const selectorParser = require("postcss-selector-parser")

            module.exports = {
            'theme': {
            'colors': {
            'transparent': 'transparent',
            'current': 'currentColor',
            'black': '#2E2B28',
            'white': '#FFFFFF',
            'gray': {
            ...colors.gray,
            'default': "#A0AEC0",
            },
            'primary': '#575756',
            'primary-500': '#575756',
            'secondary': '#E2101B',
            'secondary-500': '#E2101B',
            },
            'fontFamily': {
            'primary': ['NomDeLaFont', ...fontFamily.sans],
            'secondary': ['NomDeLaFont', ...fontFamily.serif],
            },
            'inset': {
            '0': 0,
            auto: 'auto',
            '1/2': '50%',
            'full': '100%',
            },
            'container': {
            'center': 'true',
            'padding': {
            default: '2rem',
            'lg': 0,
            },
            },
            'namedGroups': ["1", "2"],
            'extend': {
            'spacing': {
            '75': '18.75rem',
            '84': '21rem',
            '88': '22rem',
            '96': '24rem',
            '100': '25rem',
            '112': '28rem',
            '120': '30rem',
            '124': '31rem',
            '136': '34rem',
            '138': '34.5rem',
            '140': '35rem',
            '150': '37.5rem',
            '152': '38rem',
            '162': '40.5rem',
            '176': '44rem',
            '186': '46.5rem',
            '192': '48rem',
            '200': '50rem',
            },
            }
            },
            'variants': {
            'backgroundColor': ['hover', 'focus', 'active', 'group-hover'],
            'textColor': ['hover', 'focus', 'active', 'group-hover'],
            'display': ['responsive', 'hover', 'group-hover'],
            'opacity': ['responsive', 'hover', 'focus', 'active', 'group-hover'],
            },
            'plugins': [

            /** "Tailwind Named Groups" plugin */
            plugin(({ theme, addVariant, prefix, e }) => {
            const namedGroups = theme("namedGroups") || [];

            addVariant(`group-hover`, ({ modifySelectors, separator }) => {
            return modifySelectors(({ selector }) => {
            return selectorParser((root) => {
            root.walkClasses((node) => {
            // Regular group
            const value = node.value;
            node.value = `group-hover${separator}${value}`;

            node.parent.insertBefore(
            node,
            selectorParser().astSync(prefix(`.group:hover `))
            );

            // Named groups
            namedGroups.forEach((namedGroup) => {
            node.parent.parent.insertAfter(
            node.parent,
            selectorParser().astSync(
            prefix(`.group-${namedGroup}:hover .`) +
            e(`group-${namedGroup}-hover${separator}${value}`)
            )
            );
            });
            });
            }).processSync(selector);
            });
            });

            addVariant(`group-focus`, ({ modifySelectors, separator }) => {
            return modifySelectors(({ selector }) => {
            return selectorParser((root) => {
            root.walkClasses((node) => {
            // Regular group
            const value = node.value;
            node.value = `group-focus${separator}${value}`;

            node.parent.insertBefore(
            node,
            selectorParser().astSync(prefix(`.group:focus `))
            );

            // Named groups
            namedGroups.forEach((namedGroup) => {
            node.parent.parent.insertAfter(
            node.parent,
            selectorParser().astSync(
            prefix(`.group-${namedGroup}:focus .`) +
            e(`group-${namedGroup}-focus${separator}${value}`)
            )
            );
            });
            });
            }).processSync(selector);
            });
            });
            })

            ],
            };
            <?php
            $field['default_value'] = ob_get_clean();

            return $field;

        }

        /**
         *  Change tailwind style default value
         *
         * @param $field
         *
         * @return mixed
         */
        public function pip_tailwind_style_default( $field ) {

            ob_start(); ?>
            @tailwind base;
            @tailwind components;

            body {
            @apply text-base text-black font-primary antialiased overflow-x-hidden;
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
            h1,
            .h1 {
            @apply font-primary leading-tight uppercase font-semibold text-black text-4xl;

            /* Desktop size */
            @screen lg {
            @apply text-5xl;
            }
            }

            h2,
            .h2 {
            @apply font-primary leading-tight uppercase font-semibold text-black text-2xl;

            /* Desktop size */
            @screen lg {
            @apply text-3xl;
            }
            }

            h3,
            .h3 {
            @apply font-primary leading-tight uppercase font-semibold text-black text-xl;

            /* Desktop size */
            @screen lg {
            @apply text-2xl;
            }
            }

            h4,
            .h4 {
            @apply font-primary leading-tight font-semibold text-black text-xl;
            }

            h5,
            .h5 {
            @apply font-primary leading-tight font-semibold text-black text-lg;
            }

            h6,
            .h6 {
            @apply font-primary leading-tight font-semibold text-black text-base;
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
            @apply bg-secondary !important;
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
            @apply flex items-center justify-center text-black w-full pt-6 border-t border-gray;

            .page-numbers {
            @apply px-1 mr-1;
            }

            /* Hover, current */
            .page-numbers.current, .prev:hover, .next:hover {
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
            content: '';
            display: inline-block;
            font-family: 'Font Awesome 5 Pro';
            font-weight: 400;
            color: currentcolor;
            margin-right: 12px;
            text-align: center;
            }
            }

            /** Icon Font Awesome - Right position */
            .icon-right {
            &::after {
            content: '';
            display: inline-block;
            font-family: 'Font Awesome 5 Pro';
            font-weight: 400;
            color: currentcolor;
            margin-left: 12px;
            text-align: center;
            }
            }

            /** ----------------------------------
            * Put your custom styles here below...
            * ---------------------------------- */

            /** Button - primary */
            .btn-primary {
            @apply btn-base text-white bg-primary border-primary;

            &:hover, &.active {
            @apply bg-secondary border-secondary;
            }
            }

            @tailwind utilities;
            <?php
            $field['default_value'] = ob_get_clean();

            return $field;

        }

    }

    // Instantiate
    new PIP_Addon_Tailwind();
}
