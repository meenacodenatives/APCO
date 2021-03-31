$(function (e) {
    "use strict";
    var today = moment().day();
    var schedules = JSON.parse($('#all_schedules').val());
    console.log("schedules="+JSON.stringify(schedules));

    $('#calendar1').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        //Modal Popup
        eventRender: function (event, element) {
            element.attr('href', 'javascript:void(0);');
            element.click(function() {
                console.log("event="+event.id);
                var title='Edit Schedule';
                $('.showTitle').text(title);
                 $('#delDiv').show();
                 $('.load-schedular').html(loading_icon);
                 $('.load-schedular').show();
                 $('.hideForm').hide();
                 $("#schedularConfirmUserDelete").attr('disabled', 'disabled');
                 $(".schedulerSave").attr('disabled', 'disabled');
                $.ajax({
                    url: base_url + '/edit-schedular/'+event.id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data) {
                        console.log("GOOD");
                       var result=data.scheduler;
                       $('.load-schedular').hide();
                       var title='Edit Schedule - ' +data.titleLeadName;
                       $('.showTitle').text(title);
                       $('.hideForm').show();
                       $('#schedularConfirmUserDelete').removeAttr('disabled');
                       $('.schedulerSave').removeAttr('disabled');
                       $("#sdate").val(data.sdate);
                       $("#stime").val(data.stime);
                       $.each(result, function (key, value) {
                       $("#stitle").val(value.title);
                       $("#stimezone").val(value.region);
                       $("#sdesc").val(value.description);
                       $("#hidAssignTo").val(value.user_id);
                       $("#type_id").val(value.type_id);
                    //    $(".ms-parent").show();
                    //    $(".ms-parent ul li").val(value.user_id);
                    //    $('.ms-drop bottom').show();
                       var values = value.user_id.split(',');
                       $(".ms-parent").find('[value=' + values.join('], [value=') + ']').prop("checked", true);
                    //    $('#load_sassignTo').hide();
                       });
                    }
                
                });
                 $("#schedular_id").val(event.id);
                $("#schedular-popup").modal("show");
            });
        },
        
        // customize the button names,
        // otherwise they'd all just say "list"
        views: {
            agendaDay: {
                buttonText: 'List Day'
            },
            agendaWeek: {
                buttonText: 'List Week'
            },
            month: {
                buttonText: 'Month'
            },
            today: {
                buttonText: 'Today'
            }
        },
        defaultView: 'month',
        //firstDay: today,
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectHelper: true,
        select: function (start, end) {
            var title = prompt('Event Title:');
            var eventData;
            if (title) {
                eventData = {
                   title: title,
                    start: start,
                   end: end
                };
                $('#calendar1').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            $('#calendar1').fullCalendar('unselect');
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: schedules
    });

    var dateToday = new Date();

    $('#sdate').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: 'mm/dd/yyyy',
        today: 'Today',
        min: true
        });

    $('#sassignTo').multipleSelect({
        filter: true,
    });
});