var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var regex_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/; //email validation regexp
var regex_website = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
//Customer - Create and edit 
function createCustomer() {
    var data = {}

    data.location = $('#location-dropdown').val();
    
    data.id = $('#customer_id').val();

    $('.is-invalid').removeClass('is-invalid');
    var err = 0;

    
    if ($("#location-dropdown").val() == '') {
        $('#location-dropdown').addClass('is-invalid');
        err++;
    }
    
    if (err > 0) {
        return false;
    }
    $('.ebtn').hide();
    $('#load-customer').html(loading_icon);

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
                    window.location.href = base_url + '/customers';
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