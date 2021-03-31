var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var regex_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;//email validation regexp
function login() {
    var data = {}
    data.email = $('#lemail').val();
    data.password = $('#lpassword').val();
    $('.is-invalid').removeClass('is-invalid');
    var err = 0;
    if ($("#lemail").val() == '') {
        $('#lemail').addClass('is-invalid');
        err++;
    }
    if (data.email != '') {
        if (!regex_email.test(data.email)) {
            $('#lemail').addClass('is-invalid');
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
    if ($("#lpassword").val() == '') {
        $('#lpassword').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    }
    $('.lbtn').hide();
    $('#load-login').html(loading_icon);
    $.ajax({
        url: base_url + '/validate-login',
        type: 'POST',
        data: {_token: CSRF_TOKEN, data: data},
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Logging in...",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/dashboard';
                }, 2000);
            } else if (data.status == 0) { //incorrect credentials
                $.growl({
                    title: "",
                    message: "Invalid Credentials!",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.lbtn').show();
                $('#load-login').html('');
            } else if (data.status == 2) { //inactive
                $.growl({
                    title: "",
                    message: "Your account has been disabled! Please contact administration.",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.lbtn').show();
                $('#load-login').html('');
            } else if (data.status == 3) { //blocked
                $.growl({
                    title: "",
                    message: "Your account has been blocked! Please contact administration.",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.lbtn').show();
                $('#load-login').html('');
            }
        }
    });
}

$(function () {
    $('.dob,.doj,.dor').datepicker({
        showOtherMonths: true,
        changeYear: true,
        changeMonth: true,
        selectOtherMonths: true,
        yearRange: '1950:2020',
        dateFormat: 'yy-mm-dd',
        defaultDate: new Date(),
        maxDate: new Date()
    });

    if ($('#dropdownTrigger').val() == 1) { //trigger location for country in user profile edit
        getLocation($('#country').val(), 'edituser');
    }

    $('#country').change(function () {
        getLocation(this.value, 'adduser');
    });
});

function getLocation(country, type) {
    var data = {}
    data.country = country;
    $('.location').hide();
    $('.load-location').show();
    $('.load-location').html(loading_icon);
    $.ajax({
        url: base_url + '/get-country-location',
        type: 'POST',
        data: {_token: CSRF_TOKEN, data: data},
        dataType: 'HTML',
        success: function (data) {
            $('.location').show();
            $('.load-location').hide();
            if (data != 0) { //success 
                $('#location').html(data);
                if (type == 'edituser') {
                    $('#location').val($('#editLocation').val());
                }
            } else { //incorrect credentials
                $('#location').html('<option value="">Select</option>');
            }
        }
    });
}

function saveEmployee() {
    var data = {}
    data.fname = $('#fname').val();
    data.lname = $('#lname').val();
    data.email = $('#email').val();
    data.phone = $('#phone').val();
    data.dob = $('#dob').val();
    data.gender = $('#gender').val();
    data.address = $('#address').val();
    data.country = $('#country').val();
    data.location = $('#location').val();
    data.category = $('#category').val();
    data.status = $('#status').val();
    data.doj = $('#doj').val();
    data.dor = $('#dor').val();
    data.relieve = $('#relieve').val();
    data.password = $('#password').val();
    data.cpassword = $('#cpassword').val();
    data.id = $('#user_id').val();

    $('.is-invalid').removeClass('is-invalid');
    var err = 0;
    if (data.fname == '') {
        $('#fname').addClass('is-invalid');
        err++;
    }
    if (data.lname == '') {
        $('#lname').addClass('is-invalid');
        err++;
    }
    if (data.email == '') {
        $('#email').addClass('is-invalid');
        err++;
    }
    if (data.email != '') {
        if (!regex_email.test(data.email)) {
            $('#email').addClass('is-invalid');
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
    if (data.phone == '') {
        $('#phone').addClass('is-invalid');
        err++;
    }
    if (data.dob == '') {
        $('#dob').addClass('is-invalid');
        err++;
    }
    if (data.gender == '') {
        $('#gender').addClass('is-invalid');
        err++;
    }
    if (data.address == '') {
        $('#address').addClass('is-invalid');
        err++;
    }
    if (data.country == '') {
        $('#country').addClass('is-invalid');
        err++;
    }
    if (data.location == '') {
        $('#location').addClass('is-invalid');
        err++;
    }
    if (data.category == '') {
        $('#category').addClass('is-invalid');
        err++;
    }
    if (data.status == '') {
        $('#status').addClass('is-invalid');
        err++;
    }
    if (data.doj == '') {
        $('#doj').addClass('is-invalid');
        err++;
    }
    if (data.dor != '') {
        if (data.relieve == '') {
            $('#relieve').addClass('is-invalid');
            err++;
        }

    }

    if (data.id == '0') {
        if (data.password == '') {
            $('#password').addClass('is-invalid');
            err++;
        }
        if (data.cpassword == '') {
            $('#cpassword').addClass('is-invalid');
            err++;
        }
    }


    if (data.cpassword != data.password) {
        $.growl({
            title: "",
            message: "Password and confirm password should be same",
            duration: "2000",
            location: "tr",
            style: "error"
        });
        $('#password,#cpassword').addClass('is-invalid');
        err++;
    }

    if (err > 0) {
        return false;
    }
    $('.ebtn').hide();
    $('#load-employee').html(loading_icon);
    $.ajax({
        url: base_url + '/save-employee',
        type: 'POST',
        data: {_token: CSRF_TOKEN, data: data},
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) { //success save
                $.growl({
                    title: "",
                    message: "Employee has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/employees';
                }, 2000);
            } else if (data.status == 3) { //Email exist already
                $.growl({
                    title: "",
                    message: "Entered email already exist",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#email').addClass('is-invalid');
                $('.ebtn').show();
                $('#load-employee').html('');
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.ebtn').show();
                $('#load-employee').html('');
            }
        }
    });
}

$(document).on("click", "#empConfirmUserDelete", function (e) {
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
            deleteUser(id);
        }
    });
});


function deleteUser(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.deluser' + id).html(loading_icon);
    $.ajax({
        url: base_url + '/delete-employee',
        type: 'POST',
        data: {_token: CSRF_TOKEN, data: data},
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 1) {
                $.growl({
                    title: "",
                    message: "Employee has been deleted successfully",
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
