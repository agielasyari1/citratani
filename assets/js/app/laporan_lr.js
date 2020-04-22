    var userTable;
    var userTable2;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        $('#bulan').val(t_month);
        
//        $.ajax({
//            url : site_url+"laporan_lr/daftar_tahun",
//            type: "GET",
//            dataType: "JSON",
//            success: function(data)
//            {
//                $.each(data, function(key, value){
//                        $('#tahun').append("<option value='"+key+"'>"+value+"</option>");
//                });
//                $('#tahun').val(t_year);
//            },
//            error: function (jqXHR, textStatus, errorThrown)
//            {
//                alert('Error deleting data');
//            }
//        });  
        
        userTable = $('#example').DataTable({ 
            "pageLength": "All",
            dom: 'Brt',
            buttons: [
                {
                    extend: 'print',
                    message: 'Laporan Laba Rugi'
                },
                'excelHtml5'
            ],
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"laporan_lr/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, 1, 2, 3, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [2, 3] }
            ],
        } );
    
       
        $("#okBtn").on('click', function (){
            //alert($("#tahun").val());
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();
            userTable.ajax.url( site_url + "laporan_lr/view/" + bulan + "/" + tahun).load();
           
        });
       
        
    } );
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 

   