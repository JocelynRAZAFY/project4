$(document).ready(function(){
    let selectedValue = 'md'
    let listValue = {usa: "United States",india: "India",uk: "United Kingdom",md: "Madagascar",fr: "France"}

    $(document).on("click", ".update", function(){
        const inputs = $(this).parents("tr").find('input[type="text"]');
        const selects = $(this).parents("tr").find('select.country');

        inputs.each(function(){
            $(this).parent("td").html($(this).val());
        });
        selects.each(function(){
            const value = $(this).children("option:selected").val()
            selectedValue = value
            $(this).parent("td").html(listValue[value]);
        });
        toogleCompenent($(this))
    });

    $(document).on("click", ".edit-test", function(){
        const tds = $(this).parents("tr").find("td:not(:last-child)")
        const select = '<select class="form-control country">'+
                            '<option value="usa" '+ (selectedValue == "usa" ? "selected" : "") +'>United States</option>' +
                            '<option value="india" '+ (selectedValue == "india" ? "selected" : "") +'>India</option>' +
                            '<option value="uk" '+ (selectedValue == "uk" ? "selected" : "") +'>United Kingdom</option>' +
                            '<option value="md" '+ (selectedValue == "md" ? "selected" : "") +'>Madagascar</option>' +
                            '<option value="fr" '+ (selectedValue == "fr" ? "selected" : "") +'>France</option>' +
                        '</select>'

        tds.each(function(i){
            if(i != 4){
                if(i != 0){
                    $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
                }
            }else {
                $(this).html(select);
            }

        });
        $(this).parents("tr").find(".update, .edit-test").toggle();
        $(this).parents("tr").find(".cancel, .remove-test").toggle();
    });

    $(document).on("click", ".remove-test", function(){
        $(this).parents("tr").remove();
    });

    $(document).on("click", ".add-line", function(){
        let actions = $("table.table-test td:last-child").html();
        let index = $("table.table-test tbody tr:last-child").index();
            index = parseInt(index) + 1
        let incice = parseInt(index) + 1
        const row = '<tr>' +
                        '<td scope="row">'+incice+'</td>'+
                        '<td><input type="text" class="form-control" name="article" id="article"></td>' +
                        '<td><input type="text" class="form-control" name="author" id="author"></td>' +
                        '<td><input type="text" class="form-control" name="shares" id="shares"></td>' +
                        '<td>' +
                            '<select class="form-control country">'+
                                '<option value="usa">United States</option>' +
                                '<option value="india">India</option>' +
                                '<option value="uk">United Kingdom</option>' +
                                '<option value="md">Madagascar</option>' +
                                '<option value="fr">France</option>' +
                            '</select>'+
                        '</td>' +
                        '<td>' + actions + '</td>' +
                    '</tr>';

        $("table.table-test").append(row);
        $("table.table-test tbody tr").eq(index).find(".update, .edit-test").toggle();
        $("table.table-test tbody tr").eq(index).find(".cancel, .remove-test").toggle();

    });

    $(document).on("click", ".cancel", function(){
        let inputs = $(this).parents("tr").find('input[type="text"]');
        const selects = $(this).parents("tr").find('select.country');

        inputs.each(function(){
            $(this).parent("td").html($(this).val());
        });
        selects.each(function(){
            $(this).parent("td").html(listValue[selectedValue]);
        });
        toogleCompenent($(this))
    });

    function toogleCompenent(me) {
        me.parents("tr").find(".update, .edit-test").toggle();
        me.parents("tr").find(".cancel, .remove-test").toggle();
    }

    function getLabelSelect(value) {

    }

});