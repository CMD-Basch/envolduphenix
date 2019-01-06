$(document).ready( function() {

    function bindAjaxRoleplay () {
        $('[data-ajax-button="true"]').off().on('click', function (event) {
            event.preventDefault();
            const type = $( '#list-wrapper' ).data('type');
            $.ajax({
                url: $(this).attr('href'),
                type: "POST",
                data:{ type:type },
                async: true,
                success: function (data) {
                    console.log(data);
                    $( '#list-wrapper' ).replaceWith( $(data).find('#list-wrapper') );
                    bindAjaxRoleplay();
                }
            });
            return false;
        });
    }

    bindAjaxRoleplay();

});