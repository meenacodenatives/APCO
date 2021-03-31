var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';

$(function(e) {
	'use strict'
$('#button1').on('click', function () { 
    $('#mytracker').on('show.bs.modal', function () {
        
    });       
   
    });

    //Cancel Scheduler
    $('#cancelScheduler').click(function () {
        $('#addScheduler').hide();
        $('.openSchedulerButton').show();
        $('#hideTrack').show();
    });
    // Close Popup
    $(".popup").on('click', function () {
        $('#mytracker').modal('hide');
        $('#viewTrackHistory').hide();
        $(".div.card-body.viewTrackHistory").html("");
    });
    //To get lead name , view tracked history , region,users
    $('.getLeadname').click(function () {
        $('.load-location').html(loading_icon);
        $('.load-location').show();
        $('#contact_type').hide();
        $('#notify_users').hide();
        $('#region').hide();
        $('#assignTo').hide();
        $('#comment').val('');
        $('#contact_type').val('');
        $('#notify_users').val('');
        $('#scheduledDate').val('');
        $('#time').val('');
        $('#region').val('');
        $('#assignTo').val('');
        var leadName = $(this).attr('data-name');
        console.log("leadName=" + leadName);
        var leadID = $(this).attr('data-id');
        $('.showContactName').text(leadName);
        $('#trac_lead_id').val(leadID);
        $('#scheduler_lead_name').val(leadName);
        var data = {}
        data.lead_id = $('#trac_lead_id').val();
        $.ajax({
            url: base_url + '/leadTracker/' + data.lead_id,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('.load-location').hide();
                $('#contact_type').show();
                $('#notify_users').show();
                $('#region').show();
                $('#assignTo').show();
                $.each(data, function (key, value) {
                    //Contact Type
                    $('#contact_type').html('<option value="">Select</option>');
                    $.each(value.track_contact_type, function (key, value) {
                        $("#contact_type").append('<option value="' + value.meaning + '" >' + value.meaning + '</option>');
                    });
                    //Region
                    $('#region').html('<option value="">Select</option>');
                    $.each(value.region, function (key, value) {
                        $("#region").append('<option value="' + value.id + '" >' + value.name + '</option>');
                    });
                    //users
                    $('#notify_users').html('<option value="">Select</option>');
                    $.each(value.users, function (key, value) {
                    $("#notify_users").append('<option value="' + value.id + '" >' + value.firstname + ' ' + value.lastname + '</option>');
                    });
                    //users scheduler
                    $('#assignTo').html('<option value="">Select</option>');
                    $.each(value.users, function (key, value) {
                        $("#assignTo").append('<option value="' + value.id + '" >' + value.firstname + ' ' + value.lastname + '</option>');
                    });

                    table_data_row(value.tracker);

                });

            }
        });
    });
    $('#addScheduler').show();
    $('#hideTrack').hide();
    $('.openSchedulerButton').hide();
});
//End of Data get from DB
// When schedule save button clicked
$('.saveScheduler').on('click', function () {
    var data = {}
    data.contact_type = $('#contact_type').val();
    data.notify_users = $('#notify_users').val();
    data.comment = $('#comment').val();
    data.lead_id = $('#trac_lead_id').val();
    //Scheduler
    data.type_id = $('#trac_lead_id').val();
    data.region = $('#region').val();
    data.desc = $('#scheduler_lead_name').val();
    data.time = $('#time').val();
    data.assignTo = $('#assignTo').val();
    data.lead_form = 'Both';
    var err = 0;
    if ($(".scheduledDate").val() == '') {
        $('.scheduledDate').addClass('is-invalid');
        err++;
    }
    if ($("#time").val() == '') {
        $('#time').addClass('is-invalid');
        err++;
    }
    if ($("#region").val() == '') {
        $('#region').addClass('is-invalid');
        err++;
    }
    if ($("#assignTo").val() == '') {
        $('#assignTo').addClass('is-invalid');
        err++;
    }
    if ($("#contact_type").val() == '') {
        $('#contact_type').addClass('is-invalid');
        err++;
    }
    if ($("#notify_users").val() == '') {
        $('#notify_users').addClass('is-invalid');
        err++;
    }
    if ($("#comment").val() == '') {
        $('#comment').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    }
    else {
        $('.load-location').html(loading_icon);
        $('.load-location').show();
    }
    $.ajax({
        url: base_url + '/saveLeadTracker',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            $('.load-location').hide();
            table_data_row(value.tracker);
            return false;
        }
    });
});
// When tracker save button clicked
$('.saveTracker').on('click', function () {
    var data = {}
    data.contact_type = $('#contact_type').val();
    data.notify_users = $('#notify_users').val();
    data.comment = $('#comment').val();
    data.lead_id = $('#trac_lead_id').val();
    data.lead_form = 'Tracker';
    var err = 0;
    if ($("#contact_type").val() == '') {
        $('#contact_type').addClass('is-invalid');
        err++;
    }
    if ($("#notify_users").val() == '') {
        $('#notify_users').addClass('is-invalid');
        err++;
    }
    if ($("#comment").val() == '') {
        $('#comment').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    }
    else {
        $('.load-location').html(loading_icon);
        $('.load-location').show();
    }
    $.ajax({
        url: base_url + '/saveLeadTracker',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            $('.load-location').hide();
            console.log("datadata" + JSON.stringify(data.tracker));
            table_data_row(value.tracker);
            return false;
        }
    });
});

function table_data_row(data) {
    var rows = '';
    if (data == 0) {
        rows = rows + '<div class="row">';
        rows = rows + '<div class="col-10 p-3">No Tracks Found</div>';
        rows = rows + '</div>';
    }
    else {
        $.each(data, function (key, value) {
            rows = rows + '<div class="row pb-3">';
            rows = rows + '<div class="col-3">' + value.createdFirstName + ' ' + value.createdLastName + '</div>';
            rows = rows + '<div class="col-3">' + value.lead_created_date + '</div>';
            rows = rows + '<div class="col-3">' + value.contact_type + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="row">';
            rows = rows + '<div class="col-10 p-3">' + value.firstName + ' ' + value.lastName + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="row">';
            rows = rows + '<div class="col-10 p-3">' + value.comment + '</div>';
            rows = rows + '</div>';
        });
    }
    $("div.card-body.viewTrackHistory").html(rows);
}
