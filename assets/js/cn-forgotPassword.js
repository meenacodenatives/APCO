var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var regex_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;//email validation regexp
//URL Validation
function sendPassword() {
    var data = {}
    data.email = $('#userEmail').val();
    data.id = 0;

    $('.is-invalid').removeClass('is-invalid');
    var err = 0;
    if ($("#userEmail").val() == '') {
        $('#userEmail').addClass('is-invalid');
        err++;
    }
    if (data.email != '') {
        if (!regex_email.test(data.email)) {
            $('#userEmail').addClass('is-invalid');
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
    if (err > 0) {
        return false;
    }
    $('#f_send').hide();
    $('#load-fPwd').html(loading_icon);

    $.ajax({
       url: base_url + '/forgot-password',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            if (data.status.value == 1) { //success login
                $.growl({
                    title: "",
                    message: "Email has been sent to your registered email id",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/change-password/'+data.status.secret_key;
                }, 2000);
            }
            else if (data.status == 2) { //Email exist already
                $.growl({
                    title: "",
                    message: "Entered Email ID does not exist",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#userEmail').addClass('is-invalid');
                $('#f_send').show();
                $('#load-fPwd').html('');
            } 
            else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.ebtn').show();
                $('#load-fPwd').html('');
            }
        }
    });
}

