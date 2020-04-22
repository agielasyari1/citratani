var userTable;
    var userTable2;
    var deletedId;
    var action;
    $(document).ready(function() {
       
        $('#range').daterangepicker(
        {
            autoUpdateInput: false,
            showDropdowns: true,
            opens: "center",
            locale: {
              cancelLabel: 'Clear'
            },
            ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             }
        }
        );
        
         $('#range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

        $('#range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
          });
        
        
        userTable = $('#example').DataTable({ 
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    message: 'Laporan Penjualan'
                },
                'excelHtml5'
            ],
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"laporan_jual/view_pj",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [3,4,5] }
            ],
        } );
    
        
        
        
        $("#okBtn").on('click', function (){
            //alert($("#range").val());
            
            var range = $("#range").val();
            var res = range.split(" - ");
            if(res != ""){
                userTable.ajax.url( site_url + "laporan_jual/view_pj/" + res[0] + "/" + res[1]).load();
                total_table("ecer", res[0], res[1]);
            }else{
                alert("Pilih tipe dan tanggal!");
            }
            
        });
       
        
    } );
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
    function total_table(jenis, awal, akhir){
        
        $.ajax({
            url : site_url+"laporan_jual/total_table_jual/" + jenis + "/" + awal + "/" +akhir,
            type: "POST",
            data: {'tipe' : jenis, 'awal': awal, 'akhir': akhir},
            dataType: "JSON",
            success: function(data)
            {
                
                $("#tt").text(data.tt);
                $("#tp").text(data.tp);
                $("#ts").text(data.ts);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });  
    }
   