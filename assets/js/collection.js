
var $collectionHolder;
var $addTagButton = $('<a href="#" class="btn btn-info" style="margin-top: 10px">Add new item</a>');
//var $newLinkLi = $('<div id="description_list"></div>').append($addTagButton);

$(document).ready(function(){
    $collectionHolder = $('#detailListCollection');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($addTagButton);

// count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    //$collectionHolder.data('index', $collectionHolder.find(':input').length);

    $collectionHolder.data('index',$collectionHolder.find('.detail').length);

    $collectionHolder.find('.detail').each(function(){
        addRemoveButton($(this));
    });

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $(this));
    });

});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to

    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    //$collectionHolder.find('.description').each(function(){
    //    addRemoveButton($(this));
    //});

    // Display the form in the page in an li, before the "Add a tag" link li


    var $newFormLi = $('<div class="detail"></div>').append(newForm);
    $collectionHolder.append($newFormLi);

    var $containerList = $('<div class="detail1">' +
                            '<div class="col-md-3"></div>'+
                            '<div class="col-md-3"></div>'+
                            '<div class="col-md-3"></div>'+
                            '<div class="col-md-3"></div>'+
                        '</div>')

    // $collectionHolder.append($containerList);
    // console.log($newFormLi.find('#groupe_detail_'+index));


     // addRemoveButton($newFormLi);
    // $newLinkLi.before($newFormLi);
    // $newLinkLi.before($containerList);
    $collectionHolder.append($containerList);

    $('#group_detail_'+index).find('div').each(function (index,value) {
        var k = index +1;
        // $('.detail1 div:nth-child('+k+')').append(value)
        switch (k) {
            case 1:
                $('.detail1 div:nth-child(1)').append(value)
                break;
            case 2:
                $('.detail1 div:nth-child(2)').append(value)
                break;
        }
        // console.log(index);
        // console.log(value);
        // var $liste = $('<div class="col-md-4"></div>').append(value)
        // $containerList.append($liste)
    })

    $('.detail1 div:nth-child(3)').append($newLinkLi);

    // var $blocDelete = $('#group_detail_'+index+' div div:nth-child(3)')
    // addRemoveButton($blocDelete);
    addRemoveButton($('.detail1 div:nth-child(4)'));

}


function addRemoveButton(detail){
    var removeButton = $('<a class="btn btn-danger" style="margin-top: 10px">Remove Button</a>');

    removeButton.click(function(e){
        e.preventDefault();

        $(e.target).parent().parent().slideUp(1000,function(){
            $(this).remove();
        });
    });

    detail.append(removeButton);
}