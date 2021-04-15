var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var host = window.location.host;
var pathname = window.location.pathname.split("/");
console.log("pathname"+pathname);
console.log("pathname[2]"+pathname[2]);

$('#recurring').click(function () {
    if ($(this).is(':checked')) {
        $("#amc").removeAttr("disabled");
    }
    else {
        $("#amc").attr("disabled", "disabled");
    }
});
if (pathname[1] == 'edit-RFQ') {
    console.log("edit"+pathname);
    //Filter - Select 2 
    //END
    $('#editPreselectProducts').show();
    $('.hideProposalVal').show();
    $('.hideTotPdt').show();
    $('.hideFinalVal').show();
    $("#quantity-1").removeAttr("disabled", "disabled");
}
if (pathname[1] == 'add-RFQ') {
    var actual_p = '';
    actual_p = actual_p + '<option value="">Select</option>';
    $("#actual_price-1").attr("disabled", "disabled");
    $("#units-1").attr("disabled", "disabled");
    $(".subtotal").attr("disabled", "disabled");
    $('#quantity-1').attr("disabled", "disabled");
    $('#actual_price-1').html(actual_p);
}
$('.closeModal').click(function () {
    $('#viewProduct').modal("hide");
});

$('#cancelPopupScheduler').click(function () {
    $('#viewProduct').modal("hide");
});

$('#rfqSearch').click(function () {
    $('#searchForm').toggle();
});

