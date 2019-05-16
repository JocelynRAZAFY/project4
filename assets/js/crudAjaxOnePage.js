$(document).on('click','.btn-save',function (e) {
    e.preventDefault();

    if(!$('#lastName').val()){
        messageAlert('Le champ nom est obligatoire');
        return false;
    }
    if(!$('#firstName').val()){
        messageAlert('Le champ prénom est obligatoire');
        return false;
    }
    if(!$('#birthDate').val()){
        messageAlert('Le champ date est obligatoire');
        return false;
    }
    if(!$('#region').val()){
        messageAlert('Sélectionner une région');
        return false;
    }
    if(!$('#departement').val()){
        messageAlert('Sélectionner un département');
        return false;
    }
    if(!$('#ville').val()){
        messageAlert('Sélectionner une ville');
        return false;
    }

    var data = {
        id: $('#idContact').val(),
        lastName: $('#lastName').val(),
        firstName: $('#firstName').val(),
        birthDate: $('#birthDate').val(),
        ville: $('#ville').val(),
    }

    $.ajax({
        type: "POST",
        url: Routing.generate('crud_one_page_update'),
        data: JSON.stringify(data),
        success: function (data)
        {
            if(data.data.type != 'add'){
                $('tr#line-'+data.data.id+' > td:nth-child(1)').html(data.data.lastName);
                $('tr#line-'+data.data.id+' > td:nth-child(2)').html(data.data.firstName);
                $('tr#line-'+data.data.id+' > td:nth-child(3)').html(data.data.birthDate);
                $('tr#line-'+data.data.id+' > td:nth-child(4)').html(data.data.ville);
            }else{
                var markup = "<tr id='line-"+data.data.id+"' role='row'>"+
                    "<td>"+data.data.lastName+"</td>"+
                    "<td>"+data.data.firstName+"</td>"+
                    "<td>"+data.data.birthDate+"</td>"+
                    "<td>"+data.data.ville+"</td>"+
                    "<td> <button type='button' class='btn btn-default btn-edit' id='"+data.data.id+"'>"+
                    "<i class='fa fa-edit'></i> </button>"+
                    "<button type='button' class='btn btn-default btn-remove' id='"+data.data.id+"'>" +
                    "<i class='fa fa-remove'></i> </button> </td></tr>";

                $("table#example1 tbody").prepend(markup);
            }
        }
    });

});

$(document).on('change','#region', function (e) {
    removeAllOptionsExceptFirst('departement');
    var data = {
        type: 'departement',
        code_region: $(this).val()
    };
    getRegionDepartementVille('departement',data);
});

$(document).on('change','#departement', function (e) {
    removeAllOptionsExceptFirst('ville');
    var data = {
        type: 'ville',
        code_region: $('#region').val(),
        numero_departement: $(this).val()
    };
    getRegionDepartementVille('ville',data);
});

$(document).on('bind','#example1 tr',function (e) {
    $(e.currentTarget).children('td, th').css('background-color','#527BC0');
});

$(document).on('click','.btn-edit',function (e) {
    e.preventDefault();
    var data = {
        idContact: $(this).attr('id')
    };

    $('.btn-save').html('Modifier la ligne');
    $.ajax({
        type: "POST",
        url: Routing.generate('crud_one_page_detail'),
        data: JSON.stringify(data),
        success: function (data)
        {
            $('#idContact').val(data.data.id);
            $('#lastName').val(data.data.lastName);
            $('#firstName').val(data.data.firstName);
            $('#birthDate').val(data.data.birthDate);

            $.each(data.data.region, function (i, item) {
                $('#region').append($('<option>', {
                    value: item.code_region,
                    text : item.nom_region
                }));
            });
            $('#region').val(data.data.selectedRegion);

            $.each(data.data.departement, function (i, item) {
                $('#departement').append($('<option>', {
                    value: item.numero_departement,
                    text : item.nom_departement
                }));
            });
            $('#departement').val(data.data.selectedDepartement)

            $.each(data.data.ville, function (i, item) {
                $('#ville').append($('<option>', {
                    value: item.id+'-'+item.code_insee,
                    text : item.nom_commune
                }));
            });
            $('#ville').val(data.data.selectedVille);

            $('html, body').stop().animate({
                scrollTop: $("#onePage").offset().top
            }, 1000);

        }
    });

    $(document).on('click','.btn-add',function (e) {
        e.preventDefault();
        $('.btn-save').html('Ajouter une ligne');
        $('#idContact').val("");
        $('#lastName').val("");
        $('#firstName').val("");
        $('#birthDate').val("");
        $('#birthDate').val("");
        removeAllOptionsExceptFirst("departement");
        removeAllOptionsExceptFirst("ville");
    });
});

$(document).on('click','.btn-remove',function (e) {
    e.preventDefault();
    var id = $(this).attr('id');
    deleteCampaign(id);
});

function removeAllOptionsExceptFirst(selectId) {
    $('#'+selectId+' option:not(:first)').remove();
}

function getRegionDepartementVille(type, filter) {

    $.ajax({
        type: "POST",
        url: Routing.generate('region_departement_ville'),
        data: JSON.stringify(filter),
        success: function (data)
        {
            $.each(data.data, function (key, value) {
                switch (type) {
                    case 'region':
                        $('#' + type).append($("<option></option>").attr("value", value.code_region).text(value.nom_region)).prop('disabled', false);
                        break;
                    case 'departement':
                        $('#' + type).append($("<option></option>").attr("value", value.numero_departement).text(value.nom_departement)).prop('disabled', false);
                        break;
                    case 'ville':
                        $('#' + type).append($("<option></option>").attr("value", value.code_insee+'-'+value.id).text(value.nom_commune)).prop('disabled', false);
                        break;
                }
            });
        }
    });
}

function deleteCampaign(id)
{
    var data = {
        'idContact': id,
    };
    $( "#dialog-confirm" ).removeClass('hidden');

    var info = $('tr#line-'+id+' > td:nth-child(1)').html()+' '+$('tr#line-'+id+' > td:nth-child(2)').html();
    $('#infoLine').html(info);
    $( "#dialog-confirm" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Supprimer": function() {
                $('#loader-contact').show();
                $.ajax({
                    type: "POST",
                    url: Routing.generate('crud_one_page_delete'),
                    data: JSON.stringify(data),
                    success: function (result) {
                        if (result.data.idContact) {
                            $('tr#line-'+result.data.idContact).remove();
                        }
                    }
                });
                $('#loader-contact').hide();
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
}

function messageAlert(message) {
    $( "#dialog-contact" ).removeClass('hidden');
    $('#dialog-contact-message').html(message);
    $( "#dialog-contact" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "OK": function() {
                $( this ).dialog( "close" );
            }
        }
    });
}