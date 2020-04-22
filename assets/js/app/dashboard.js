    var userTable;
    var deletedId;
    var action;
    var ptipe;
    $(document).ready(function() {
        
        var date = new Date();
        date.setDate(date.getDate()-1);
        
        $("#printBtn").click(function (){
            print_kw();
        });
        
          $.ajax({
                url : site_url+"dashboard/data",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    reload_table();
                    $('#modal-confirm').modal('hide');
                }
            });
        
              $.ajax({
                url : site_url+"dashboard/data",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   
                    var mydata = data.try_data;
                    var barChartData = {
                    labels : ["Jan","Feb","March","April","May","June","July","Aug","Sep","Okt","Nop","Des"],
                    datasets : [
                                    {
                                            fillColor : "rgba(255, 255, 255, 1)",
                                            strokeColor : "rgba(255, 0, 0, 0.9)",
                                            highlightFill: "#e94e02",
                                            highlightStroke: "#e94e02",
                                            data : mydata
                                    }
                            ]

                    };
                    new Chart(document.getElementById("bar_pupuk").getContext("2d")).Line(barChartData,{
                        maintainAspectRatio: true,
                        type: 'line',
                        options: {
                            responsive: true
                        }
                    });
                }
            });  
        
        
       $('#tipe').change(function (){
           userTable.ajax.url( site_url + "dashboard/view/" + this.value).load();
       });
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"dashboard/view/"+$('#tipe').val(),
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [3, 4, 5] }
            ],
        } );
        
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"dashboard/lunas/"+ptipe+"/"+deletedId ,
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
    
    function lunas(id, tipe){
        deletedId = id;
        ptipe = tipe;
        $('#modal-confirm').modal('show');
    }
    
   