$(function () {
    //To display the select 2 drop down
    var rowCnt = $('#sno').val();
    if (pathname[2] == 'edit-RFQ') {
        console.log("rowCnt" + rowCnt);
        if (rowCnt) {
            for (var i = 1; i <= rowCnt + 1; i++) {
                $('#product_name-' + i).select2({
                    filter: true
                })
            }
        }
    }
    $('#product_name-1').select2({
        filter: true
    })
    //END
    var err = 0;
    //MARGIN and Disocunt - Validation
    $("#margin").bind("keypress", function (e) {
        console.log("s=");
        var keyCode = e.keyCode || e.which;
        //Regex for Valid Characters i.e. Numbers.
        var regex = /^[%0-9]+$/;
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            $('#margin').addClass('is-invalid');
            err++;
            return false;
        }
        else {
            $('.is-invalid').removeClass('is-invalid');
        }
    });
    $("#add_discount").bind("keypress", function (e) {
        console.log("disc=");
        var keyCode = e.keyCode || e.which;
        //Regex for Valid Characters i.e. Numbers.
        var regex = /^[%0-9]+$/;
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            $('#add_discount').addClass('is-invalid');
            err++;
            return false;
        }
        else {
            $('.is-invalid').removeClass('is-invalid');
        }
    });
    //END
});
//compare Stock with quantity
$(document).delegate(".chkQuantitybyPrice", "change", function (e) {
    var price = $(this).val();
    var rowID = $(this).attr('data-id');
    $.ajax({
        url: base_url + '/compareStockQuantity/'+price,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.compareQuantity;
            var priceLen=data.cntAp;
            var product_id=data.product_id;
            if (rowID == '') {
                var product_id_c = $("#product_id-1").val(product_id);
                console.log("first=" +product_id);
            }
            else{
                var product_id_c = $("#product_id-"+rowID).val(product_id);
                console.log("second=" +product_id); 
            }
            var lengthPri = $("#cntPrice").val(priceLen);
            var qunPrice = $("#compareQuantity").val(result);
            $("#quantity-1").removeAttr("disabled", "disabled");
            $("#quantity-"+ rowID).removeAttr("disabled", "disabled");
        }
    });
    $(".subtotal").attr("disabled", "disabled");
    $('.hideTotPdt').hide();
});
//QUANTITY - calculation
$(document).delegate(".rfq_quantity", "change", function (e) {
    var quantity = $(this).val();
    console.log("id=" + quantity);
    var rowID = $(this).attr('data-id');
    var stock=$('#compareQuantity').val();
    var cntPriceLen=$('#cntPrice').val();
    console.log("compareQuantity=" + stock);
    console.log("cntPriceLen=" + cntPriceLen);

//Error Message for quantity and stock - scenario
                if (quantity != '') {
                    // if (stock > quantity) 
                    // {
                    //     var stockLeft = 'Stock is Available';
                    //     $.growl({
                    //         title: "",
                    //         message: stockLeft,
                    //         duration: "3000",
                    //         location: "tr",
                    //         style: "notice"
                    //     });
                    // }
                   // else{
                    if(cntPriceLen > 1 && stock < quantity)
                    {
                        var stockLeft = 'Out Of stock Please choose another price';
                        $.growl({
                            title: "",
                            message: stockLeft,
                            duration: "3000",
                            location: "tr",
                            style: "warning"
                        });
                    }
                    if(cntPriceLen == 1 && stock < quantity)
                    {
                        var stockLeft = 'Out Of stock';
                        $.growl({
                            title: "",
                            message: stockLeft,
                            duration: "3000",
                            location: "tr",
                            style: "error"
                        });
                    }
                 //}
                }
    if (rowID == '') {
        var qty = $('#quantity-1').val();
        var price = $('#actual_price-1').val();
        var r_price = price.replace("Rs.", "");
        var subTotal = parseInt(qty, 10) * parseFloat(r_price);
        $("#subtotal-1").val('Rs.' + subTotal.toFixed(2));
    }
    else {
        var qty = $('#quantity-' + rowID).val();
        var price = $('#actual_price-' + rowID).val();
        console.log("qty=" + qty);
        console.log("price=" + price);
        var r_price = price.replace("Rs.", "");
        var subTotal = parseInt(qty, 10) * parseFloat(r_price);
        $("#subtotal-" + rowID).val('Rs.' + subTotal.toFixed(2));
        console.log("subtotal=" + subTotal);
    }
    if (!isNaN(subTotal)) {
        $('.hideTotPdt').show();
        var grandTotal = 0;
        $(".subtotal").each(function () {
            var r_subtotal = $(this).val().replace("Rs.", "");
            var stval = parseFloat(r_subtotal);
            grandTotal += isNaN(stval) ? 0 : stval;
        });
        $('.grdtot').text('Rs. ' + grandTotal.toFixed(2));
    }
});
//END
//Proposal val
$('.proposed_val_change').on('input', function (e) {
    var grdtot = $('.grdtot').text();
    console.log("grdtot=" + grdtot);
    var labour_charge = $('#labour_charge').val();
    var transport_charge = $('#transport_charge').val();
    var margin = $('#margin').val();
    var r_gTotal = grdtot.replace("Rs.", "");
    var totalExpenses = parseFloat(r_gTotal) + parseFloat(labour_charge) + parseFloat(transport_charge);
    console.log("tExp=" + totalExpenses);
    var r_margin = margin.replace("%", "");
    var marginProposalVal = (r_margin / 100) * totalExpenses;
    var proposalVal = parseFloat(marginProposalVal) + parseFloat(totalExpenses);
    if (!isNaN(proposalVal)) {
        $('.hideProposalVal').show();
        $('.proposal_value').text('Rs.' + proposalVal.toFixed(2));
    }
});
//Final val
$(document).delegate(".final_val_change", "change", function (e) {
    var type = $('#discount_type').val();
    var proposalVal = $('.proposal_value').text();
    var r_proposalVal = proposalVal.replace("Rs.", "");
    console.log("f=" + r_proposalVal);
    var add_discount = $(this).val()

    if (type == 'Flat') {
        var final_value = (r_proposalVal - add_discount);
    }
    else {
        var r_add_discount = add_discount.replace("%", "");
        var disFinalValue = r_add_discount / 100 * r_proposalVal;
        var final_value = (r_proposalVal - disFinalValue);
    }
    if (!isNaN(final_value)) {
        $('.hideFinalVal').show();
        $('.final_value').text('Rs.' + final_value.toFixed(2));
        console.log("final_value=" + final_value);
    }
});
//Product name - get price,units
$(document).delegate(".rfq_Product_name", "change", function (e) {
    var product_code = $(this).val();
    console.log("id=" + product_code);
    var rowID = $(this).attr('data-id');
    console.log("countRows=" + rowID);
   

    if (rowID == '') {
        $('.load-mul-product1').html(loading_icon);
        $('.load-mul-product1').show();
        $("#quantity-1").attr("disabled", "disabled");
        $("#actual_price-1").attr("disabled", "disabled");
        $("#units-1").attr("disabled", "disabled");
        
    }
    else {
        $('.load-mul-product' + rowID).html(loading_icon);
        $('.load-mul-product' + rowID).show();
        $("#quantity-" + rowID).attr("disabled", "disabled");
        $("#actual_price-" + rowID).attr("disabled", "disabled");
        $("#units-" + rowID).attr("disabled", "disabled");
    }
    $(".subtotal").attr("disabled", "disabled");
    $('.hideTotPdt').hide();
    $.ajax({
        url: base_url + '/viewProductGridData/' + btoa(product_code),
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.allProducts;
            console.log("pdt=" + JSON.stringify(result));
            if (rowID == '') {
                $('.load-mul-product1').html("");
                $('.load-mul-product1').hide();
              //  $("#quantity-1").removeAttr("disabled", "disabled");
                $("#units-1").removeAttr("disabled", "disabled");
                $("#actual_price-1").removeAttr("disabled", "disabled");
                var actual_p = '';
                actual_p = actual_p + '<option value="">Select</option>';
                $.each(result, function (key, value) {
                    $('#units-1').val(value.units);
                    actual_p = actual_p + '<option value="' + value.actual_price + '">' + value.actual_price + '</option>';
                    actual_p = actual_p + '</option>';
                });
                $('#actual_price-1').html(actual_p);
            }
            else {
                $('.load-mul-product' + rowID).html("");
                $('.load-mul-product' + rowID).hide();
              //  $("#quantity-" + rowID).removeAttr("disabled", "disabled");
                $("#units-" + rowID).removeAttr("disabled", "disabled");
                $("#actual_price-" + rowID).removeAttr("disabled", "disabled");
                var actual_p = '';
                actual_p = actual_p + '<option value="">Select</option>';
                $.each(result, function (key, value) {
                    $('#units-' + rowID).val(value.units);
                    actual_p = actual_p + '<option value="' + value.actual_price + '">' + value.actual_price + '</option>';
                    actual_p = actual_p + '</option>';
                });
                
            }
            var priceLen=data.cntAp;
                var lengthPri = $("#cntPrice").val(priceLen);
                console.log("result=" +priceLen);
                $('#actual_price-' + rowID).html(actual_p);

        }
    });
});

