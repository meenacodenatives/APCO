var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var host = window.location.host;

$('.closeModal').click(function () {
    $('#viewProduct').modal("hide");
});
$('#pdtSearch').click(function () {
    $('#searchForm').toggle();
});
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
function resetForm() {
    $('#category').val('');
    $('#select2-category-container').text('Select');
    $('#searchProduct_name').val('');
    $('#select2-searchProduct_name-container').text('Select');
    $('#product_type').val('');
    $('#mfg_date').val('');
    $('#expiry_date').val('');
    $('#actual_price').val('');

}
$(function () {

    $('.mfg_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2019:+10'   //Current Year -10 to Current Year + 10.
        //yearRange: '+0:+10'    //Current Year to Current Year + 10.
        //yearRange: '1900:+0'   //Year 1900 to Current Year.
        //yearRange: '1985:2025' //Year 1985 to Year 2025.
        //yearRange: '-0:+0'     //Only Current Year.
        //yearRange: '2025' //Only Year 2025.
    });
    $('.expiry_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '2021:+10'   //Current Year -10 to Current Year + 10.
        //yearRange: '+0:+10'    //Current Year to Current Year + 10.
        //yearRange: '1900:+0'   //Year 1900 to Current Year.
        //yearRange: '1985:2025' //Year 1985 to Year 2025.
        //yearRange: '-0:+0'     //Only Current Year.
        //yearRange: '2025' //Only Year 2025.
    });

});
function createProduct() {
    var data = {}
    data.category = $('#category').val();
    data.quantity = $('#quantity').val();
    data.product_code = $('#product_code').val();
    data.actual_price = $('#actual_price').val();
    data.product_name = $('#product_name').val();
    data.units = $('#units').val();
    data.mfg_date = $('#mfg_date').val();
    data.selling_price = $('#selling_price1').val();
    data.selling_price2 = $('#selling_price2').val();
    data.selling_price3 = $('#selling_price3').val();
    data.product_type = $('#product_type').val();
    data.batch_number = $('#batch_number').val();
    data.expiry_date = $('#expiry_date').val();
    data.gst = $('#gst').val();
    data.id = $('#editPdtID').val();
    $('.is-invalid').removeClass('is-invalid');
    //Validation
    var err = 0;
    if ($("#category").val() == '') {
        $('#category').addClass('is-invalid');
        err++;
    }
    if ($("#quantity").val() == '') {
        $('#quantity').addClass('is-invalid');
        err++;
    }
    if ($("#product_code").val() == '') {
        $('#product_code').addClass('is-invalid');
        err++;
    }
    if ($("#actual_price").val() == '') {
        $('#actual_price').addClass('is-invalid');
        err++;
    }
    if ($("#product_name").val() == '') {
        $('#product_name').addClass('is-invalid');
        err++;
    }
    if ($("#units").val() == '') {
        $('#units').addClass('is-invalid');
        err++;
    }
    if ($("#mfg_date").val() == '') {
        $('#mfg_date').addClass('is-invalid');
        err++;
    }
    if ($("#selling_price").val() == '') {
        $('#selling_price').addClass('is-invalid');
        err++;
    }
    if ($("#product_type").val() == '') {
        $('#product_type').addClass('is-invalid');
        err++;
    }
    if ($("#batch_number").val() == '') {
        $('#batch_number').addClass('is-invalid');
        err++;
    }
    if ($("#expiry_date").val() == '') {
        $('#expiry_date').addClass('is-invalid');
        err++;
    }
    if ($("#gst").val() == '') {
        $('#gst').addClass('is-invalid');
        err++;
    }


    if (err > 0) {
        return false;
    } else {
       $('.productSave').hide();
       $('#load-product').html(loading_icon);
    }
    $.ajax({
        url: base_url + '/chkProductPrice',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 2) { //success login
                
                swal({
                    title: "",
                    text: "Do you want to add product with different price ",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    //confirmButtonColor: '#DD6B55',
                    cancelButtonText: 'Cancel'
                }, function (isConfirm) {
                    if (isConfirm) {
                       addProduct();
                    }
                    else
                    {
                        $('.productSave').show();
                        $('#load-product').html('');
                    }
                });
            } else if (data.status == 3) { //name exist already
                $.growl({
                    title: "",
                    message: "Already Entered product has been added with same price",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#product_name').addClass('is-invalid');
                $('#actual_price').addClass('is-invalid');
                $('#product_code').addClass('is-invalid');
                $('.productSave').show();
                $('#load-product').html('');
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.productSave').show();
                $('#load-product').html('');
            }
        }

    });
}
//Start of add product
function addProduct() {
    var data = {}
    data.category = $('#category').val();
    data.quantity = $('#quantity').val();
    data.product_code = $('#product_code').val();
    data.actual_price = $('#actual_price').val();
    data.product_name = $('#product_name').val();
    data.units = $('#units').val();
    data.mfg_date = $('#mfg_date').val();
    data.selling_price = $('#selling_price1').val();
    data.selling_price2 = $('#selling_price2').val();
    data.selling_price3 = $('#selling_price3').val();
    data.product_type = $('#product_type').val();
    data.batch_number = $('#batch_number').val();
    data.expiry_date = $('#expiry_date').val();
    data.gst = $('#gst').val();
    data.id = $('#editPdtID').val();
    $('.productSave').hide();
                $('#load-product').html(loading_icon);
    $.ajax({
        url: base_url + '/storeProduct',
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
                    message: "Product has been added successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/showProduct';
                }, 1000);
            }
        }
    });
}
//END OF Add Product
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
$(document).on("click", "#viewSingleProduct", function (e) {
    $('.load-edit-product').show();
    $('.load-edit-product').html(loading_icon);
    var id = $(this).data('id');
    $("#viewProduct").modal("show");
    var title = 'View Product ';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/viewSingleproduct/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.allProducts[0];
            $('.load-edit-product').hide();
            $('.hideForm').show();
            $('#cat_id').text(result.name);
            $('#productCode').text(result.product_code);
            $('#batchNumber').text(result.batch_number);
            $('#actualPrice').text(result.actual_price);
            $('#productName').text(result.product_name);
            var mfdDate = formatDate(result.mfg_date);
            $('#mfgDate').text(mfdDate);
            var expDate = formatDate(result.expiry_date);
            $('#expiryDate').text(expDate);
            $('#sellingPrice').text(result.selling_price);
            $('#productType').text(result.product_type);
            $('#units').text(result.units);
            $('#gst').text(result.gst);
            $('#quantity').text(result.quantity);
            $('.load-edit-product').html('');
        }
    });

});
//DELETE PRODUCT

