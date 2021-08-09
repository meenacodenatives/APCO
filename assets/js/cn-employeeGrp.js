var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
var host = window.location.host;

$('#empGrpPopup').click(function () {
    $('.showTitle').text('New Employees Group');
    $('#menuName').val('');
    $('#menuLink').val('');
    $('#pMenu').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.users-invalid').removeClass('users-invalid');
});

$('.closeModal').click(function () {
    $('#addempGrp').modal("hide");
    $('#showUsers').modal("hide");
});

function saveempGrpUsers() {
    var data = {}
    data.group_id = $('#grpID').val();
    data.id = $('#emp_group_id').val();
    var user_id = [];
    $.each($("input[name='user_id']:checked"), function () {
        user_id.push($(this).val());
    });
    data.user_id = user_id;
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
        $('.empGrpUsersSave').hide();
        $('#load-empGrpUsers').html(loading_icon);
    }
    console.log("data=" + JSON.stringify(data));

    $.ajax({
        url: base_url + '/storeEmpGroupUsers',
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
                    message: "Employees Group Users has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function () {
                    window.location.href = base_url + '/showEmployeesGroup';
                }, 1000);
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.empGrpUsersSave').show();
                $('#load-empGrpUsers').html('');
            }
        }
    });
}
//Create employeeGrp
function createempGrp() {
    var data = {}
    data.groupName = $('#groupName').val();
    data.groupCode = $('#groupCode').val();
    data.id = $('#emp_group_id').val();
    console.log("id==" + data.id);

    $('.is-invalid').removeClass('is-invalid');
    //Validation
    var err = 0;
    if ($("#groupName").val() == '') {
        $('#groupName').addClass('is-invalid');
        err++;
    }
    if (err > 0) {
        return false;
    } else {
        $('.empGrpSave').hide();
        $('#load-empGrp').html(loading_icon);
    }

    $.ajax({
        url: base_url + '/storeEmpGroup',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function (data) {
            $("#addempGrp").modal("hide");
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Employees Group has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                // setTimeout(function() {
                //     window.location.href = base_url + '/showEmployeesGroup';
                // }, 1000);
                $("#showUsers").modal("show");
                $("#grpID").val(data.grpID);
            } else if (data.status == 3) { //EmployeesGroup already exist
                $.growl({
                    title: "",
                    message: "Entered Employees Group already exist",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#groupName').addClass('is-invalid');
                $('.empGrpSave').show();
                $('#load-empGrp').html('');
            } else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.empGrpSave').show();
                $('#load-empGrp').html('');
            }
        }

    });
}
$(document).on("click", "#confirmEmpGroupAssignUser", function (e) {
    $('.load-edit-EmpGroup').show();
    $('.load-edit-EmpGroup').html(loading_icon);
    var id = $(this).data('id');
    $("#showUsers").modal("show");
    var title = 'Edit Employees Users Group';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/edit-EmpGroup/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.employee;
            $('.load-edit-EmpGroup').hide();
            $('.hideForm').show();
            $("#grpID").val(result.id);
            $('#emp_group_id').val(result.id);
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
                for (var i=0;i<data.res.length;i++) {
                    if (value.user_p_id == userRes[i].user_p_id) {
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
                    if (i % 3 == 0) {
                        userIDList =userIDList + '</tr>';
                    }
                }
            });
            userIDList = userIDList + '</table>';
            $('#showchkBoxes').html(userIDList);
            $('#hidechkBoxes').hide();
            $('#showchkBoxes').show();
            $("#groupName").val(result.group_name);
            $("#groupCode").val(result.group_code);
            $('.empGrpSave').show();
            $('.load-edit-EmpGroup').html('');
        }
    });
});
//Edit EmpGroup
$(document).on("click", "#confirmEmpGroupEdit", function (e) {
    $('.load-edit-EmpGroup').show();
    $('.load-edit-EmpGroup').html(loading_icon);
    var id = $(this).data('id');
    $("#addempGrp").modal("show");
    var title = 'Edit Employees Group';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/edit-EmpGroup/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            var result = data.employee;
            $('.load-edit-EmpGroup').hide();
            $('.hideForm').show();
            $('#emp_group_id').val(result.id);
            $("#grpID").val(result.id);
            var userRes = data.res;
            var allUsers =data.all;
            var userIDList = '';

            userIDList = userIDList + '<table class="table  text-nowrap w-70">';
            $.each(allUsers, function (index, value) { //All 3 tables -user_group_map,user_category,user_profile
                var fullname = value.fullname.split('|');
                console.log("fullname"+fullname);

                var user_p_id = value.user_p_id.split('|');
                userIDList = userIDList + '<tr>';
                userIDList = userIDList + '<td>';
                userIDList = userIDList + value.category_name;
                userIDList = userIDList + '</td>';
                userIDList = userIDList + '</tr>';
                userIDList = userIDList + '<tr>';
                for (var k=0;k<data.res.length;k++) {
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
                    if (i % 3 == 0) {
                        userIDList =userIDList + '</tr>';
                    }
                }
            });
            userIDList = userIDList + '</table>';
            console.log("result" + JSON.stringify(result));
            $('#showchkBoxes').html(userIDList);
            $('#hidechkBoxes').hide();
            $('#showchkBoxes').show();
            $("#groupName").val(result.group_name);
            $("#groupCode").val(result.group_code);
            $('.empGrpSave').show();
            $('.load-edit-EmpGroup').html('');
        }
    });

});
//DELETE EmpGroup
$(document).on("click", "#confirmEmpGroupDelete", function (e) {
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
            deleteEmpGroup(id);
        }
    });
});

function deleteEmpGroup(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.delEmpGroup' + id).html(loading_icon);
    $('.empGrpSave').hide();

    $.ajax({
        url: base_url + '/delete-EmpGroup',
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
                    message: "Employees Group has been deleted successfully",
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
//END OF DELETE Employees Group