//Add row - product grid
$(document).delegate("a.add-record", "click", function (e) {
    $('#editPreselectProducts').hide();
    e.preventDefault();
    var content = $('#pdt_table tr'),
        size = $('#tbl_pdts >tbody >tr').length + 1,
        element = null,
        element = content.clone();
    element.find('.rfq_Product_name').select2({
        filter: true
    })
    element.attr('id', 'rec-' + size);
    element.find('.load-mul-product').attr('class', 'load-mul-product' + size);
    $("#quantity-" + size).attr("disabled", "disabled");
    $("#actual_price-" + size).attr("disabled", "disabled");
    $("#units-" + size).attr("disabled", "disabled");
    element.find('#quantity-').attr('id', 'quantity-' + size);
    element.find('#units-').attr('id', 'units-' + size);
    element.find('#product_name-').attr('id', 'product_name-' + size);
    element.find('#product_id-').attr('id', 'product_id-' + size);
    element.find('#actual_price-').attr('id', 'actual_price-' + size);
    element.find('#subtotal-').attr('id', 'subtotal-' + size);
    element.find('.delete-record').attr('data-id', size);
    element.find('.rfq_Product_name').attr('data-id', size);
    element.find('.rfq_quantity').attr('data-id', size);
    element.find('.chkQuantitybyPrice').attr('data-id', size);
    element.appendTo('#tbl_pdts_body');
    element.find('.sn').html(size);
    var actual_p = '';
    actual_p = actual_p + '<option value="">Select</option>';
    $('#actual_price-'+ size).html(actual_p);
});

//DELETE Rcord in product grid data
$(document).delegate('a.delete-record', 'click', function () {
    var id = jQuery(this).attr('data-id');
    console.log("xx===" + id);

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
            var targetDiv = $(this).attr('targetDiv');
            var size = $('#tbl_pdts >tbody >tr').length;
            if (size > 1) {
                $('#rec-' + id).remove();
                console.log("rec=" + size);

            }
            else {
                $.growl({
                    title: "",
                    message: "Atleast only one product should be added",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
            }
            //regnerate index number on table
            $('#tbl_pdts_body tr').each(function (index) {
                //alert(index);
                $(this).find('span.sn').html(index + 1);
            });
            return true;
        }

    });

});

