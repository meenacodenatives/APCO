var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var loading_icon = '<img class="load-icon" src=' + base_url + '/assets/images/brand/loader.gif>';

$(function() {
    $('.mfg_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '2019:+10' 
    });
    $('.expiry_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '2021:+10'
    });
    $('#category').select2({
        filter: true
    })
    $('#searchProduct_name').select2({
        filter: true
    })
});



