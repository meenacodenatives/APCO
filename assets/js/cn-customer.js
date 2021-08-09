var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var regex_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/; //email validation regexp
var regex_website = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;

$('#customerSearch').click(function () {
    $('#searchForm').toggle();
});
function customerresetForm() {
    $('#leadName').val('');
    $('#leadcontactName').val('');
    $('#leadEmail').val('');
    $('#customerFrom').val('');
    $('#customerTo').val('');
    $('#leadPhone').val('');
    $('.ms-choice span').text('Select');
    $("input[data-name='selectAllleadStatus']:checkbox").prop('checked',false);
    $("input[data-name='selectItemleadStatus']:checkbox").prop('checked',false);
}
$(function () {
    $('#customerStatus').multipleSelect({
        filter: true
    })
    $('#customerFrom').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2019:+10'  
    });
    $('#customerTo').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2019:+10'   
    });

});
//Customer - Create and edit 
function createCustomer() {
    var data = {}
    data.customer_name = $('#customer_name').val();
    data.company_type = $('#company_type').val();
    data.customer_id = $('#customer_id').val();
    data.board_no = $('#board_no').val();
    data.contact_name = $('#contact_name').val();
    data.customer_gst_number = $('#customer_gst_number').val();
    data.customer_choice = $('#customer_choice').val();
    data.customer_status = $('#customer_status').val();
    data.customer_state = $('#state').val();
    data.customer_region = $('#region').val();
    data.customer_location = $('#location').val();
    data.customer_address = $('#customer_address').val();
    data.customer_direct_no = $('#customer_direct_no').val();
    data.customer_email_secondary = $('#customer_email_secondary').val();
    data.customer_mobile_no = $('#customer_mobile_no').val();
    data.contact_web = $('#contact_web').val();
    data.customer_email_primary = $('#customer_email_primary').val();
    data.customer_mode = $('#customer_mode').val();
    data.id = $('#row_id').val();
    $('.is-invalid').removeClass('is-invalid');
    var err = 0;
    if ($("#customer_name").val() == '') {
        $('#customer_name').addClass('is-invalid');
        err++;
    }
    if ($("#company_type").val() == '') {
        $('#company_type').addClass('is-invalid');
        err++;
    }
    if ($("#customer_id").val() == '') {
        $('#customer_id').addClass('is-invalid');
        err++;
    }
    if ($("#board_no").val() == '') {
        $('#board_no').addClass('is-invalid');
        err++;
    }
    if ($("#contact_name").val() == '') {
        $('#contact_name').addClass('is-invalid');
        err++;
    }
    if ($("#customer_gst_number").val() == '') {
        $('#customer_gst_number').addClass('is-invalid');
        err++;
    }
    if ($("#customer_choice").val() == '') {
        $('#customer_choice').addClass('is-invalid');
        err++;
    }
    if ($("#customer_status").val() == '') {
        $('#customer_status').addClass('is-invalid');
        err++;
    }
    if ($("#customer_state").val() == '') {
        $('#customer_state').addClass('is-invalid');
        err++;
    }
    if ($("#customer_region").val() == '') {
        $('#customer_region').addClass('is-invalid');
        err++;
    }
    if ($("#customer_location").val() == '') {
        $('#customer_location').addClass('is-invalid');
        err++;
    }
    if ($("#customer_direct_no").val() == '') {
        $('#customer_direct_no').addClass('is-invalid');
        err++;
    }
    if ($("#customer_email_primary").val() == '') {
        $('#customer_email_primary').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    }
    console.log("DD"+JSON.stringify(data));
    //$('.ebtn').hide();
    //$('#load-customer').html(loading_icon);

    $.ajax({
        url: base_url + '/createCustomer',
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
                    message: "Customer has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    window.location.href = base_url + '/showCustomer';
                }, 2000);
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.ebtn').show();
                $('#load-customer').html('');
            }
        }

    });
}
//DELETE Customer - Change status of the customer

$(document).on("click", "#customerConfirmUserDelete", function(e) {

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
            deleteCustomer(id);
        }
    });
});

function deleteCustomer(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.delcustomer' + id).html(loading_icon);
    $.ajax({
        url: base_url + '/delete-customer',
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
                    message: "Customer has been deleted successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        }
    });
}

//END OF DELETE Customer

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
                var pg='/edit-lead/'+btoa(le.id);
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
                rows = rows + '<td><a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0" data-toggle="modal" id="viewSingleLead" data-target="#mytracker" data-id='+le.id+'><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="'+pg+'" class="btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id="confirmUserDelete" data-id='+le.id+' class="ubtn'+le.id+' btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp; <span class="deluser'+le.id+'"></span>';
                '</td>';
                rows = rows + '</tr>';
            });
        }
            $('#showLead').html(rows);

        }
    });
}