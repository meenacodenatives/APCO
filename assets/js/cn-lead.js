var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var regex_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/; //email validation regexp
var regex_website = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
var host = window.location.host;

$('.closeModal').click(function () {
    $('#mytracker').modal("hide");
});
$('#leadSearch').click(function () {
    $('#searchForm').toggle();
});
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
function leadresetForm() {
    $('#leadName').val('');
    $('#leadcontactName').val('');
    $('#leadEmail').val('');
    $('#from').val('');
    $('#to').val('');
    $('#leadPhone').val('');
    $('.ms-choice span').text('Select');
    $("input[data-name='selectAllleadStatus']:checkbox").prop('checked',false);
    $("input[data-name='selectItemleadStatus']:checkbox").prop('checked',false);
}
$(function () {
    $('#leadStatus').multipleSelect({
        filter: true
    })
    $('.from').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2019:+10'  
    });
    $('.to').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2019:+10'   
    });

});
//URL Validation
function createLead() {
    var data = {}
 
    data.leadName = $('#leadName').val();
    data.leadEmail = $('#leadEmail').val();
    data.leadPhone = $('#leadPhone').val();
    data.leadSkype = $('#leadSkype').val();
    data.leadWebsite = $('#leadWebsite').val();
    data.leadcontactName = $('#leadcontactName').val();
    data.source = $('#source').val();
    data.company_type = $('#company_type').val();
    data.status = $('#status').val();
    data.address = $('#address').val();
    data.remarks = $('#remarks').val();
    data.description = $('#description').val();
    data.id = $('#lead_id').val();

    $('.is-invalid').removeClass('is-invalid');
    var err = 0;

    //Website URL
    if (data.leadWebsite != '') {
        if (!regex_website.test(data.leadWebsite)) {
            $('#leadWebsite').addClass('is-invalid');
            $.growl({
                title: "",
                message: "Please enter valid website",
                duration: "2000",
                location: "tr",
                style: "error"
            });
            err++;
        }
    }
    if ($("#status").val() == '') {
        $('#status').addClass('is-invalid');
        err++;
    }
    if ($("#leadEmail").val() == '') {
        $('#leadEmail').addClass('is-invalid');
        err++;
    }
    if (data.leadEmail != '') {
        if (!regex_email.test(data.leadEmail)) {
            $('#leadEmail').addClass('is-invalid');
            $.growl({
                title: "",
                message: "Please enter valid email address",
                duration: "2000",
                location: "tr",
                style: "error"
            });
            err++;
        }
    }
    if ($("#leadName").val() == '') {
        $('#leadName').addClass('is-invalid');
        err++;
    }
    
    if ($("#leadcontactName").val() == '') {
        $('#leadcontactName').addClass('is-invalid');
        err++;
    }
    
    if ($("#source").val() == '') {
        $('#source').addClass('is-invalid');
        err++;
    }
    
    if (err > 0) {
        return false;
    }
    $('.ebtn').hide();
    $('#load-lead').html(loading_icon);

    $.ajax({
        url: base_url + '/createLead',
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
                    message: "Lead has been saved successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    window.location.href = base_url + '/leads';
                }, 1000);
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.ebtn').show();
                $('#load-lead').html('');
            }
        }

    });
}
//Edit

if ($('#dropdownTrigger').val() == 1) { //trigger location for country in lead edit
    getReg($('.leadCountry').val());
    getLoc($('#editReg').val());
}


//DELETE LEAD

$(document).on("click", "#confirmUserDelete", function(e) {

    var id = $(this).data('id');
    swal({
        title: "",
        text: "Are you really want to delete ?",
        type: "error",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        //confirmButtonColor: '#DD6B55',
        cancelButtonText: 'Cancel'
    }, function(isConfirm) {
        if (isConfirm) {
            deleteLead(id);
        }
    });
});

function deleteLead(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.deluser' + id).html(loading_icon);
    $.ajax({
        url: base_url + '/delete-lead',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function(data) {
            if (data.status == 1) {
                $.growl({
                    title: "",
                    message: "Lead has been deleted successfully",
                    duration: "1000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        }
    });
}
//END OF DELETE LEAD

function searchLead() {
    
    var data = {}
    //Validation
    var err = 0;

    data.leadName = $('#leadName').val();
    data.leadcontactName = $('#leadcontactName').val();
    data.leadPhone = $('#leadPhone').val();
    data.leadEmail = $('#leadEmail').val();
    data.leadStatus = $('#leadStatus').val();
    data.from = $('#from').val();
    data.to = $('#to').val();
    if ($("#from").val() != '') {
        if ($("#to").val() == '') {
        $('#to').addClass('is-invalid');
        err++;
        }
    }
    if (err > 0) {
        return false;
    }
    else
    {
        $('.load-search-lead').show();
        $('.load-search-lead').html(loading_icon);
        $('.searchlead').hide(); //Button name
        $('#hidelead').hide(); //all lead div
        $('.is-invalid').removeClass('is-invalid');
    }
    $.ajax({
        url: base_url + '/leadSearchResults',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            $('#hideLead').hide();
            $('#showLead').show();
            $('.searchlead').show();
            $('.load-search-lead').hide();
            $('.load-search-lead').html('');
            var rows = '';
            if (data.result.lead == '') {
                rows = rows + '<tr">';
                rows = rows + '<td colspan="8" class="span12 text-center">No Lead Found</td>';
                rows = rows + '</tr>';
            }
            else
            {
            $.each(data.result.lead, function (key, le) {
                var formattedDate=formatDate(le.created_date);
                var pg=host+'/edit-lead/'+btoa(le.id);
                rows = rows + '<tr">';
                rows = rows + '<td>' + le.name + '</td>';
                rows = rows + '<td>' + le.contact_name + '</td>';
                rows = rows + '<td>' + le.email + '</td>';
                rows = rows + '<td>' + le.phone + '</td>';
                rows = rows + '<td>' 
                $.each(data.result.leadStatus, function(key, value) {
                        if (le.status == value.code) {
                            rows = rows + value.meaning;
                        }
                });
                '</td>';
                rows = rows + '<td>' + formattedDate + '</td>';
                rows = rows + '<td><a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0" data-toggle="modal" id="viewSingleLead" data-target="#mytracker" data-id='+le.id+'><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="'+pg+'" class="ubtn'+le.id+'btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id="confirmUserDelete" data-id='+le.id+' class="ubtn'+le.id+' btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp; <span class="dellead'+le.id+'"></span>';
                '</td>';
                rows = rows + '</tr>';
            });
        }
            $('#showLead').html(rows);

        }
    });
}

