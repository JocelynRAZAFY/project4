$(document).on('click','.btn-remove-collection',function (e) {
    e.preventDefault();
    deleteCollection($(this).attr('id'));
});

function deleteCollection(id)
{
    var data = {
        'id': id,
    };
    $( "#dialogCollection" ).removeClass('hidden');

    var info = $('tr#line-'+id+' > td:nth-child(1)').html();

    $('#infoCollection').html(info);

    $( "#dialogCollection" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Supprimer": function() {
                $.ajax({
                    type: "POST",
                    url: Routing.generate('delete_collection'),
                    data: JSON.stringify(data),
                    success: function (result) {
                        if (result.data.id) {
                            $('tr#line-'+result.data.id).remove();
                        }
                    }
                });
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
}