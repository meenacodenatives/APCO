var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var pathname = window.location.pathname.split("/");
console.log("path=" + pathname[3]);
//On page load - select 2 and validation
$(function () {
    $('.inv_delivery_date').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: 'mm/dd/yyyy',
        today: 'Today',
        min: true
    });
   
});
//Close modal
$('.closeModal').click(function () {
    $('#viewInvoice').modal("hide");
});
//View Single Invoice
$(document).on("click", "#viewSingleInvoice", function (e) {
    $('.load-view-singleInvoice').show();
    $('.load-view-singleInvoice').html(loading_icon);
    
    var id = $(this).data('id');

    $("#viewInvoice").modal("show");
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/viewSingleInvoice/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var invoice = data.invoiceDetails;
            var invoiceProductDetails = data.invoiceProductDetails;
            var invoice_no = data.invoice_no;
            $('.invoiceNo').text(invoice_no);
            $('#trac_WO_id').val(data.work_order_id); //cn-rfq-tracker
            $('.load-view-singleWO').hide();
            $('.hideForm').show();
            $('#rowID').val(invoice.id);
            $("div.row.viewInvoiceData").html(invoice);
            $("div.row.viewInvoiceProductDetails").html(invoiceProductDetails);
            $('.load-view-singleInvoice').html('');
        }
    });

});
//Delete
$(document).on("click", "#confirmInvDelete", function (e) {
    var inv_id = $(this).data('id');
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
            deleteInvoice(inv_id);
        }
    });
});


function deleteInvoice(inv_id) {
    //alert("inv_id"+inv_id);
    var data = {}
    data.inv_id = inv_id;
    $('.ubtn' + inv_id).hide();
    $('.delInv' + inv_id).html(loading_icon);
    $.ajax({
        url: base_url + '/delete-Invoice',
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
                    message: "Invoice has been deleted successfully",
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
//END OF DELETE Invoice