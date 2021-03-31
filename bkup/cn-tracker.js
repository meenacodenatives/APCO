var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';

$(function () {
    $('.ron').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: 'mm/dd/yyyy',
        today: 'Today',
        min: true
    });

    $('#button1').on('click', function () {
        $('#mytracker').on('show.bs.modal', function () {
            $('.ron').pickadate({
                selectMonths: true,
                selectYears: 10,
                format: 'mm/dd/yyyy',
                today: 'Today',
                min: true
            });
        });
    });

});
$(document).ready(function () {

    //Cancel Scheduler
    $('#cancelScheduler').click(function () {
        $('#addScheduler').hide();
        $('.openScheduler').show();
        $('.saveTracker').show();
    });
    //Open Scheduler
    $('.openScheduler').click(function () {
        $('#addScheduler').show();
        $('.openScheduler').hide();
        $('.saveTracker').hide();
    });
    // Close Popup
    $(".popup").on('click', function () {
        $('#mytracker').modal('hide');
        $('#viewTrackHistory').hide();
        $(".div.card-body.viewTrackHistory").html("");
    });
    //To get lead name , view tracked history , region,users
    $('.getLeadname').click(function () {
        //start of Load Track History
        $('.load-track-history').html(loading_icon);
        $('.load-track-history').show();
        //End
        //Start Of tracker
        $('.load-contactType').html(loading_icon);
        $('.load-contactType').show();
        $('#contact_type').hide();
        $('#notify_users').hide();
        
        $('.load-notify_users').hide();
        //$('#notify_users').html(data);
        $('#notify_users').multipleSelect({
            filter: true,
        })
        
        $('#assignTo').multipleSelect({
            filter: true
        })
        //End of Tracker
        //Start of Scheduler
        $('#region').hide();
        $('.load-region').html(loading_icon);
        $('.load-region').show();
        //End
        $('#comment').val('');
        $('#contact_type').val('');
        $('#notify_users').val('');
        $('#scheduledDate').val('');
        $('#time').val('');
        $('#region').val('');
        $('#assignTo').val('');
        var leadName = $(this).attr('data-leadName');
        console.log("leadName=" + leadName);
        $('#notify_users').multipleSelect('refresh');
        $('#assignTo').multipleSelect('refresh');
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
                //Start of Tracker
                $('.load-contactType').hide();
                $('#contact_type').show();
                //End
                //Start of Scheduler
                $('.load-region').hide();
                $('#region').show();
                //End
                //load track history
                $('.load-track-history').hide();
                //End
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


                    table_data_row(value.tracker,value.multiple_users,'default');

                });

            }
        });

    });
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
    data.scheduledDate = $('#scheduledDate').val();
    data.time = $('#time').val();
    data.assignTo = $('#assignTo').val();
    data.lead_form = 'Both';
    $('.is-invalid').removeClass('is-invalid');

    var err = 0;
    if ($("#scheduledDate").val() == '') {
        $('#scheduledDate').addClass('is-invalid');
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
        console.log("scheduler" + JSON.stringify(data));
        $('.saveScheduler').hide();
        $('.openScheduler').hide();
        $('#cancelScheduler').hide();
        //Start of Load Track 
        $('#load-schedule').html(loading_icon);
        $('#load-schedule').show();
        //End
    }
    //start of Load Track History
    $('.load-track-history').html(loading_icon);
    $('.load-track-history').show();
    // $("div.card-body.viewTrackHistory").hide();
    //End
    $.ajax({
        url: base_url + '/saveLeadTracker',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Scheduler has been saved successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    $('.saveScheduler').show();
                    $('#cancelScheduler').show();
                    $('#load-schedule').hide();
                    $('.load-track-history').hide();
                    $("div.card-body.viewTrackHistory").show();
                    table_data_row(data.response.tracker,data.response.multiple_users,'save');

                }, 3000);

                return false;
            }

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
    $('.is-invalid').removeClass('is-invalid');
    var rows = '';

    var count = $('#notify_users').find('option:selected').length;
    var err = 0;

    if ($("#contact_type").val() == '') {
        $('#contact_type').addClass('is-invalid');
        err++;
    }
    if (count == 0) {
        $('.ms-parent').addClass("users-invalid");
    }
    else {
        $('.ms-parent').removeClass("users-invalid");
    }
    if ($("#comment").val() == '') {
        $('#comment').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    }
    else {
        $('.saveTracker').hide();
        $('.openScheduler').hide();
        //Start of Load Track 
        $('#load-track').html(loading_icon);
        $('#load-track').show();
        //End
    }
    //start of Load Track History
    $('.load-track-history').html(loading_icon);
    $('.load-track-history').show();
    // $("div.card-body.viewTrackHistory").hide();
    //End
    $.ajax({
        url: base_url + '/saveLeadTracker',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) { //success tracker
                $.growl({
                    title: "",
                    message: "Tracker has been saved successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    //End
                    $('.saveTracker').show();
                    $('.openScheduler').show();
                    $('#load-track').hide();
                    $('.load-track-history').hide();
                    $("div.card-body.viewTrackHistory").show();
                    table_data_row(data.response.tracker,data.response.multiple_users,'save');
                }, 3000);
            }


            return false;

        }
    });
});

//Row displayed in view tracked history
function table_data_row(data,data1,view) {
    console.log("datatable" + JSON.stringify(data1));
    var rows = '';
    if (data == 0) {
        rows = rows + '<div class="row">';
        rows = rows + '<div class="col-10 p-3">No Tracks Found</div>';
        rows = rows + '</div>';
    }
    else {
        $.each(data, function (key, value) {
            var userArray = value.notify_users.split(",");
            console.log("userArray"+userArray);
            rows = rows + '<div class="row pb-3">';
            rows = rows + '<div class="col-md-7">' + value.createdFirstName + ' ' + value.createdLastName + '</div>';
            rows = rows + '<div class="col-md-3">'+ value.lead_created_date + '</div>';
            rows = rows + '<div class="col-sm-1 badge badge-info">' + value.contact_type + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="row">';
            rows = rows + '<div class="col-md-7 p-3">'+'Notified To: ';
            $.each(data1, function (key,value) {
                $.each(userArray, function (i,j) {
                    console.log("i"+i);
                    if (i == userArray.length-1) {
                        var s ='';
                    }
                    else
                    {
                        var s =', ';
                    }
                    if (value.id == userArray[i]) {
                        rows = rows + value.username + s;
                    }
                });
            });
            rows = rows + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="row">';
            rows = rows + '<div class="col-10 p-3">' + value.comment + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="h-divider">';
            rows = rows + '</div>';

        });
    }
    if(view=='default')
    {
    $("div.card-body.viewTrackHistory").html(rows);
    }
    else
    {
     $("div.card-body.viewTrackHistory").prepend(rows);
    }
}
//END OF  Tracker
