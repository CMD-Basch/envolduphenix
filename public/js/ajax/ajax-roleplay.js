$(document).ready( function() {

    function bindAjaxRoleplay () {
        $('[data-ajax-button="true"]').off().on('click', function (event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('href'),
                type: "POST",
                async: true,
                success: function (data) {
                    console.log(data);
                    $( '#roleplay-wrapper' ).replaceWith( $(data).find('#roleplay-wrapper') );
                    bindAjaxRoleplay();
                }
            });
            return false;
        });
    }

    bindAjaxRoleplay();

});