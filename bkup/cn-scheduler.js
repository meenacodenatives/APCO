var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
  //Title Change
  var id =$("#schedular_id").val();
  if(id=='')
  {
      console.log("id=="+id);
      var title='New Schedule';
      $('.showTitle').text(title);
  }
  

// $(function () 
// {
  
//     $('#sassignTo').multipleSelect({
//         filter: true,
//     })
// });

$('#openSchedule').click(function(){
    $('#delDiv').hide();
});
function createScheduler() {
    var data = {}
    data.stitle = $('#stitle').val();
    data.stime = $('#stime').val();
    data.sdate = $('#sdate').val();
    data.stimezone = $('#stimezone').val();
    data.sdesc = $('#sdesc').val();
    data.sassignTo = $('#sassignTo').val();
    var cntAssignTo = $('#sassignTo').find('option:selected').length;
    //Edit
     var id= $('#schedular_id').val();
    if(id=='')
    {
        data.id=0;
    }
    else
    {
        data.id=id;
    }
    $('.is-invalid').removeClass('is-invalid');
    var err = 0;
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
    if (cntAssignTo == 0) {
        $('.ms-parent').addClass("users-invalid");
        err++;
    }
    else {
        $('.ms-parent').removeClass("users-invalid");
    }
    if (err > 0) {
        return false;
    }
    else {
    $('.schedulerSave').hide();
    $('#load-scheduler').html(loading_icon);
    $('#delDiv').hide();
    }
    console.log("inputscheduler"+JSON.stringify(data));

    $.ajax({
        url: base_url + '/createScheduler',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            $("#schedular-popup").modal("hide");
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Scheduler has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                   window.location.href = base_url + '/schedular';
               }, 2000);
            }
            else { //error
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
    var id =$("#schedular_id").val();
    swal({
        title: "",
        text: "Are you really want to delete ?",
        type: "error",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        //confirmButtonColor: '#DD6B55',
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
        data: { _token: CSRF_TOKEN, data: data },
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
//END OF DELETE LEAD