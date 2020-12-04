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

                var $forms = $preview_window.find('form');
                if ($forms.length) {

                    // forms found
                    $forms.each(function(index) {
                        var $form = $(this);
                        $form.replaceWith('<div class="' + $form.attr('class') + '">' + $form.html() + '</div>');
                    });
                    // forms replaced

                 }

                var $inputs = $preview_window.find('input, textarea, button[type="submit"]');
                if ($inputs.length) {

                    // inputs found
                    $inputs.each(function(index) {
                        var $input = $(this);
                        $input.replaceWith('<div class="' + $input.attr('class') + '">' + $input.html() + '</div>');
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
