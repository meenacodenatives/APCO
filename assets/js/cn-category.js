var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';
$(document).ready(function(){
    $('.tip').tooltip({
      delay:{ "show": 600, "hide": 100 },
      title:"<strong>This title is from JavaScript.</strong> It is defined as a tooltip option.",
      html:true,
  }); 
  });
$('#cat').click(function() {
    $('.showTitle').text('New Category');
    $('#catName').val('');
    $('#catCode').val('');
    $('#catDesc').val('');
    $('#pCategory').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.users-invalid').removeClass('users-invalid');
    $.ajax({
        url: base_url + '/getParentCategory',
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            var result = data.parentCategories;
            $('#load-category').hide();
            $("#pCategory").val(result);
        }
    });
});

$('.closeModal').click(function(){
    $('#addCat').modal("hide");
});
//URL Validation
function createCategory() {
    var data = {}
    data.name = $('#catName').val();
    data.code = $('#catCode').val();
    data.description = $('#catDesc').val();
    data.parent_category = $('#pCategory').val();
    data.id=$('#cat_id').val();
    console.log("id==" + data.id);

    $('.is-invalid').removeClass('is-invalid');
    //Validation
    var err = 0;
    if ($("#catName").val() == '') {
        $('#catName').addClass('is-invalid');
        err++;
    }
    if ($("#catCode").val() == '') {
        $('#catCode').addClass('is-invalid');
        err++;
    }
    if ($("#catDesc").val() == '') {
        $('#catDesc').addClass('is-invalid');
        err++;
    }

    // if ($("#pCategory").val() == '') {
    //     $('#pCategory').addClass('is-invalid');
    //     err++;
    // }

    if (err > 0) {
        return false;
    } else {
        console.log("CATE" + JSON.stringify(data));
        $('.categorySave').hide();
        $('#load-category').html(loading_icon);
    }

    $.ajax({
        url: base_url + '/storeCategory',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: data
        },
        dataType: 'JSON',
        success: function(data) {
            $("#addCat").modal("hide");
            if (data.status == 1) { //success login
                $.growl({
                    title: "",
                    message: "Category has been saved successfully",
                    duration: "3000",
                    location: "tr",
                    style: "notice"
                });
                setTimeout(function() {
                    window.location.href = base_url + '/showCategory';
                }, 2000);
            } else if (data.status == 3) { //name exist already
                $.growl({
                    title: "",
                    message: "Entered name already exist",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('#catName').addClass('is-invalid');
                $('.categorySave').show();
                $('#load-category').html('');
            }else { //error
                $.growl({
                    title: "",
                    message: "Error! Please try again",
                    duration: "3000",
                    location: "tr",
                    style: "error"
                });
                $('.categorySave').show();
                $('#load-category').html('');
            }
        }

    });
}
//EDit Category
$(document).on("click", "#confirmCatEdit", function(e) {
    $('.load-edit-category').show();
    $('.load-edit-category').html(loading_icon);
    
    var id = $(this).data('id');
    console.log("TEST"+id);
    $("#addCat").modal("show");
    var title = 'Edit Category';
    $('.showTitle').text(title);
    $('.hideForm').hide();
    $.ajax({
        url: base_url + '/edit-category/' +id,
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            var result = data.category;
            $('.load-edit-category').hide();
            $('.hideForm').show();
            console.log("result"+JSON.stringify(result));
                $('#cat_id').val(result.id);
                $("#catName").val(result.name);
                $("#catCode").val(result.code);
                $("#catDesc").val(result.description);
                $("#pCategory").val(result.parent_category);
                $('.categorySave').show();
                $('.load-edit-category').html('');
        }
    });

});
//DELETE Category

$(document).on("click", "#confirmCatDelete", function(e) {

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
            deleteCat(id);
        }
    });
});

function deleteCat(id) {
    var data = {}
    data.id = id;
    $('.ubtn' + id).hide();
    $('.delcat' + id).html(loading_icon);
    $('.categorySave').hide();

    $.ajax({
        url: base_url + '/delete-category',
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
                    message: "Category has been deleted successfully",
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
//END OF DELETE Category

