$(document).ready( function() {

    const $carousel = $('#carousel');

    $carousel.slick({
        adaptiveHeight: true,
        autoplay: true,
        cssEase: 'linear',
        speed: 20000,
        autoplaySpeed: 0,
        arrows: false,
        pauseOnHover: false,
        pauseOnFocus: false,
        slidesToShow: 3
    });

    const   $global = $('#global'),
            round_id = $global.data('round-id')
    ;

    // console.log($global, round_id);

    function refreshRounds() {
        $.ajax({
            url: '/advert/ajax/'+round_id,
            type: "POST",
            data:{},
            async: true,
            success: function (data) {
                // console.log(data);

                if( data.status !== 'ok') return;

                for( let key in data.blocks ) {
                    let block =  data.blocks[ key ];
                    $find = $( '#activity-' + block.id );
                    if( $find.length > 0 ) {
                        $find.html( block.html );
                    } else {
                        $carousel.slick('slickAdd',
                            '<div id="activity-' + block.id + '" class="ml-3">'
                            +   block.html
                            +   '</div>'
                        );
                    }
                }

                $('#nbr-activities').html( data.total );


            }
        }).always( function () {
            setTimeout(function() {
                refreshRounds();
            }, 5000);
        });
    }

    setTimeout(function() {
        refreshRounds();
    }, 5000);

    // $("#btn-refresh").on('click', function () {
    //     refreshRounds();
    // });

});
