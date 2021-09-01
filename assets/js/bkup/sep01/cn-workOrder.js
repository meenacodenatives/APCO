var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var host = window.location.host;
var pathname = window.location.pathname.split("/");
console.log("path=" + pathname[1]);
//View RFQ - detailed - History
function quotationDetailed(id) {
    $('.showQuotation-' + id).toggle();
}
//Close modal
$('.closeModal').click(function () {
    $('#viewWorkOrder').modal("hide");
});

//Cancel Scheduler
$('#cancelPopupScheduler').click(function () {
    $('#viewWorkOrder').modal("hide");
});


//View Single RFQ
$(document).on("click", "#viewSingleWorkOrder", function (e) {
    $('.load-view-singleWorkOrder').show();
    $('.load-view-singleWorkOrder').html(loading_icon);
    $('.quotationBut').hide();
    $('#notify_users').hide();
        $('#notify_users').multipleSelect({
            filter: true,
        })
        $('#assignTo').hide();
        $('#assignTo').multipleSelect({
                filter: true
            })
            $('#sassignTo').multipleSelect({
                filter: true
            })
    var id = $(this).data('id');

    $("#viewWorkOrder").modal("show");
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/viewSingleWorkOrder/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var workOrder = data.workorderDetails;
            var workorderProductDetails = data.workorderProductDetails;
            var work_order_no = data.work_order_no;
            $('.workOrderNo').text(work_order_no);
            $('#trac_RFQ_id').val(data.work_order_id); //cn-rfq-tracker

            $('.load-view-singleRFQ').hide();
            $('.hideForm').show();
            $('#rowID').val(workOrder.id);
            $("div.row.viewworkOrderData").html(workOrder);
            $("div.row.viewworkorderProductDetails").html(workorderProductDetails);

            $('.load-view-singleWorkOrder').html('');
        }
    });

});


//DELETE RFQ
$(document).on("click", "#confirmRFQDelete", function (e) {
    var quote_id = $(this).data('id');
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
            deleteRFQ(quote_id);
        }
    });
});

function deleteRFQ(quote_id) {
    var data = {}
    data.quote_id = quote_id;
    $('.ubtn' + quote_id).hide();
    $('.delrfq' + quote_id).html(loading_icon);
    $.ajax({
        url: base_url + '/delete-RFQ',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) {
                $.growl({
                    title: "",
                    message: "RFQ has been deleted successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
        }
    });
}
//END OF DELETE PRODUCT

function searchRFQ() {

    var data = {};
    var err = 0;

    data.customer_name = $('#customer_name').val();
    data.contact_name = $('#contact_name').val();
    data.email = $('#email').val();
    data.phone = $('#phone').val();
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
    else {
        $('.load-search-RFQs').show();
        $('.load-search-RFQs').html(loading_icon);
        $('.searchRFQs').hide(); //Button name
        $('#hideRFQs').hide(); //all RFQ div
        $('.is-invalid').removeClass('is-invalid');

    }

    $.ajax({
        url: base_url + '/RFQsearchResults',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            $('#hideRFQs').hide();
            $('#showRFQs').show();
            $('.searchRFQs').show();
            $('.load-search-RFQs').hide();
            $('.load-search-RFQs').html('');
            var rows = '';
            if (data.allRFQs == '') {
                rows = rows + '<tr">';
                rows = rows + '<td colspan="8" class="span12 text-center">No RFQ Found</td>';
                rows = rows + '</tr>';
            }
            else {
                $.each(data.allRFQs, function (key, pt) {
                    var formattedDate = formatDate(pt.created_at);
                    if (pt.last_tracked_date != null) {
                        var last_tracked_date = formatDate(pt.last_tracked_date);
                    }
                    else {
                        var last_tracked_date = '';
                    }

                    var pg = '/edit-RFQ/' + btoa(pt.id);
                    rows = rows + '<tr">';
                    rows = rows + '<td>' + pt.customer_name + '</td>';
                    rows = rows + '<td>' + pt.contact_name + '</td>';
                    rows = rows + '<td>' + pt.email + '</td>';
                    rows = rows + '<td>' + pt.proposed_value + '</td>';
                    rows = rows + '<td>' + pt.final_value + '</td>';
                    rows = rows + '<td>' + last_tracked_date + '</td>';
                    rows = rows + '<td>' + formattedDate + '</td>';
                    rows = rows + '<td><a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0 getRFQname" data-toggle="modal" id="viewSingleRFQ" data-target="#viewRFQ" data-id="' + btoa(pt.id) + '" data-RFQName="' + pt.customer_name + '"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="' + pg + '" class="ubtn' + btoa(pt.id) + ' btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip" id="editSingleRFQ" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp; <a id="confirmRFQDelete" data-id="' + pt.id + '"class="ubtn' + pt.id + ' btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;<span class="delrfq' + pt.id + '"></span>'; '</td>';
                    rows = rows + '</tr>';
                });
            }
            $('#showRFQs').html(rows);

        }
    });
}