//To REset search Form
function RFQresetForm() {
    console.log("ID");
    $('#customer_name').val('');
    $('#contact_name').val('');
    $('#email').val('');
    $('#phone').val('');
    $('#from').val('');
    $('#to').val('');
}

//To Store data in RFQ and product
function createRFQ() {

    $('.is-invalid').removeClass('is-invalid');
    var data = {}
    data.customer_name = $('#customer_name').val();
    data.contact_name = $('#contact_name').val();
    data.email = $('#email').val();
    data.phone = $('#phone').val();
    data.address = $('#address').val();
    data.description = $('#description').val();
    data.quantity = $('#quantity-1').val();
    data.units = $('#units-1').val();
    data.grdtot = $('.grdtot').text();
    data.labour_charge = $('#labour_charge').val();
    data.transport_charge = $('#transport_charge').val();
    data.margin = $('#margin').val();
    data.proposed_value = $('.proposal_value').text();
    data.final_value = $('.final_value').text();
    data.discount_type = $('#discount_type').val();
    data.discount_value = $('#add_discount').val();
    if($('#amc').val()!=undefined)
    {
        data.amc = $('#amc').val();
    }
    else
    {
        data.amc =0;
    }
    data.rowLen = $('#tbl_pdts >tbody >tr').length;
    console.log("countRows=" + data.rowLen);
    data.mul_quantity = [];
    data.mul_pdt_name = [];
    data.mul_units = [];
    data.mul_actual_price = [];
    data.mul_subtotal = [];
    for (var i = 1; i <= data.rowLen; i++) {
        mul_pdt_name = $('#product_id-' + [i]).val();
        mul_quantity = $('#quantity-' + [i]).val();
        mul_units = $('#units-' + [i]).val();
        mul_actual_price = $('#actual_price-' + [i]).val();
        mul_subtotal = $('#subtotal-' + [i]).val();
        data.mul_quantity.push(mul_quantity);
        data.mul_pdt_name.push(mul_pdt_name);
        data.mul_units.push(mul_units);
        data.mul_actual_price.push(mul_actual_price);
        data.mul_subtotal.push(mul_subtotal);
    }
    console.log("qunatity" + data.mul_quantity);
    console.log("pdtname" + data.mul_pdt_name);
    //Validation
    var err = 0;
    if ($("#customer_name").val() == '') {
        $('#customer_name').addClass('is-invalid');
        err++;
    }
    if ($("#contact_name").val() == '') {
        $('#contact_name').addClass('is-invalid');
        err++;
    }
    if ($("#email").val() == '') {
        $('#email').addClass('is-invalid');
        err++;
    }
    if ($("#address").val() == '') {
        $('#address').addClass('is-invalid');
        err++;
    }
    if ($("#labour_charge").val() == '') {
        $('#labour_charge').addClass('is-invalid');
        err++;
    }
    if ($("#transport_charge").val() == '') {
        $('#transport_charge').addClass('is-invalid');
        err++;
    }
    if ($("#margin").val() == '') {
        $('#margin').addClass('is-invalid');
        err++;
    }
    if ($("#address").val() == '') {
        $('#address').addClass('is-invalid');
        err++;
    }


    if ($("#quantity-1").val() == '') {
        $('#quantity-1').addClass('is-invalid');
        err++;
    }
    if ($("#product_name-1").val() == '') {
        $('#product_name-1').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
        console.log("RFQ" + JSON.stringify(data));
        console.log("mul_quantity" + JSON.stringify(mul_quantity));
        $('.RFQSave').hide();
        $('#load-RFQ').html(loading_icon);
        $('.is-invalid').removeClass('is-invalid');
    }
    data.id = $('#editRFQID').val();
    data.editDis = $('#editDis').val();
    data.lead_id = $('#lead_id').val();
    console.log("data.lead_id" + data.lead_id);
    $.ajax({
        url: base_url + '/storeRFQ',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "RFQ has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/showRFQ';
                }, 2000);
            } else if (data.status == 3) { //name exist already
                $.growl({
                    title: "",
                    message: "Entered Email already exist",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#product_name').addClass('is-invalid');
                $('.RFQSave').show();
                $('#load-RFQ').html('');
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.RFQSave').show();
                $('#load-RFQ').html('');
            }
        }
    });
}
//View Single Product
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
$(document).on("click", "#viewSingleRFQ", function (e) {
    console.log("GOOD");
    $('.load-view-singleRFQ').show();
    $('.load-view-singleRFQ').html(loading_icon);
    var id = $(this).data('id');
    console.log("id=" + id);
    $("#viewProduct").modal("show");
    var title = 'View Product ';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/viewSingleRFQ/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var RFQProducts = data.RFQProducts;
            var RFQList = data.RFQList;
            var rows = '';
            $('.load-view-singleRFQ').hide();
            $('.hideForm').show();
            $('.showBusinessName').text(RFQList.customer_name);
            $('#popup_customer_name').text(RFQList.customer_name);
            $('#popup_contact_name').text(RFQList.contact_name);
            $('#popup_email').text(RFQList.email);
            $('#popup_discount_value').text(RFQList.discount_value);
            $('#popup_amc').text(RFQList.amc);
            $('#popup_phone').text(RFQList.phone);
            $('#address').text(RFQList.address);
            $('#description').text(RFQList.description);
            $('#lastTrakedComment').text(RFQList.last_tracked_comment);
            var lastTrackedDate = formatDate(RFQList.last_tracked_date);
            $('#lastTrackedDate').text(lastTrackedDate);
            rows = rows + '<table class="table table-striped table-bordered text-nowrap w-100">';
            rows = rows + '<thead><tr><th class="wd-35p lightBlue">Product Name</th>';
            rows = rows + '<th class="wd-35p lightBlue">Quantity</th>';
            rows = rows + '<th class="wd-35p lightBlue">Units</th>';
            rows = rows + '<th class="wd-35p lightBlue">Actual Price</th>';
            rows = rows + '<th class="wd-35p lightBlue">Subtotal</th>';
            rows = rows + '</tr></thead><tbody>';
            $.each(RFQProducts, function (key, value) {
                rows = rows + '<tr>';
                rows = rows + '<td>' + value.product_name + '</td>';
                rows = rows + '<td>' + value.quantity + '</td>';
                rows = rows + '<td>' + value.units + '</td>';
                rows = rows + '<td>' + value.actual_price + '</td>';
                rows = rows + '<td>' + value.subtotal + '</td>';
                rows = rows + '</tr>';
            });
            rows = rows + '</tbody></table>';

            $("div.row.viewMultiplePdts").html(rows);

            $('.load-view-singleRFQ').html('');
            console.log("ss" + JSON.stringify(RFQList));
            console.log("RFQProducts" + JSON.stringify(RFQProducts));
        }
    });

});

