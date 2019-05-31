/**
 * Array of urls passed to ajax
 * @var array urlArr
 */
var urlArr = [
    '/post/headers',
    '/post/contents',
    '/post/robots',
    '/post/insights'
];

$(document).ready(function(){

    //run checkInput to be sure
    checkInput($('#inputUrl'));

})

/**
 * Send ajax to url on index 'index' in global array urlArr.
 * Wait untill request is done, then executes another.
 *
 * @param  index index in array of urls
 */
function requestAjax(index){

    //end when reaches beyond array
    if(index === (urlArr.length)) return;

    $req = $.ajax({
        url: urlArr[index],
    });

    $req.done(function(data){
        //wait until request is finished, then perform output
        $('#result').append(data);
    })
    .done(function(data){
        //wait until output is performed, then call another request
        requestAjax(index+1);
    });

    //last one enables input
    if(index === (urlArr.length-1))
        $req.done(function(){
            showForm();
        });

    $req.fail(function(xhr){
        $('#result').append(xhr.responseText);
        showForm();
    });

}//requestAjax()

/**
 * Prevents form from default submit sets some
 * ajax request contents and sends certain ajax
 * requests.
 *
 * @param  e event (from form element)
 */
function submitForm(e) {

    e.preventDefault();

    $('#result').html('');

    //setup ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        dataType: 'html',
        data: $('#urlForm').serialize(),
    });

    hideForm();

    //run first ajax
    requestAjax(0);

}//submitForm()

/**
 * Checks if input is empty.
 * If it is disables button, otherwise allows.
 *
 * @param  el element with input
 */
function checkInput(el){

    if( $(el).val() != '' )
        $('#urlBtn').prop('disabled', false);
    else
        $('#urlBtn').prop('disabled', true);

}//checkInput()

/**
 * Hide form and show loader
 */
function hideForm() {

    $('#inputUrl').prop('disabled', true);
    $('.form form').hide();
    $('.form #loader').removeClass('d-none');

}

/**
 * Show form and hide loader
 */
function showForm() {

    $('#inputUrl').prop('disabled', false);
    $('.form form').show();
    $('.form #loader').addClass('d-none');

}
