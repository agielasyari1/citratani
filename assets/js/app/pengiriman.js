var userTable;
    var userTable2;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        userTable = $('#example').DataTable({ 
            
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"dashboard/view/kirim",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [3] }
            ],
        } );
    
      
        
    } );
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
  
   