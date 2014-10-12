$(function() {
    $('#contacts').find('a').click(function() {
        var id = $(this).attr('data-contact-id')
        window.session.call('popup/open', {
            id: id
        }).then(function(result) {
            if($('#contact-'+id+'-popup').length) {
                $(this).show();
            }
            else {
                $('body').append(result);
            }
        }, function(error, desc) {
            console.log("RPC Error", error, desc);
        });
    });
});