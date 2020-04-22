    var userTable;
    var deletedId;
    var action = "Add";
    $(document).ready(function() {
        
     
       total_jual($("#no_pembelian").val());
       
      
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"d_pembeliana/view/"+$("#no_pembelian").val(),
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [2,3,4] }
            ],
        } );
        
       
       
    } );
    

    
     function total_jual(id){
         $.ajax({
                url : site_url+"a_pembelian/get_total_jual/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(resp)
                {
                    var total = resp.total;
                    $('#totalTxt').text(resp.total);
                }
            });
    }
    
   