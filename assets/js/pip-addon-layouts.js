// Prevent accidently clicking in a layout link on preview mode
(function($) {
    $(document).on('click', '.-preview a', function (event) {
        event.preventDefault();
    });
})(jQuery);

// Replace form & input by div element to avoid broken content edition
(function($) {

    function pip_replace_form_and_inputs_from_preview() {
        $(function() {
            var $previews_window = $('.-preview');
            if (!$previews_window.length) { return; }

            // previews found
            $previews_window.each(function(index) {

                var $preview_window = $(this);

                var $forms = $preview_window.find('form, textarea, button[type="submit"]');
                if ($forms.length) {

                    // forms found
                    $forms.each(function(index) {
                        var $form = $(this);
                        $form.replaceWith('<div class="' + $form.attr('class') + '">' + $form.html() + '</div>');
                    });
                    // forms replaced

                 }

                 var $inputs_hidden = $preview_window.find('input[type="hidden"]');
                 if ($inputs_hidden.length) {

                    // inputs hidden found
                    $inputs_hidden.each(function(index) {
                        var $input = $(this);
                        $input.remove();
                    });
                    // input hidden deleted

                }

                var $inputs_submit = $preview_window.find('input[type="submit"]');
                if ($inputs_submit.length) {

                    // inputs submit found
                    $inputs_submit.each(function(index) {
                        var $input = $(this);
                        $input.replaceWith('<div class="' + $input.attr('class') + '">' + $input.val() + '</div>');
                    });
                    // input submit replaced

                }

                var $inputs = $preview_window.find('input:not([type="hidden"])');
                if ($inputs.length) {

                    // inputs found
                    $inputs.each(function(index) {
                        var $input = $(this);
                        $input.replaceWith('<div class="' + $input.attr('class') + ' bg-white p-4 inline-flex justify-center">' + $input.attr('placeholder') + '</div>');
                    });
                    // input replaced

                }

                var $selects = $preview_window.find('select[name]');
                if ($selects.length) {

                    // selects found
                    $selects.each(function(index) {
                        var $select = $(this);
                        $select.removeAttr('name').removeAttr('required').removeAttr('id');
                    });
                    // selects replaced

                }

            });

        });
    }

    // Apply fix on first load
    pip_replace_form_and_inputs_from_preview();

    // Apply fix again when preview is refreshed
    if (typeof acf === 'undefined') { return; }
    acf.addAction('acfe/fields/flexible_content/preview', function() {
        setTimeout(pip_replace_form_and_inputs_from_preview, 450);
    });

})(jQuery);


// Shortcodes (Icon - Font Awesome)
(function($) {

    // Check if "acf" is available
    if ( typeof acf === 'undefined' ) {
        return
    }

    /**
     * Get attribute from shortcode text
     *
     * @param str
     *
     * @param name
     * @returns {string}
     */
    var getAttr = function ( str, name ) {
        name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str )
        return name ? window.decodeURIComponent( name[1] ) : ''
    }

    /**
     * Build shortcode
     *
     * @param event
     *
     * @param attributes
     * @returns {string}
     */
    var build_shortcode = function ( event, attributes ) {
        // Open shortcode
        var out = '[' + attributes.tag

        // Add attributes to shortcode
        $.each(
            event.data,
            function ( key, value ) {
                if ( value === false ) {
                    value = ''
                }
                out += ' ' + key + '="' + value + '"'
            }
        )

        // Close shortcode
        out += ']'

        return out
    }

    // Wait for TinyMCE to be ready
    $( document ).on(
        'tinymce-editor-setup',
        function ( event, editor ) {

            // Add "Icon - Font Awesome" to PIP shortcodes menu
            acf.addFilter(
                'pip/tinymce/shortcodes',
                function( shortcodes, event, editor ) {

                    if (!shortcodes) {
                        return shortcodes;
                    }

                    var shortcode_is_already_added = false;
                    $.each(shortcodes, function(key, shortcode) {
                        if (shortcode.tag === 'pip_icon_fa') {
                            shortcode_is_already_added = true;
                            return true;
                        }
                    });

                    if (shortcode_is_already_added) {
                        return shortcodes;
                    }

                    // Icon - Font Awesome shortcode
                    var pip_icon_fa = {
                        text: 'Icon - Font Awesome',
                        tag: 'pip_icon_fa',
                        name: 'Add icon',
                        body: [
                            {
                                label: 'Style',
                                name: 's',
                                type: 'listbox',
                                values: [
                                    { text: 'Solid', value: 'fas' },
                                    { text: 'Regular', value: 'far' },
                                    { text: 'Light', value: 'fal' },
                                    { text: 'Duotone', value: 'fad' },
                                    { text: 'Brands', value: 'fab' },
                                ],
                            },
                            {
                                label: 'Icons',
                                name: 'i',
                                type: 'textbox',
                                value: 'fa-paper-plane',
                            },
                            {
                                label: 'Utilities class',
                                name: 'u',
                                type: 'textbox',
                                value: 'fa-2x',
                            },
                            {
                                label: 'Link url (clickable icon)',
                                name: 'l',
                                type: 'textbox',
                                value: '',
                            },
                        ],
                        onclick: function ( event ) {
                            var attributes = event.control.settings

                            // If no tag, return
                            if ( _.isUndefined( attributes.tag ) ) {
                                return
                            }

                            // Get attributes
                            var window_title = !_.isUndefined( attributes.name ) ? attributes.name : 'Add icon'

                            // Modal
                            editor.windowManager.open(
                                {
                                    title: window_title,
                                    body: attributes.body,
                                    onsubmit: function ( event ) {
                                        editor.insertContent( build_shortcode( event, attributes ) );
                                    },
                                }
                            )
                        },
                    }

                    // Register spacer view
                    window.wp.mce.views.register(
                        'pip_icon_fa',
                        {
                            initialize: function () {

                                // Get icon attrs
                                var style = getAttr( this.text, 's' )
                                var icon = getAttr( this.text, 'i' )
                                var utility = getAttr( this.text, 'u' )
                                var link = getAttr( this.text, 'l' )

                                // Render button
                                var render_html = '<em><<strong>Icon</strong> "' + icon + '"></em>';

                                this.render( render_html );
                            },

                            edit: function ( text, update ) {

                                // Get current icon from shortcode text
                                var style = getAttr( this.text, 's' )
                                var icon = getAttr( this.text, 'i' )
                                var utility = getAttr( this.text, 'u' )
                                var link = getAttr( this.text, 'l' )

                                // Update value
                                $.each(
                                    pip_icon_fa.body,
                                    function ( key, item ) {

                                        if (item.name == 's') {
                                            item.value = style;
                                        }

                                        if (item.name == 'i') {
                                            item.value = icon;
                                        }

                                        if (item.name == 'u') {
                                            item.value = utility;
                                        }

                                        if (item.name == 'l') {
                                            item.value = link;
                                        }

                                    }
                                )

                                // Modal
                                editor.windowManager.open(
                                    {
                                        title: 'Edit icon',
                                        body: pip_icon_fa.body,
                                        onsubmit: function ( event ) {
                                            update( build_shortcode( event, pip_icon_fa ) )
                                        },
                                    }
                                )
                            },

                        }
                    );

                    shortcodes.push(pip_icon_fa);

                    return shortcodes;
                }
            );

        }
    );

})(jQuery);
