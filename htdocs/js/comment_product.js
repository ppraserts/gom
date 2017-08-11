$('.statusEventHidden').click( function() {
    var id = $(this).data('id');
    var key_token = $("input[name=_token]").val();
    // none, bounce, rotateplane, stretch, orbit,
    // roundBounce, win8, win8_linear or ios
    var current_effect = 'stretch'; //
    run_waitMe(current_effect);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': key_token},
        type: "POST",
        url: partUrl+'/productview-update-status/'+id,
        data: {id: id, status: 0},
        success: function(response) {
            if(response.R == 'Y'){
                $('#hidden_'+id).prop('disabled', true);
                $('#show_'+id).prop('disabled', false);
                $('body').waitMe("hide");
            }
            return false;
        },
        error: function(response){
            alert('error!!');
            return false;
        }
    });
});
$('.statusEventShow').click( function() {
    var id = $(this).data('id');
    var key_token = $("input[name=_token]").val();
    // none, bounce, rotateplane, stretch, orbit,
    // roundBounce, win8, win8_linear or ios
    var current_effect = 'stretch'; //
    run_waitMe(current_effect);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': key_token},
        type: "POST",
        url: partUrl+'/productview-update-status/'+id,
        data: {id: id, status: 1},
        success: function(response) {
            if(response.R == 'Y'){
                $('#show_'+id).prop('disabled', true);
                $('#hidden_'+id).prop('disabled', false);
                $('body').waitMe("hide");
            }
            return false;
        },
        error: function(response){
            alert('error!!');
            return false;
        }
    });
});

function run_waitMe(effect) {
    $('body').waitMe({
        effect: effect,
        //text: 'Please waiting...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000'
    });
}
