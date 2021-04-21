var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
function formatDate(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.toLocaleString('default', { month: 'short' });
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = month + " " + day + ", " + year;

    return date;
}
$(function() {
    $('.ron').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: 'mm/dd/yyyy',
        today: 'Today',
        min: true
    });
    $('#button1').on('click', function() {
        $('#mytracker').on('show.bs.modal', function() {
            $('.ron').pickadate({
                selectMonths: true,
                selectYears: 10,
                format: 'mm/dd/yyyy',
                today: 'Today',
                min: true
            });
        });
        $('#contact_type').val('');
        $('#notify_users').val('');
        $('#assignTo').val('');

        $('#comment').val('');
        $('.is-invalid').removeClass('is-invalid');
        // $('#notify_users').multipleSelect('refresh');
        // $('#assignTo').multipleSelect('refresh');
        $('.ms-choice span').text('Select');
    $("input[data-name='selectAllnotify_users']:checkbox").prop('checked',false);
    $("input[data-name='selectItemnotify_users']:checkbox").prop('checked',false);
    $("input[data-name='selectAllassignTo']:checkbox").prop('checked',false);
    $("input[data-name='selectItemassignTo']:checkbox").prop('checked',false);
    });

});
$(document).ready(function() {
    $('#generateRFQ').click(function() {
        $('#mytracker').modal('hide');

    });
    //Cancel Scheduler
    $('#cancelScheduler').click(function() {
        $('#addScheduler').hide();
        $('.openScheduler').show();
        $('.saveTracker').show();
    });

    //Open Scheduler
    $('.openScheduler').click(function() {
        $('#addScheduler').show();
        $('.openScheduler').hide();
        $('.saveTracker').hide();
    });
    // Close Popup
    $(".popup").on('click', function() {
        $('#mytracker').modal('hide');
        $('#viewTrackHistory').hide();
        $(".div.card-body.viewTrackHistory").html("");
    });
    //To get lead name , view tracked history , region,users
    $(document).on("click", ".getLeadname", function(e) {
        //start of Load Track History
        $('.load-track-history').html(loading_icon);
        $('.load-track-history').show();
        $("div.card-body.viewTrackHistory").hide();
        //End
        //Start Of tracker
        // $('.load-contactType').html(loading_icon);
        // $('.load-contactType').show();
        $('#notify_users').hide();
        $('#notify_users').multipleSelect({
            filter: true,
        })
        $('#assignTo').hide();
        $('#assignTo').multipleSelect({
                filter: true
            })
        
        //Start of Scheduler
        // $('#region').hide();
        // $('.load-region').html(loading_icon);
        // $('.load-region').show();
        //End
        $('#comment').val('');
        $('#contact_type').val('');
        $('#notify_users').val('');
        $('#scheduledDate').val('');
        $('#time').val('');
        $('#region').val('');
        var leadName = $(this).attr('data-leadName');
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
            success: function(data) {
                
                //load track history
                $('.load-track-history').hide();
                $("div.card-body.viewTrackHistory").show();

                //End
                $.each(data, function(key, value) {
                    
                    table_data_row(value.tracker, value.multiple_users, 'default');

                });

            }
        });

    });
});
//End of Data get from DB
// When schedule save button clicked
$('.saveScheduler').on('click', function() {
    var data = {}
    data.name = $('#scheduler_lead_name').val();

    data.contact_type = $('#contact_type').val();
    data.notify_users = $('#notify_users').val();
    data.comment = $('#comment').val();
    data.lead_id = $('#trac_lead_id').val();
    var count = $('#notify_users').find('option:selected').length;

    //Scheduler
    data.type_id = $('#trac_lead_id').val();
    data.region = $('#region').val();
    data.desc = $('#scheduler_lead_name').val();
    data.scheduledDate = $('#scheduledDate').val();
    data.time = $('#time').val();
    data.assignTo = $('#assignTo').val();
    var countassignTo = $('#assignTo').find('option:selected').length;

    data.lead_form = 'Both';
    $('.is-invalid').removeClass('is-invalid');
    //Validation
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

    if ($("#contact_type").val() == '') {
        $('#contact_type').addClass('is-invalid');
        err++;
    }

    if (countassignTo == 0) {
        $('.ms-parent').addClass("users-invalid");
    } else {
        $('.ms-parent').removeClass("users-invalid");

    }
    if (count == 0) {
        $('.ms-parent').addClass("users-invalid");
    } else {
        $('.ms-parent').removeClass("users-invalid");

    }
    if ($("#comment").val() == '') {
        $('#comment').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
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
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function(data) {
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Scheduler has been saved successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    $('.saveScheduler').show();
                    $('#cancelScheduler').show();
                    $('#load-schedule').hide();
                    $('.load-track-history').hide();
                    $("div.card-body.viewTrackHistory").show();
                    table_data_row(data.response.tracker, data.response.multiple_users, 'save');

                }, 3000);

                return false;
            }

        }
    });
});
// When tracker save button clicked
$('.saveTracker').on('click', function() {
    var data = {}
    data.name = $('#scheduler_lead_name').val();

    data.contact_type = $('#contact_type').val();
    data.notify_users = $('#notify_users').val();
    data.comment = $('#comment').val();
    data.lead_id = $('#trac_lead_id').val();
    data.lead_form = 'Tracker';
    $('.is-invalid').removeClass('is-invalid');
    var rows = '';

    var count = $('#notify_users').find('option:selected').length;
    var err = 0;
    //Validation
    if ($("#contact_type").val() == '') {
        $('#contact_type').addClass('is-invalid');
        err++;
    }
    if (count == 0) {
        $('.ms-parent').addClass("users-invalid");
    } else {
        $('.ms-parent').removeClass("users-invalid");

    }
    if ($("#comment").val() == '') {
        $('#comment').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
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
    //End
    $.ajax({
        url: base_url + '/saveLeadTracker',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function(data) {
            if (data.status == 1) { //success tracker
                $.growl({
                    title: "",
                    message: "Tracker has been saved successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    //End
                    $('.saveTracker').show();
                    $('.openScheduler').show();
                    $('#load-track').hide();
                    $('.load-track-history').hide();
                    $("div.card-body.viewTrackHistory").show();
                    table_data_row(data.response.tracker, data.response.multiple_users, 'save');
                }, 3000);
            }


            return false;

        }
    });
});
$(document).on("click", ".getLeadname", function (e) {
    $('.load-single-lead').html(loading_icon);
    $('.load-single-lead').show();
    var id = $(this).data('id');
    $("#mytracker").modal("show");
   
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/viewSinglelead/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.lead[0];
            $('.load-single-lead').hide();
            $('.hideForm').show();
            $('#contact_name').text(result.contact_name);
            $('#name').text(result.name);
            $('#email').text(result.email);
            $('#phone').text(result.phone);
            $('#skypeID').text(result.skype_id);
            $('#website').text(result.website);
            $('#source').text(result.source);
            $('#address').text(result.address);
            $('#company_type').text(result.company_type);
            $('#description').text(result.description);
            $('#remarks').text(result.remarks);
            $('#lastTrakedComment').text(result.last_tracked_comment);
            var lastTrackedDate = formatDate(result.last_tracked_date);
            $('#lastTrackedDate').text(lastTrackedDate);
            $('.load-single-lead').html('');
        }
    });

});
//Row displayed in view tracked history
function table_data_row(data, data1, view) {
    var rows = '';
    if (data == 0) {
        $('#notFound').text('No Tracks Found');
    } else {
        $.each(data, function(key, datavalue) {
            var userArray = datavalue.notify_users.split(",");
            rows = rows + '<div class="row pb-3">';
            rows = rows + '<div class="col-md-5">' + datavalue.createdFirstName + ' ' + datavalue.createdLastName + '</div>';
            rows = rows + '<div class="col-md-5">' + datavalue.lead_created_date + '</div>';
            rows = rows + '<div class="col-sm-2 lightBlue">' + datavalue.contact_type + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="row">';
            rows = rows + '<div class="col p-3">' + 'Notified To: ';
            $.each(data1, function(key, value) {

                $.each(userArray, function(i, j) {
                    if (i == userArray.length - 1) {
                        var s = '';
                    } else {
                        var s = ', ';
                    }
                    if (value.id == userArray[i]) {
                        rows = rows + value.username + s;
                    }
                });

            });
            rows = rows + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="row">';
            rows = rows + '<div class="col-10 p-3">' + datavalue.comment + '</div>';
            rows = rows + '</div>';
            rows = rows + '<div class="h-divider">';
            rows = rows + '</div>';

        });
        $('#notFound').text(' ');
    }
    if (view == 'default') {
        $("div.card-body.viewTrackHistory").html(rows);
    } else {
        $("div.card-body.viewTrackHistory").prepend(rows);
    }

}
//END OF  Tracker