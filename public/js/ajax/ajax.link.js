$(document).ready( function() {

    function bindAjaxLink () {
        $('.ajax-link').off().on('click', function (event) {
            event.preventDefault();
            let link_id = $(this).data('id');
            let act = $(this).data('act');
            console.log(link_id);
            $.ajax({
                url: "/ajax/link/" + act + "/" + link_id,
                type: "POST",
                async: true,
                success: function (data) {
                    console.log(data);
                    $( '#link-' + link_id ).replaceWith( data );
                    bindAjaxLink();
                }
            });
            return false;
        });
    }

    bindAjaxLink();

});