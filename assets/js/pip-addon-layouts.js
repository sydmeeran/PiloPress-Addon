(function ($) {

    // Prevent accidently clicking in a layout link on preview mode
    $(document).on('click', '.-preview a', function (event) {
        event.preventDefault();
    });

})(jQuery);
