
var tagsNames = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('label'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: '/tags.json'
});
tagsNames.initialize();

$('#article_tags').tagsinput({
    typeaheadjs: [
        {highlight: true},
        {
            name: 'tagsNames',
            displayKey: 'label',
            valueKey: 'label',
            source: tagsNames.ttAdapter()
        }
    ]
});

$(document).on('click','.btn-remove-article',function (e) {
   e.preventDefault();
    deleteArticle($(this).attr('id'))
});

function deleteArticle(id)
{
    var data = {
        'id': id,
    };
    $( "#dialogArticle" ).removeClass('hidden');

    var info = $('tr#line-'+id+' > td:nth-child(1)').html();

    $('#infoArticle').html(info);

    $( "#dialogArticle" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Supprimer": function() {
                $.ajax({
                    type: "POST",
                    url: Routing.generate('delete_article'),
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