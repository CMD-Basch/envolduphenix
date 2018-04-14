$(document).ready( function() {

    function bindBtnTable () {
        $('.btn-table').off().on('click', function (event) {
            event.preventDefault();
            let table_id = $(this).data('table-id');
            let act = $(this).data('act');
            console.log(table_id);
            $.ajax({
                url: "/jeu-de-roles/ajax/" + act + "/" + table_id,
                type: "POST",
                async: true,
                success: function (data) {
                    console.log(data);
                    $('#table-list').html(data);
                    bindBtnTable();
                }
            });
            return false;
        });
    }

    bindBtnTable();

});