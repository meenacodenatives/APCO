$(function(e) {
	
	//Data-table1

    $('#data-table1').DataTable({
			"order": [],
			'columnDefs': [ {
				'targets': [0,1,2,3,5], /* column index */
				'orderable': false, /* true or false */
			 }]
      });	
	//Data-table2
	var table = $('#data-table2').DataTable();
	$('button').click( function() {
		var data = table.$('input, select').serialize();
		// alert(
		// 	"The following data would have been submitted to the server: \n\n"+
		// 	data.substr( 0, 120 )+'...'
		// );
		return false;
	});
	
	//Data-table3
	$('#data-table3').DataTable( {
		"order": [],
	    responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                    return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table',
					
                } )
            }
        }
    } );
	$("#table-sortable").DataTable({
		"order": [],
			'columnDefs': [ {
				'targets': [2,3,4,5,6], /* Not need sortable column index */
				'orderable': false, /* true or false */
			 }]

    }); 
	$("#RFQDataTable").DataTable({
		"order": [],
			'columnDefs': [ {
				'targets': [2,3,4,5,6,7], /* Not need sortable column index */
				'orderable': false, /* true or false */
			 }]

    }); 
	$("#productDataTable").DataTable({
		"order": [],
			'columnDefs': [ {
				'targets': [2,3,4,5,6,7], /* Not need sortable column index */
				'orderable': false, /* true or false */
			 }]

    }); 
	$("#commonDataTable").DataTable({
		"order": [],
	    responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                    return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table',
					
                } )
            }
        }
    }); 
	//Export Data-table
	var table = $('#exportexample').DataTable( {
		lengthChange: false,
		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
	} );
	table.buttons().container()
	.appendTo( '#exportexample_wrapper .col-md-6:eq(0)' );
});