$(document).on("click", "#confirmPdtDelete", function (e) {

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
            deleteProduct(id);
        }
    });
});

function deleteProduct(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.delpdt' + id).html(loading_icon);
    $.ajax({
        url: base_url + '/delete-product',
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
                    message: "Product has been deleted successfully",
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

function searchProduct() {
    $('.load-search-product').show();
    $('.load-search-product').html(loading_icon);
    $('.searchpdt').hide(); //Button name
    $('#hidePdt').hide(); //all products div
    var data = {}
    data.category = $('#category').val();
    data.actual_price = $('#actual_price').val();
    data.product_name = $('#searchProduct_name').val();
    data.mfg_date = $('#mfg_date').val();
    data.expiry_date = $('#expiry_date').val();
    data.product_type = $('#product_type').val();
    $.ajax({
        url: base_url + '/searchResults',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            $('#hidePdt').hide();
            $('#showPdt').show();
            $('.searchpdt').show();
            $('.load-search-product').hide();
            $('.load-search-product').html('');
            var rows = '';
            if (data.allProducts == '') {
                rows = rows + '<tr">';
                rows = rows + '<td colspan="8" class="span12 text-center">No Products Found</td>';
                rows = rows + '</tr>';
            }
            else
            {
            $.each(data.allProducts, function (key, pt) {
                var formattedDate=formatDate(pt.created_at);
                var pg=host+'/edit-product/'+btoa(pt.id);
                rows = rows + '<tr">';
                rows = rows + '<td>' + pt.name + '</td>';
                rows = rows + '<td>' + pt.product_name + '</td>';
                rows = rows + '<td>' + pt.product_code + '</td>';
                rows = rows + '<td>' + pt.product_type + '</td>';
                rows = rows + '<td>' + pt.quantity + '</td>';
                rows = rows + '<td>' + pt.units + '</td>';
                rows = rows + '<td>' + formattedDate + '</td>';
                rows = rows + '<td><a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0" data-toggle="modal" id="viewSingleProduct" data-target="#viewProduct" data-id='+pt.id+'><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="'+pg+'" class="ubtn'+pt.id+'btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id="confirmPdtDelete" data-id='+pt.id+' class="ubtn'+pt.id+' btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp; <span class="delpdt'+pt.id+'"></span>';
                '</td>';
                rows = rows + '</tr>';
            });
        }
            $('#showPdt').html(rows);

        }
    });
}