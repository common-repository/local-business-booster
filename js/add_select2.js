(function($) {
    $(document).ready(function() {
        $('select').each(function() {
            if(!$(this).hasClass('no-select-2')){
                $(this).select2();
            }
        });
    });
})( jQuery );

