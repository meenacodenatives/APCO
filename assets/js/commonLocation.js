//On page load - select 2 and validation
$(function () {
$('#state').select2({
    filter: true
})
$('#region').select2({
    filter: true
})
$('#location').select2({
    filter: true
})
});
$('#state').change(function () {
    getRegion(this.value, 'add');
    $('#location').hide();
});
$('#region').change(function () {
    getLocation(this.value, 'add');
});

function getRegion(stateID, type) {
    $('#region').hide();
    $('.load-region').show();
    $('.load-region').html(loading_icon);
    $.ajax({
        url: base_url + '/getRegion/'+stateID+'/'+type,
        type: 'GET',
        //data: {_token: CSRF_TOKEN, data: data},
        dataType: 'HTML',
        success: function (data) {
            $('#region').show();
            $('.load-region').hide();
            if (data != 0) { //success 
                $('#region').html(data);
                if (type == 'cmnReg') {
                    $('#region').val($('#editRegion').val());
                 //   $('#region').html('<option value="">Select</option>');
                    $('#region').html(data);
                    console.log("type"+JSON.stringify(data));
 }
            } else { //incorrect credentials
                $('#region').html('<option value="">Select</option>');
            }
        }
    });
}
function getLocation(regID, type) {
    $('#location').hide();
    $('.load-location').show();
    $('.load-location').html(loading_icon);
    $.ajax({
        url: base_url + '/getLocation/'+regID+'/'+type,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#location').show();
            $('.load-location').hide();
            console.log("data"+JSON.stringify(data));
            if (data != 0) { //success 
                $('#location').html(data);
                if (type == 'cmnLoc') {
                    $('#location').val($('#editLocation').val());
                    $('#location').html(data);
                }
            } else { //incorrect credentials
                $('#location').html('<option value="">Select</option>');
            }
        }
    });
}
