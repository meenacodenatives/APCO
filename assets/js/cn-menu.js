var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
$('#menuPopup').click(function() {
    $('.showTitle').text('New Menu');
    $('#menuName').val('');
    $('#menuLink').val('');
    $('#pMenu').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.users-invalid').removeClass('users-invalid');
});

$('.closeModal').click(function(){
    $('#addMenu').modal("hide");
});
//Create Menu
function createMenu() {
    var data = {}
    data.menuName = $('#menuName').val();
    data.pMenu = $('#pMenu').val();
    data.menuLink = $('#menuLink').val();
    data.id=$('#menu_id').val();
    console.log("id==" + data.id);

    $('.is-invalid').removeClass('is-invalid');
    //Validation
    var err = 0;
    if ($("#menuName").val() == '') {
        $('#menuName').addClass('is-invalid');
        err++;
    }
    
    if ($("#menuLink").val() == '') {
        $('#menuLink').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
        $('.menuSave').hide();
        $('#load-Menu').html(loading_icon);
    }

    $.ajax({
        url: base_url + '/storeMenu',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function(data) {
            $("#addMenu").modal("hide");
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Menu has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    window.location.href = base_url + '/showMenu';
                }, 1000);
            } else if (data.status == 3) { //Menu Name already exist
                $.growl({
                    title: "",
                    message: "Entered Menu Name already exist",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#menuName').addClass('is-invalid');
                $('.menuSave').show();
                $('#load-Menu').html('');
            }else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.menuSave').show();
                $('#load-Menu').html('');
            }
        }

    });
}
//Edit Menu
$(document).on("click", "#confirmMenuEdit", function(e) {
    $('.load-edit-Menu').show();
    $('.load-edit-Menu').html(loading_icon);
    var id = $(this).data('id');
    $("#addMenu").modal("show");
    var title = 'Edit Menu';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/edit-menu/' +id,
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            var result = data.menu;
            $('.load-edit-Menu').hide();
            $('.hideForm').show();
                $('#menu_id').val(result.id);
                $("#menuName").val(result.menu_name);
                $("#menuLink").val(result.menu_link);
                $("#pMenu").val(result.menu_parent);
                $('.menuSave').show();
                $('.load-edit-Menu').html('');
        }
    });

});
//DELETE Menu

$(document).on("click", "#confirmMenuDelete", function(e) {

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
            deleteMenu(id);
        }
    });
});

function deleteMenu(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.delmenu' + id).html(loading_icon);
    $('.menuSave').hide();

    $.ajax({
        url: base_url + '/delete-menu',
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
                    message: "Menu has been deleted successfully",
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
//END OF DELETE Menu