//DELETE RFQ
$(document).on("click", "#confirmRFQDelete", function (e) {
    console.log("DELETE");
    var id = $(this).data('id');
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
            deleteRFQ(id);
        }
    });
});

function deleteRFQ(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.delrfq' + id).html(loading_icon);
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
    console.log("data12=" + JSON.stringify(data));

    $.ajax({
        url: base_url + '/RFQsearchResults',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            console.log("RESULT=" + JSON.stringify(data.allRFQs));
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


                    console.log(formattedDate);
                    var pg = host + '/edit-RFQ/' + btoa(pt.id);
                    rows = rows + '<tr">';
                    rows = rows + '<td>' + pt.customer_name + '</td>';
                    rows = rows + '<td>' + pt.contact_name + '</td>';
                    rows = rows + '<td>' + pt.email + '</td>';
                    rows = rows + '<td>' + pt.proposed_value + '</td>';
                    rows = rows + '<td>' + pt.final_value + '</td>';
                    rows = rows + '<td>' + last_tracked_date + '</td>';
                    rows = rows + '<td>' + formattedDate + '</td>';
                    rows = rows + '<td><a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0 getRFQname" data-toggle="modal" id="viewSingleRFQ" data-target="#viewRFQ" data-id="' + btoa(pt.id) + '" data-RFQName="' + pt.customer_name + '"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="' + pg + '" class="ubtn' + btoa(pt.id) + ' btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip" id="editSingleRFQ" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp; <a id="confirmRFQDelete" data-id="' + btoa(pt.id) + '"class="ubtn' + btoa(pt.id) + ' btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;<span class="delrfq' + btoa(pt.id) + '"></span>'; '</td>';
                    rows = rows + '</tr>';
                });
            }
            $('#showRFQs').html(rows);

        }
    });
}

