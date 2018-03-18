$(function() {
    $("button[name = 'activateUser']").click(function(){
        console.log(Routing.generate('admin.user.activate'));
        var idUser = $(this).attr('data-id');
        $.ajax({
            url : '/fr/admin/user/activate',
            type : "POST",
            data: { id : idUser },
            dataType: "html",
            success : function( data ) {
                console.log("succes");
                console.log(data);
            },
            error : function() {
                console.log("erreur");
            }
        });
        // $.post( Routing.generate('admin.user.activate'), function( data ) {
        //     $("button[name = 'activateUser']").html( 'oui' );
        //     console.log("succes");
        // });
        // $.post( "/fr/admin/user/activate", { id: 1 }, function( data ) {
        //     console.log( data );
        // }, "json");

    });
    $("button[name = 'desactivateUser']").click(function(){
        console.log('desactiver');
    });
});