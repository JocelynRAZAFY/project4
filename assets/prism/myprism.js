$.ajax({
    type: "GET",
    url: Routing.generate('content_prism'),
    success: function (result) {
        if (result.data.code) {
            loadPrism(result.data.code,result.data.language);
        }
    }
});

$('#showCode').click(function (e) {
    e.preventDefault();
    var code = $('#comment').val();
    var language = $('#language').val();

    console.log(Prism.languages.css);
   // var code = value.replace(new RegExp('<', 'g'), '&lt;');

    loadPrism(code,language);
});

function loadPrism(code,language) {
    var html;

    switch (language){
        case 'markup':
            html = Prism.highlight(code, Prism.languages.markup, language);
            break;

        case 'css':
            html = Prism.highlight(code, Prism.languages.css, language);
            break;

        case 'javascript':
            html = Prism.highlight(code, Prism.languages.javascript, language);
            break;

        case 'php':
            html = Prism.highlight(code, Prism.languages.php, language);
            break;
    }

    $('#prism').html(html);
}