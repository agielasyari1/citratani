    var userTable;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        var date = new Date();
        date.setDate(date.getDate()-1);
        
        $("#printBtn").click(function (){
            print_kw();
        });
        
        
        $("#addBtn").click(function (){
           window.location = site_url+"d_pembeliana/pembelian_baru";
        });
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"a_pembelian/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, 8, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [4,5,6,7] }
            ],
        } );
        
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"a_pembelian/delete/"+deletedId ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    reload_table();
                    $('#modal-confirm').modal('hide');
                }
            });
        });
        
        
    } );
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
    function del(id){
        deletedId = id;
        $('#modal-confirm').modal('show');
    }
    
   function detail(id){
        window.location = site_url+"d_pembeliana/view_detail/"+id;
    }
    
    function print_kw(id){
        window.open(site_url+"print_kw/p_kuitansi/"+id);
    }