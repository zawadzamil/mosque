console.log('Working')
const addMosque = document.getElementById('addMosque').addEventListener('click',function () {
    console.log('Entered')
    $.ajax({
        url: 'http://myserver.dev/myAjaxCallURI',
        type: 'post',
        data: $('form').serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
            // Handle your response..
        },
        error: function( _response ){
            // Handle error
        }
    });

})
