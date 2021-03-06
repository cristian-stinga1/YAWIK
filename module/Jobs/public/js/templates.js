/**
 * Created by weitz on 09.02.15.
 */

;(function ($){
    $(function() {

        $('#template-links a').click(
            function (e) {
                $('#template-links a').hide();
                $('#template-links-loading').show();
                e.preventDefault();
                var href = $(e.currentTarget).prop('href');
                $.get(href, function(data){
                    $(document).trigger('ajax.ready', {'data': data});
                    // hackishly force iframe to reload
                    var iframe = $('iframe');
                    iframe.prop('src', iframe.prop('src'));
                    $('#template-links a').show();
                    $('#template-links-loading').hide();
                });
                return false;
            }
        );
    });
})(jQuery)
