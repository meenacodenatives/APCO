var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
$('#openSchedule').click(function () {
    $('#delDiv').hide();
    $('.showTitle').text('New Schedule');
    $('#stitle').val('');
    $('#stime').val('');
    $('#sdate').val('');
    $('#stimezone').val('');
    $('#sdesc').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.users-invalid').removeClass('users-invalid');
    $('#sassignTo').hide();

    $('#sassignTo').multipleSelect({
        filter: true
    })
    
    console.log("current");
    $('.ms-choice span').text('Select');
});

function createScheduler() {
    var data = {}
    data.stitle = $('#stitle').val();
    data.stime = $('#stime').val();
    data.sdate = $('#sdate').val();
    data.stimezone = $('#stimezone').val();
    data.sdesc = $('#sdesc').val();
    data.s_type = 'fullcalendar';
    var assignTo = $('#sassignTo').val();

    //Edit
    var id = $('#schedular_id').val();
    var type_id = $('#type_id').val();

    if (id == '') {
        data.id = 0;
        data.type_id = 0;
    } else {
        data.id = id;
        data.type_id = type_id;
    }
    //Edit Schedule
    if (assignTo != '') {
        data.sassignTo = assignTo;
    } else {
        data.sassignTo = $('#hidAssignTo').val();
    }
    console.log("sassignTo=" + sassignTo);

    $('.is-invalid').removeClass('is-invalid');
    $('.users-invalid').removeClass('users-invalid');
    var err = 0;
    //Edit
    var id = $('#schedular_id').val();
    var single = $("input[data-name='selectItemsassignTo']:checked").val();
    var multiple = $("input[data-name='selectAllsassignTo']:checkbox").prop('checked');
    if (single == undefined && multiple == false) {
        $('.ms-parent').addClass("users-invalid");
        err++;
    }
    if ($("#stitle").val() == '') {
        $('#stitle').addClass('is-invalid');
        err++;
    }
    if ($("#stime").val() == '') {
        $('#stime').addClass('is-invalid');
        err++;
    }
    if ($("#sdate").val() == '') {
        $('#sdate').addClass('is-invalid');
        err++;
    }
    if ($("#stimezone").val() == '') {
        $('#stimezone').addClass('is-invalid');
        err++;
    }
    if ($("#sdesc").val() == '') {
        $('#sdesc').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
        $('.schedulerSave').hide();
        $('#load-scheduler').html(loading_icon);
        $('#delDiv').hide();
    }
    console.log("INPUT=" + JSON.stringify(data));
    $.ajax({
        url: base_url + '/createScheduler',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            $("#schedular-popup").modal("hide");
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Scheduler has been saved successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/schedular';
                }, 1000);
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.schedulerSave').show();
                $('#load-scheduler').html('');
            }
        }

    });
}
//DELETE Scheduler
$(document).on("click", "#schedularConfirmUserDelete", function (e) {
    var id = $("#type_id").val();
    swal({
        title: "",
        text: "Are you really want to delete ?",
        type: "error",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }, function (isConfirm) {
        if (isConfirm) {
            deleteSchedular(id);
        }
    });
});

function deleteSchedular(id) {
    var data = {}
    data.id = id;
    $('#delDiv').hide();
    $('.schedulerSave').hide();
    $('#load-del-scheduler').html(loading_icon);
    $('#load-del-scheduler').show();
    $.ajax({
        url: base_url + '/delete-schedular',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) {
                $("#schedular-popup").modal("hide");
                $('#load-del-scheduler').hide();
                $.growl({
                    title: "",
                    message: "Schedular has been deleted successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }
        }
    });
}
//END OF DELETE Scheduler