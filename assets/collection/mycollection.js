$(document).ready(function () {
    // $('.my-selector').collection();
    $('.discount-collection').collection({
        allow_duplicate: true,
        allow_up: false,
        allow_down: false,
        add: '<a href="#" class="btn btn-default" title="Add element"><span class="glyphicon glyphicon-plus-sign"></span></a>',

        // here is the magic!
        elements_selector: 'tr.item',
        elements_parent_selector: '%id% tbody'
    });
});