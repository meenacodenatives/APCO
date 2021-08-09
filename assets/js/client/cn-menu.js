var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var host = window.location.host;
$(function () {
    $('#load-sidebar').html(loading_icon);
    $.ajax({
        url: base_url + '/showSidebar',
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            $('#load-sidebar').html('');
            $('#load-sidebar').hide();
            var parentresult = data.MenuList;
            var menuList = '';
            $.each(parentresult, function (key, value) {
                var pg = base_urlvalue.menu_link;
                if(value.menu_parent==0)
                {
                menuList = menuList + '<li>';
                menuList = menuList +'<a class="side-menu__item" href="' + pg + '">';
                menuList = menuList +'<i class="'+ value.menu_icon +'"></i> &nbsp;&nbsp;';
                menuList = menuList + value.menu_name;
                menuList = menuList +'</a>';
                menuList = menuList + '</li>';
                }
                else
                {
                menuList = menuList + '<li class="slide">';
                menuList = menuList +'<a class="side-menu__item" href="' + pg + '">';
                menuList = menuList +'<i class="'+ value.menu_icon +'"></i> &nbsp;&nbsp;';
                menuList = menuList + '<span class="side-menu__label">'+ value.menu_name +'</span>';
                menuList = menuList +'</a>';
                menuList = menuList + '</li>';
                }
            });
            $('#showChildMenu').html(menuList);
        }
    });
    $('#pMenu').select2({
        filter: true
    })
    });
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

function savemenuUsers()
{
    var data = {}
    data.menu_id = $('#menuID').val();
    data.id=$('#menuID').val();
    var user_id = [];
    $.each($("input[name='user_id']:checked"), function () {
        user_id.push($(this).val());
    });
    data.user_id = user_id;
    console.log("user_id="+user_id);
    $('.is-invalid').removeClass('is-invalid');
    //Validation
    var err = 0;
    if ($("#user_id").val() == '') {
        $('#user_id').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
        $('.menuUsersSave').hide();
        $('#load-menuUsers').html(loading_icon);
    }
    $.ajax({
        url: base_url + '/storeMenuUsers',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            $("#showUsers").modal("hide");
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Menu Users has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/showMenu';
                }, 1000);
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.menuUsersSave').show();
                $('#load-menuUsers').html('');
            }
        }
    });
}
//Create Menu
function createMenu() {
    var data = {}
    data.menuName = $('#menuName').val();
    data.controllerName = $('#controllerName').val();
    data.pMenu = $('#pMenu').val();
    data.menuLink = $('#menuLink').val();
    data.id=$('#menu_id').val();
    console.log("data==" +JSON.stringify(data));

    $('.is-invalid').removeClass('is-invalid');
    //Validation
    var err = 0;
    if ($("#menuName").val() == '') {
        $('#menuName').addClass('is-invalid');
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
$(document).on("click", "#confirmMenuAssignUser", function (e) {
    $('.load-edit-Menu').show();
    $('.load-edit-Menu').html(loading_icon);
    var id = $(this).data('id');
    $("#showUsers").modal("show");
    var title = 'Edit Users Group';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/edit-menu/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.menu;
            $('.load-edit-Menu').hide();
            $('.hideForm').show();
            $("#menuID").val(result.id);
            var userRes = data.res;
            var allUsers =data.all;
            var userIDList = '';
            userIDList = userIDList + '<table class="table  text-nowrap w-70">';
            $.each(allUsers, function (index, value) { //All 3 tables -user_group_map,user_category,user_profile
                var fullname = value.fullname.split('|');
                var user_p_id = value.user_p_id.split('|');
                userIDList = userIDList + '<tr>';
                userIDList = userIDList + '<td>';
                userIDList = userIDList + value.category_name;
                userIDList = userIDList + '</td>';
                userIDList = userIDList + '</tr>';
                userIDList = userIDList + '<tr>';
                for (var k=0;k<data.res.length;k++) {
                    console.log("indi"+userRes[k].user_p_id);
                    if (user_p_id == userRes[k].user_p_id) {
                        var checked = 'checked';
                    }
                }
                for (var i = 0; i < user_p_id.length; i++) {
                    userIDList = userIDList + '<td class="border border-dark">';
                    userIDList = userIDList + ' <input type="checkbox" name="user_id" value="' + value.cat_id + '_' + user_p_id[i] + '" id="user_id" ' + checked + '>&nbsp;';
                    for (var j = 0; j < fullname.length; j++) {
                        if(i==j)
                    {
                            userIDList = userIDList + fullname[j];
                    }
                    }
                    userIDList = userIDList + '</td>';
                }
                userIDList = userIDList + '</tr>';
            });
            userIDList = userIDList + '</table>';
            $('#showchkBoxes').html(userIDList);
            $('#hidechkBoxes').hide();
            $('#showchkBoxes').show();
            $('.menuUsersSave').show();
            $('.load-edit-Menu').html('');
        }
    });
});
//Edit Menu
$(document).on("click", "#confirmMenuEdit", function(e) {
   
    $('.load-edit-Menu').show();
    $('.load-edit-Menu').html(loading_icon);
    var id = $(this).data('id');
    $("#addMenu").modal("show");
    var title = 'Edit Menu';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $('#hideparentMenuList').hide();

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
                $("#controllerName").val(result.menu_controller);
                $("#menuLink").val(result.menu_link);
                var parentMenuList=data.parentMenu;
                console.log("parentMenuList"+JSON.stringify(parentMenuList));
                var parentIDList = '';
                parentIDList = parentIDList + '<label class="form-label">Parent Menu</label>';
                parentIDList = parentIDList + '<select name="pMenu" id="pMenu" class="form-control" style="width: 360px;">';
                parentIDList = parentIDList +'<option value="">Select</option>';
                $.each(parentMenuList, function (index, value) {
                    if (value.id == result.menu_parent) {
                        var selected = 'selected';
                    }
                parentIDList = parentIDList + '<option value="' + value.id + '" '+selected+'>' + value.menu_name + '</option>';
             });
             parentIDList = parentIDList +'</select>';
                $('#showEditParentList').html(parentIDList);
                $('#showEditParentList').show();
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

