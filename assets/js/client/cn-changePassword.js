var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var regex_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;//email validation regexp
function sendNewPassword() {
    var data = {}
    data.password = $('#newPwd').val();
    data.secret_key=$('#secret_key').val();
    data.id=0;
   // data.confirmPassword = $('#confirmPwd').val();
    $('.is-invalid').removeClass('is-invalid');
    var err = 0;
    if ($("#newPwd").val() == '') {
        $('#newPwd').addClass('is-invalid');
        err++;
    }
    if ($("#confirmPwd").val() == '') {
        $('#confirmPwd').addClass('is-invalid');
        err++;
    }
    if ($("#confirmPwd").val() != data.password ) {
        $('#confirmPwd').addClass('is-invalid');
        $.growl({
            title: "",
            message: "Password and Confirm Password should be the same",
            duration: "3000",
            location: "tr",
            style: "error"
        });
        err++;
    }
    if (err > 0) {
        return false;
    }
    else
    {
    $('#c_send').hide();
    $('#load-cPwd').html(loading_icon);
    }
    console.log("test"+JSON.stringify(data));

    $.ajax({
       url: base_url + '/update-password',
        type: 'POST',
        data: { _token: CSRF_TOKEN, data: data },
        dataType: 'JSON',
        success: function (data) {
            console.log("data"+JSON.stringify(data)); 
            if (data.status == 1) { //success 
                $.growl({
                    title: "",
                    message: "Email has been sent to your registered email id",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/login';
                }, 2000);
            }
            else if (data.status == 2) { //Email exist already
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#newPwd').addClass('is-invalid');
                $('#c_send').show();
                $('#load-cPwd').html('');
            } 
            else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#c_send').show();
                $('#load-cPwd').html('');
            }
        }
    });
}

